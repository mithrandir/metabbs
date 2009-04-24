<?php
require METABBS_DIR . '/plugins/FeedEngine/app/models/feed.php';
require METABBS_DIR . '/plugins/FeedEngine/app/models/feed_user.php';
require METABBS_DIR . '/plugins/FeedEngine/app/models/feed_board.php';
require METABBS_DIR . '/plugins/FeedEngine/app/models/group.php';
require METABBS_DIR . '/plugins/FeedEngine/app/models/group_post.php';
require METABBS_DIR . '/plugins/FeedEngine/feed_parser.php';
//require METABBS_DIR . '/plugins/FeedEngine/lang/ko.php';

class FeedEngine extends Plugin {
	var $plugin_name = '피드엔진';
	var $description = '게시판을 타켓으로 피드를 등록하고, 모읍니다.';

	function on_init() {
		ini_set("include_path", dirname(__FILE__) . PATH_SEPARATOR . ini_get("include_path"));

		add_filter('PostFinderFields', array(&$this, 'post_fineder_fields_filter'), 257);
		add_filter('PostFinderConditions', array(&$this, 'post_fineder_conditions_filter'), 257);
		add_filter('PostDelete', array(&$this, 'post_delete_filter'), 257);
		add_filter('UserDelete', array(&$this, 'user_delete_filter'), 257);
		add_filter('PostViewRSS', array(&$this, 'post_view_rss_filter'), 500);
		add_filter('GetSearchParams', array(&$this, 'get_search_params'), 500);
//		add_filter('PostList', array(&$this, 'post_list_filter'), 500);
	}

	function post_fineder_fields_filter(&$fields) {
		$fields .= ", body, feed_id, feed_link, feed_fp ";
	}
	function post_fineder_conditions_filter(&$condtions, $board) {
		global $account;
		if($board->get_attribute('feed-at-board') && !$account->is_admin()) {
			$condtions .= " AND secret = 0 ";
		}
		if (isset($_GET['group']) && $_GET['group']) {
			$group = Group::find($_GET['group']);
			if($group->exists()) {
				$result = $this->db->query("SELECT post_id FROM ".get_table_name('group_post')." WHERE group_id = $group->id");
				$ids = array();
				if ($result->count()) {
					while ($data = $result->fetch()) {
						$ids[] = $data['post_id'];
					}
					$condition = " id IN (".implode(',', $ids).")";
				} else {
					$condition = " 0";
				}
			} else {
				$condition = " 0";
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
		if(!isset($_GET['tab'])) $_GET['tab'] = 'general';
		$fp = new FeedParser();
		$error_messages = new Notice();

		if ($_GET['tab'] == 'general') {
			if (isset($_GET['feed-at-board']) && !empty($_GET['feed-at-board'])) {
				$board = Board::find_by_name($_GET['feed-at-board']);
				$board->set_attribute('feed-at-board', $board->get_attribute('feed-at-board') ? false : true);
				Flash::set('수정했습니다');
				redirect_to('?tab=general');
			}
			if (isset($_GET['feed-range']) && !empty($_GET['feed-range'])) {
				$board = Board::find_by_name($_GET['feed-range']);
				$feed_range = $board->get_attribute('feed-range');
				$feed_range ++;
				if ($feed_range > 3)
					$feed_range = 0;

				$board->set_attribute('feed-range', $feed_range);
				Flash::set('수정했습니다');
				redirect_to('?tab=general');
			}

			if (isset($_GET['collect-feed']) && !empty($_GET['collect-feed'])) {
				// purge feed cache
				$files = scandir(METABBS_DIR . '/data/feed_cache');
				foreach($files as $file) {
					if ($file == '.' || $file == '..') continue;
					@unlink(METABBS_DIR . '/data/feed_cache/' . $file);
				}

				$board = Board::find_by_name($_GET['collect-feed']);
				FeedParser::collect_feeds_to_board($board);
				Flash::set('수정했습니다');
				redirect_to('?tab=general');
			}
			if (isset($_GET['feed-kind']) && !empty($_GET['feed-kind'])) {
				$board = Board::find_by_name($_GET['feed-kind']);
				$feed_kind = $board->get_attribute('feed-kind');
				$feed_kind ++;
				if ($feed_kind > 2)
					$feed_kind = 0;

				$board->set_attribute('feed-kind', $feed_kind);
				Flash::set('수정했습니다');
				redirect_to('?tab=general');
			}
			if (isset($_GET['feed-tags']) && !empty($_GET['feed-tags'])) {
				$board = Board::find_by_name($_GET['feed-tags']);
				$tags = array_trim(explode(",",$_POST['value']));
				$board->set_attribute('tags', implode(',', $tags));
				Flash::set('수정했습니다');
				redirect_to('?tab=general');
			}
		}
//--------------------------------------------------------
		if ($_GET['tab'] == 'feed') {
			if (is_post()) {
				if (isset($_GET['owner']) && is_numeric($_GET['owner'])) {
					$feed = Feed::find($_GET['owner']);
					$owner = User::find_by_user($_POST['value']);
					if ($owner->exists()) {
						$feed->remove_attribute('trackback-key');
						$feed->owner_id = $owner->id;
					} else {
						$feed->set_attribute('trackback-key', md5(microtime() . uniqid(rand(), true)));
						$feed->owner_id = 0;
					}
					$feed->update();
					redirect_to('?tab=feed');
				} else if (isset($_GET['owner-name']) && is_numeric($_GET['owner-name'])) {
					$feed = Feed::find($_GET['owner-name']);
					$feed->owner_name = $_POST['value'];
					$feed->update();
					redirect_to('?tab=feed');
				} else {
					$userid = $_POST['userid'];
					$user = User::find_by_user($userid);
					$ownerid = isset($_POST['as_owner']) && $_POST['as_owner'] == 1 ? $user->id:null;
					if ($user->exists()) {
						if (FeedParser::relate_feed_by_user($_POST['feed_url'], $user, false, $ownerid)) {
							Flash::set('피드가 등록되었습니다');
						} else {
							Flash::set('피드가 등록되지 않았습니다');
						}
					} else
						$error_messages->add('없는 사용자 아이디입니다', 'userid');
					redirect_to('?tab=feed');
				}
			}
			if (isset($_GET['active']) && is_numeric($_GET['active'])) {
				$feed = Feed::find($_GET['active']);
				$feed->active = !$feed->active;
//				$feed->hide_posts();
//				$feed->show_posts();
				$feed->update();
				Flash::set('수정했습니다');
				redirect_to('?tab=feed');
			}
			if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
				$feed = Feed::find($_GET['delete']);
				$feedboards = FeedBoard::find_all_by_feed($feed);
				foreach($feedboards as $feedboard)
					$feedboard->delete();
// 관련된 feed_group 지움

				$feed->delete();
				Flash::set('피드를 삭제했습니다');
				redirect_to('?tab=feed');
			}
		}
//--------------------------------------------------------
		if ($_GET['tab'] == 'board') {
			if (is_post()) {
				$new_feed_board = $_POST['feed_board'];
				if (!empty($new_feed_board['board_id']) && !empty($new_feed_board['feed_id'])) {
					$feed_board = new FeedBoard(array('board_id'=> $new_feed_board['board_id'], 'feed_id' => $new_feed_board['feed_id']));
					$feed_board->create();
					Flash::set('피드-게시판 관계를 생성했습니다');
					redirect_to('?tab=board');
				}
			}

			if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
				$feed_board = FeedBoard::find($_GET['delete']);
				$feed_board->delete();
				Flash::set('피드-게시판 관계를 생성했습니다');
				$msg = '피드-게시판 관계를 삭제했습니다.';
				redirect_to('?tab=board');
			}
		}
//--------------------------------------------------------
		if ($_GET['tab'] == 'group') {
			if (is_post()) {
				$new_group = $_POST['group'];
				if (!empty($new_group['board_id']) && !empty($new_group['name'])) {
					$tags = array_trim(explode(",",$new_group['tags']));
					$group = new Group(array('board_id'=> $new_group['board_id'], 'name' => $new_group['name'], 'tags'=> implode(',',$tags)));
					$group->create();
					Flash::set('그룹을 생성했습니다');
					redirect_to('?tab=group');
				}
				if (isset($_GET['rename']) && is_numeric($_GET['rename'])) {
					$group = Group::find($_GET['rename']);
					$group->name = $_POST['value'];
					$group->update();
					redirect_to('?tab=group');
				}
			}
			if (isset($_GET['up']) && is_numeric($_GET['up'])) {
				$group = Group::find($_GET['up']);
				$group->move_higher();
				redirect_to('?tab=group');
			}
			if (isset($_GET['down']) && is_numeric($_GET['down'])) {
				$group = Group::find($_GET['down']);
				$group->move_lower();
				redirect_to('?tab=group');
			}

			if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
				$group = Group::find($_GET['delete']);
				$group->delete();
				Flash::set('그룹을 삭제했습니다');
				redirect_to('?tab=group');
			}
		}
//--------------------------------------------------------
		if ($_GET['tab'] == 'cache_purge') {
			$files = scandir(METABBS_DIR . '/data/feed_cache');
			foreach($files as $file) {
				if ($file == '.' || $file == '..') continue;
				@unlink(METABBS_DIR . '/data/feed_cache/' . $file);
			}
			redirect_to('?tab=general');
		}
?>
<ul id="edit-section" class="tabs">
	<?=link_list_tab("?tab=general", 'general', i('General'))?>
	<?=link_list_tab("?tab=feed", 'feed', i('Feed'))?>
	<?=link_list_tab("?tab=board", 'board', i('Board'))?>
	<?=link_list_tab("?tab=group", 'group', i('Group'))?>
	<?//=link_list_tab("?tab=cache_purge", 'cache_purge', i('Cache Purge'))?>
</ul>
<?=flash_message_box()?>
<?=error_message_box($error_messages)?>
<script type="text/javascript">
function edit(id, url) {
	$(id).innerHTML = '&rarr; <form method="post" action="' + url + '"><input type="text" name="value" size="10" /></form>';
}
</script>
<?php
//--------------------------------------------------------
		if ($_GET['tab'] == 'general') {
			$boards = Board::find_all();
?>
<h2><?=i('Boards')?></h2>
<table>
<thead>
<tr>
	<th class="name"><?=i('Name')?></th>
	<th class="name"><?=i('Post Count')?></th>
	<th class="range"><?=i('Range')?></th>
	<th class="range"><?=i('Kind')?></th>
	<th class="feed-tags"><?=i('Feed Tags')?></th>
	<th class="actions"><?=i('Actions')?></th>
</tr>
</thead>
<tbody id="boards-body">
<?php
			foreach ($boards as $board) {
				switch($board->get_attribute('feed-range')) {
				case 0 :
					$feed_range_msg = 'All Feed';
					break;
				case 1 :
					$feed_range_msg = 'All Feed having Owner';
					break;
				case 2 :
					$feed_range_msg = 'Some Feed';
					break;
				case 3 :
					$feed_range_msg = 'Some Feed having Owner';
					break;
				}	
				switch($board->get_attribute('feed-kind')) {
				case 0 :
					$feed_kind_msg = 'Default';
					break;
				case 1 :
					$feed_kind_msg = 'By Some Tags';
					break;
				case 2 :
					$feed_kind_msg = 'Auto Grouping';
					break;
				}
?>
<tr>
	<td class="name"><?=$board->get_title()?> <span class="url"><?=url_for($board)?></span></td>
	<td class="post_count"><?=Feed::get_all_post_count($board)?></td>
	<td class="range"><? if($board->get_attribute('feed-at-board')) : ?><a href="?tab=general&feed-range=<?=$board->name?>"><?=$feed_range_msg?></a><? endif; ?></td>
	<td class="kind"><? if($board->get_attribute('feed-at-board')) : ?><a href="?tab=general&feed-kind=<?=$board->name?>"><?=$feed_kind_msg?></a><? endif; ?></td>
	<td class="feed-tags"><? if($board->get_attribute('feed-at-board')) : ?><?= $board->get_attribute('tags')?> <span id="feed-tags-<?=$board->id?>"></span><? endif; ?></td>
	<td class="actions">
	<?=link_to(i('Preview'), $board)?>
	| <a href="?tab=general&feed-at-board=<?=$board->name?>" onclick="return window.confirm('<?=i('Are you sure?')?>')" ><?=$board->get_attribute('feed-at-board') ? i('Don\'t Feed at Board') : i('Feed at Board') ?></a>
	<? if($board->get_attribute('feed-at-board')) : ?>
	| <a href="?tab=general&collect-feed=<?=$board->name?>"><?=i('Collect Feeds')?></a>
	| <a href="?tab=general&feed-tags=<?=$board->name?>" onclick="edit('feed-tags-<?=$board->id?>', this.href); return false"><?=i('Change Feed Tags')?></a>
	<? endif; ?>
	</td>  
</tr>
<?php
			} 
?>
</tbody>
</table>
<h3>Range</h3>
<ul>
	<li>All Feed : 전체</li>
	<li>All Feed having Owner: 소유자를 가지고 있는 전체</li>
	<li>Some Feed : 특정 피드(Board 메뉴)</li>
	<li>Some Feed having Owner : 소유자를 가지고 특정 피드(Board 메뉴)</li>
</ul>
<h3>Kind</h3>
<ul>
	<li>Default : 보통</li>
	<li>By Some Tags : 특정 태그만 받음(Feed Tags 설정)</li>
	<li>Auto Grouping : 다채널 자동 그룹핑(Group 메뉴)</li>
</ul>
<?php
		}
//--------------------------------------------------------
		if ($_GET['tab'] == 'feed') {
			$page = get_requested_page();
			$this->feeds = Feed::find_all();
//			$feeds_count = Feed::count();
//			$this->feeds = Feed::find_all(($page - 1) * 10, 10);
//			require METABBS_DIR . '/lib/page.php';
?>
<table>
<tr>
	<th><?=i('URL')?></th>
	<th><?=i('Feed URL')?></th>
	<th><?=i('Users')?></th>
	<th><?=i('Owner')?></th>
	<th><?=i('Owner Name')?></th>
	<th><?=i('Status')?></th>
	<th><?=i('Actions')?></th>
</tr>
<?php foreach ($this->feeds as $feed) { 
	$users = $feed->get_users();
	if(count($users) > 0)
		$first_user = $users[0];
	else
		$first_user = New Guest();
	$owner = User::find($feed->owner_id); ?>
<tr>
	<td><a href="<?=$feed->link?>" title="<?=$feed->title?>"><?=$feed->link?></a></td>
	<td><?=$feed->url?></td>
	<td><?= $first_user->exists() ? $first_user->name . "($first_user->user)" . ($feed->get_user_count() > 1 ? '외 ' . $feed->get_user_count() . '명':''): '' ?></td>
	<td><?=$owner->exists() ? $owner->name:''?><span id="owner-<?=$feed->id?>"></span></td>
	<td><?=$feed->owner_name ?><span id="owner-name-<?=$feed->id?>"></span></td>
	<td><?=$feed->is_active() ? i('Active') : i('Unactive') ?></td>
	<td><a href="?tab=feed&active=<?=$feed->id?>"><?=$feed->is_active() ? i('Unactive') : i('Active') ?></a>
	| <a href="?tab=feed&owner=<?=$feed->id?>" onclick="edit('owner-<?=$feed->id?>', this.href); return false"><?=i('Owner')?></a>
	| <a href="?tab=feed&owner-name=<?=$feed->id?>" onclick="edit('owner-name-<?=$feed->id?>', this.href); return false"><?=i('Owner Name')?></a>
	| <a href="?tab=feed&delete=<?=$feed->id?>"><?=i('Delete')?></a></td>
</tr>
<?php } ?>
</table>

<h3><?=i('Add')?></h3>
<form method="post" action="?tab=feed" enctype="multipart/form-data">
<dl>
	<dt><label><?=i('User ID')?></label></dt>
	<dd><input type="text" name="userid" size="30" />
	<input type="checkbox" name="as_owner" value="1"/> As Owner</dd>
</dl>
<dl>
	<dt><label><?=i('Feed URL')?></label></dt>
	<dd><input type="text" name="feed_url" size="50" /></dd>
</dl>
<p><input type="submit" value="Add" /></p>
</form>
<?php
		}
//--------------------------------------------------------
		if ($_GET['tab'] == 'board') {
			$feed_boards = FeedBoard::find_all();
			$boards = Board::find_all();
			$feeds = Feed::find_all();
?>
<table id="boards">
<tr>
	<th><?=i('Board')?></th>
	<th><?=i('URL')?></th>
	<th><?=i('Feed URL')?></th>
	<th><?=i('Actions')?></th>
</tr>
<? foreach($feed_boards as $feed_board): 
	$board = $feed_board->get_board(); 
	$feed = $feed_board->get_feed(); ?>
<tr>
	<td><?=$board->name ?></td>
	<td><?=$feed->link ?></td>
	<td><?=$feed->url ?></td>
	<td><a href="?tab=board&delete=<?=$feed_board->id?>"><?=i('Delete')?></a></td>
</tr>
<? endforeach; ?>
</table>
<form method="post" action="?tab=board">
<p><select name="feed_board[board_id]" >
<? foreach($boards as $board): ?>
	<? if($board->get_attribute('feed-at-board')): ?>
	<option value="<?=$board->id?>"><?=$board->name?></option>
	<? endif; ?>
<? endforeach; ?>
</select> 
<select name="feed_board[feed_id]" >
<? foreach($feeds as $feed): ?>
	<option value="<?=$feed->id?>"><?=$feed->title.'('.$feed->link.')'?></option>
<? endforeach; ?>
</select> <input type="submit" value="<?=i('Add Feed Board')?>" /></p>
</form>
<?php
		}
//--------------------------------------------------------
		if ($_GET['tab'] == 'group') {
			$groups = Group::find_all();
			$boards = Board::find_all();
?>
<table id="boards">
<tr>
	<th><?=i('Board')?></th>
	<th><?=i('Name')?></th>
	<th><?=i('Post count')?></th>
	<th><?=i('Tags')?></th>
	<th><?=i('Actions')?></th>
</tr>
<? foreach ($groups as $group) { 
	$board = $group->get_board(); ?>
<tr>
	<td class="board"><?=$board->name?> </td>
	<td class="name"><?=$group->name?> <span id="group-<?=$group->id?>"></span></td>
	<td class="post_count"><?=$group->get_post_count()?></td>
	<td class="tags"><?=$group->tags?></td>
	<td><a href="?tab=group&rename=<?=$group->id?>" onclick="edit('group-<?=$group->id?>', this.href); return false"><?=i('Rename')?></a> |
	<?= $group->is_first() ? i('Move up') : "<a href=\"?tab=group&up=".$group->id."\">".i('Move up')."</a>" ?> |
	<?= $group->is_last() ? i('Move down') : "<a href=\"?tab=group&down=".$group->id."\">".i('Move down')."</a>" ?> |
	<a href="?tab=group&delete=<?=$group->id?>" onclick="return window.confirm('<?=i('Are you sure?')?>')"><?=i('Delete')?></a>	</td>
</tr>
<? } ?>
</table>
<form method="post" action="?tab=group">
<p><select name="group[board_id]" >
<? foreach($boards as $board): ?>
	<? if($board->get_attribute('feed-at-board')): ?>
	<option value="<?=$board->id?>"><?=$board->name?></option>
	<? endif; ?>
<? endforeach; ?>
</select> <input type="text" name="group[name]" /> </p>
<p><input type="text" name="group[tags]" size="50"/> <input type="submit" value="<?=i('Add group')?>" /></p>
</form>
<?php
		}
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

/*	중간 업데이트분
		$conn = get_conn();
		$conn->add_field('feed', 'owner_name', 'string', 255);
		$conn->add_field('feed', 'active', 'ushort');

		$t = new Table('feed_board');
		$t->column('feed_id', 'integer');
		$t->column('board_id', 'integer');
		$t->column('created_at', 'timestamp');
		$t->add_index('feed_id');
		$t->add_index('board_id');
		$conn->add_table($t);*/
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
