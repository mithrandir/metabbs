<?php
// constant METABBS_BASE_PATH required!
if (isset($_GET['redirect'])) { // backward compatibility
	define("METABBS_BASE_URI", METABBS_BASE_PATH);
}
require_once(dirname(__FILE__).'/lib/common.php');

/**
 * 써드 파티를 위한 API. 게시판의 정보를 제공한다.
 */
class MetaBBS
{
	/**
	 * 피드 주소를 결정한다.
	 */
	var $feed_link = 'RSS';

	/**
	 * 생성자. 유저 객체를 가져온다.
	 */
	function MetaBBS() {
		$this->user = UserManager::get_user();
	}

	/**
	 * 회원 여부를 확인한다.
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
<label>User ID</label><input id="meta-login-id" type="text" name="user" /><br />
<label>Password</label><input id="meta-login-password" type="password" name="password" /><br />
<input id="meta-login-submit" type="submit" value="Login" />
</form>
<?php
	}

	/**
	 * 지정한 개수만큼 최근 글을 가져온다.
	 * @param $board_name 게시판 명
	 * @param $count 개수
	 * @return 지정한 개수의 최신글을 리턴한다. 
	 */
	function getLatestPosts($board_name, $count) {
		$board = Board::find_by_name($board_name);
		return $board->get_feed_posts($count);
	}

	/**
	 * 가장 최근글 하나를 가져온다. 
	 * @param $board_name 게시판 명
	 * @return 가장 최근 글 하나를 리턴한다.
	 */
	function getLatestPost($board_name) {
		@list($post) = $this->getLatestPosts($board_name, 1);
		return $post;
	}

	/**
	 * <head> 태그 내용을 출력한다.
	 */
	function printHead() {
		global $_skin_dir, $skin_dir, $style_dir;
		$head_only = true;
		include('skins/default_header.php');
	}

	/**
	 * 가장 최근 글들의 목록을 출력한다.
	 * @param $board_name 게시판 명
	 * @param $count 글의 개수
	 * @param $title_length 제목의 길이
	 */
	function printLatestPosts($board_name, $count, $title_length = -1) {
		$board = Board::find_by_name($board_name);
?>
<div id="latest-<?=$board_name?>" class="latest-posts">
<div class="board-title"><?=link_to(htmlspecialchars($board->title), $board)?> <span class="feed"><?=link_to($this->feed_link, $board, 'rss')?></span></div>
<ul>
<? foreach ($board->get_feed_posts($count) as $post) {
	if ($title_length > 0) $post->title = utf8_strcut($post->title, $title_length);
?>
	<li>[<?=htmlspecialchars($post->name)?>] <?=link_to_post($post)?> <span class="comment-count"><?=link_to_comments($post)?></span></li>
<? } ?>
</ul>
</div>
<?php
	}
}

/**
 * 이 인스턴스를 이용하여 외부 프로그램에서 MetaBBS에 접근한다.
 */
$metabbs = new MetaBBS;
?>
