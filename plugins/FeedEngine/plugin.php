<?php
function requireCoreofPlugin($plugin, $name) {
	global $_requireCore;
	if(!in_array($name,$_requireCore)) {
		include_once (METABBS_DIR . "/plugins/$plugin/$name.php");
		array_push($_requireCore,$name);
	}
}
function requireModelofPlugin($plugin, $name) {
	global $_requireModels;
	if(!in_array($name,$_requireModels)) {
		include_once (METABBS_DIR . "/plugins/$plugin/app/models/$name.php");
		array_push($_requireModels,$name);
	}
}
requireModelofPlugin('FeedEngine','feed');
requireModelofPlugin('FeedEngine','feed_user');
requireModelofPlugin('FeedEngine','feed_board');
requireModelofPlugin('FeedEngine','group');
requireModelofPlugin('FeedEngine','group_post');
requireCoreofPlugin('FeedEngine','feed_parser');
//require METABBS_DIR . '/plugins/FeedEngine/lang/ko.php';

class FeedEngine extends Plugin {
	var $plugin_name = '피드엔진';
	var $description = '게시판을 타켓으로 피드를 등록하고, 모읍니다.';

	function on_init() {
		ini_set("include_path", dirname(__FILE__) . PATH_SEPARATOR . ini_get("include_path"));

		add_filter('PostFinderFields', array(&$this, 'post_finder_fields_filter'), 257);
		add_filter('PostFinderConditions', array(&$this, 'post_finder_conditions_filter'), 257);
		add_filter('PostDelete', array(&$this, 'post_delete_filter'), 257);
		add_filter('UserDelete', array(&$this, 'user_delete_filter'), 257);
		add_filter('PostViewRSS', array(&$this, 'post_view_rss_filter'), 500);
		add_filter('GetSearchParams', array(&$this, 'get_search_params'), 500);
//		add_filter('PostList', array(&$this, 'post_list_filter'), 500);



		add_admin_menu(url_admin_for('feedengine'), 'Feed Engine');
	}

	function post_finder_fields_filter(&$fields) {
		$fields .= ", body, feed_id, feed_link, feed_fp ";
	}
	function post_finder_conditions_filter(&$condtions, $board) {
		global $account;
		if($board->get_attribute('feed-at-board') && !$account->is_admin()) {
			$condtions .= " AND secret = 0 ";
		}
		if (isset($_GET['group']) && $_GET['group']) {
			$group = Group::find($_GET['group']);
			$condition = " 0";			
			if($group->exists()) {
				$result = $this->db->query("SELECT post_id FROM ".get_table_name('group_post')." WHERE group_id = $group->id");
				$ids = array();
				if ($result->count()) {
					while ($data = $result->fetch()) {
						$ids[] = $data['post_id'];
					}
					$condition = " id IN (".implode(',', $ids).")";
				}
			}
			$condtions .= " AND ( $condition )";
		}
	}
	function post_view_rss_filter(&$post) {
		$board = $post->get_board();
		if($board->get_attribute('feed-at-board')) {
			$post->permalink = $post->feed_link;
			// body도 처리?
		}
	}
	function user_delete_filter(&$user) {

		//user가 지워졌을때 feed_user 삭제
		FeedUser::delete_by_user($user);
		//feed에서 owner_id를 0으로
		$db = get_conn();
		$feed_table = get_table_name('feed');
		$user->db->execute("UPDATE $feed_table SET owner_id = 0 WHERE owner_id=$user->id");
	}
	function post_delete_filter(&$post) {

		// post가 지워졌을때 group_post 삭제
		GroupPost::delete_by_post($post);
	}
	function get_search_params(&$keys) {
		$keys[] = 'group';
	}

	function on_settings() {
?>
<h2><?=i('Usages')?></h2>
<?php
	}

	function on_install() {
		$conn = get_conn();

		$t = new Table('feed');
		$t->column('url', 'string', 255);
		$t->column('link', 'string', 255);
		$t->column('title', 'string', 255);
		$t->column('description', 'longtext');
		$t->column('owner_id', 'integer');
		$t->column('owner_name', 'string', 255);
		$t->column('active', 'ushort');
		$t->column('created_at', 'timestamp');
		$t->column('updated_at', 'timestamp');
//		$t->column('introduction', 'longtext');
		$t->add_index('link');
		$t->add_index('title');
		$conn->add_table($t);

		$t = new Table('feed_user');
		$t->column('user_id', 'integer');
		$t->column('feed_id', 'integer');
		$t->column('position', 'integer');
		$t->column('is_member', 'ushort');
		$t->column('created_at', 'timestamp');
		$t->add_index('user_id');
		$t->add_index('feed_id');
		$conn->add_table($t);

		$t = new Table('group');
		$t->column('board_id', 'integer');
		$t->column('name', 'string', 45);
		$t->column('position', 'integer');
		$t->column('tags', 'longtext');
		$t->column('created_at', 'timestamp');
		$t->column('updated_at', 'timestamp');
		$t->add_index('board_id');
		$conn->add_table($t);

		$t = new Table('group_post');
		$t->column('group_id', 'integer');
		$t->column('post_id', 'integer');
		$t->column('created_at', 'timestamp');
		$t->add_index('group_id');
		$t->add_index('post_id');
		$conn->add_table($t);

		$conn->add_field('post', 'feed_id', 'integer');
		$conn->add_field('post', 'feed_link', 'longtext');
		$conn->add_field('post', 'feed_fp', 'string', 64);
		$conn->add_index('post', 'feed_id');

		$t = new Table('feed_board');
		$t->column('feed_id', 'integer');
		$t->column('board_id', 'integer');
		$t->column('created_at', 'timestamp');
		$t->add_index('feed_id');
		$t->add_index('board_id');
		$conn->add_table($t);

		mkdir('data/feed_cache');
		mkdir('data/feed_log');
		chmod('data/feed_cache', 0707);
		chmod('data/feed_log', 0707);
	}

	function on_uninstall() {
		$conn = get_conn();
		$conn->drop_field('post', 'feed_fp');
		$conn->drop_field('post', 'feed_link');
		$conn->drop_field('post', 'feed_id');

		$conn->drop_table('feed_board');
		$conn->drop_table('group_post');
		$conn->drop_table('group');
		$conn->drop_table('feed_user');
		$conn->drop_table('feed');

		rmdir('data/feed_cache');
		rmdir('data/feed_log');
	}
}

register_plugin('FeedEngine');
?>
