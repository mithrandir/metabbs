<?php
// constant METABBS_BASE_PATH required!
if (isset($_GET['redirect'])) { // backward compatibility
	define("METABBS_BASE_URI", METABBS_BASE_PATH);
}
require_once(dirname(__FILE__).'/core/common.php');

if (!isset($layout)) $layout = new Layout;
import_enabled_plugins();
apply_filters('LayoutAtSiteManager', $layout);

/**
 * 외부 페이지를 위한 API
 */
class SiteManager
{
	/**
	 * 피드 링크 태그의 내용
	 */
	var $feed_link = 'RSS';

	/**
	 * 생성자. 현재 사용자 객체를 가져온다.
	 */
	function SiteManager() {
		$this->user = UserManager::get_user();
	}

	/**
	 * 로그인 여부를 확인한다.
	 * @return 비회원일 경우 true를 리턴한다.
	 */
	function isGuest() {
		return $this->user == null || $this->user->is_guest();
	}

	/**
	 * 로그인 폼을 출력한다.
	 */
	function printLoginForm() {
?>
<form method="post" action="<?=url_with_referer_for("account", "login")?>">
<div><label>User ID</label><input id="meta-login-id" type="text" name="user" /></div>
<div><label>Password</label><input id="meta-login-password" type="password" name="password" /></div>
<div><input id="meta-login-submit" type="submit" value="Login" /></div>
</form>
<?php
	}

	/**
	 * 최근 글 목록을 가져온다.
	 * @param $board_name 게시판 이름
	 * @param $count 개수
	 * @return 최근 글을 지정한 개수만큼 리턴한다. 
	 */
	function getLatestPosts($board_name, $count) {
		$board = Board::find_by_name($board_name);
		$posts = $board->get_feed_posts($count);
		apply_filters_array('PostList', $posts);
		return $posts;
	}

	/**
	 * 최근 글 하나를 가져온다.
	 * @param $board_name 게시판 이름
	 * @return 최근 글 하나를 리턴한다.
	 */
	function getLatestPost($board_name) {
		$board = Board::find_by_name($board_name);
		@list($post) = $board->get_feed_posts(1);
		if ($post->secret) $post->body = "";
		apply_filters('PostView', $post);
		return $post;
	}

	/**
	 * <head> 태그에 들어갈 내용을 출력한다.
	 */
	function printHead() {
		global $layout;
		if (isset($layout) && is_a($layout, 'Layout'))
			$layout->print_head();
	}

	/**
	 * 최근 글 목록을 출력한다.
	 * @param $board_name 게시판 이름
	 * @param $count 글의 개수
	 * @param $title_length 제목 길이 제한
	 */
	function printLatestPosts($board_name, $count, $title_length = -1) {
		$board = Board::find_by_name($board_name);
?>
<div id="latest-<?=$board_name?>" class="latest-posts">
<div class="board-title"><?=link_to(htmlspecialchars($board->title), $board)?> <span class="feed"><?=link_to($this->feed_link, $board, 'rss')?></span></div>
<ul>
<? foreach ($this->getLatestPosts($board_name, $count) as $post) {
	if ($title_length > 0) $post->title = utf8_strcut($post->title, $title_length);
?>
	<li>[<?=$post->name?>] <a href="<?=url_for($post)?>"><?=$post->title?></a> <span class="comment-count"><?=link_to_comments($post)?></span></li>
<? } ?>
</ul>
</div>
<?php
	}

	/**
	 * 여러 게시판에서 최근 글 목록을 가져온다.
	 * @param $boards 게시판 이름의 배열
	 * @param $count 글의 개수
	 */
	function getMetaLatestPosts($boards, $count) {
		$db = get_conn();
		$query = "SELECT p.* FROM ".get_table_name('board')." b, ".get_table_name('post')." p WHERE b.id=p.board_id AND b.name IN ('".implode("','", $boards)."') ORDER BY p.id DESC LIMIT $count";
		return $db->fetchall($query, 'Post');
	}

	/**
	 * 여러 게시판의 최근 글 목록을 출력한다.
	 * @param $boards 게시판 이름의 배열
	 * @param $count 글의 개수
	 * @param $title_length 제목 길이 제한
	 */
	function printMetaLatestPosts($boards, $count, $title_length = -1) {
		$posts = $this->getMetaLatestPosts($boards, $count);
		apply_filters_array('PostList', $posts);
?>
<div id="latest-meta" class="latest-posts">
<ul>
<? foreach ($posts as $post) {
	$post->board = $post->get_board();
	if ($title_length > 0) $post->title = utf8_strcut($post->title, $title_length);
?>
	<li>[<?=$post->name?>] <a href="<?=url_for($post)?>"><?=$post->title?></a> <span class="comment-count"><?=link_to_comments($post)?></span> @ <?=link_to($post->board->get_title(), $post->board)?></li>
<? } ?>
</ul>
</div>
<?php
	}
}

$GLOBALS['metabbs'] = new SiteManager;
?>
