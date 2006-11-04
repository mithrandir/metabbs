<?php
// constant METABBS_BASE_PATH required!
if (isset($_GET['redirect'])) { // backward compatibility
	define("METABBS_BASE_URI", METABBS_BASE_PATH);
}
require_once(dirname(__FILE__).'/lib/common.php');
class MetaBBS
{
	var $feed_link = 'RSS';
	function MetaBBS() {
		$this->user = UserManager::get_user();
	}
	function isGuest() {
		return $this->user == null || $this->user->is_guest();
	}
	function printLoginForm() {
?>
<form method="post" action="<?=url_with_referer_for("account", "login")?>">
<label>User ID</label><input id="meta-login-id" type="text" name="user" /><br />
<label>Password</label><input id="meta-login-password" type="password" name="password" /><br />
<input id="meta-login-submit" type="submit" value="Login" />
</form>
<?php
	}
	function getLatestPosts($board_name, $count) {
		$board = Board::find_by_name($board_name);
		return $board->get_feed_posts($count);
	}
	function getLatestPost($board_name) {
		@list($post) = $this->getLatestPosts($board_name, 1);
		return $post;
	}
	function printHead() {
		global $_skin_dir, $skin_dir;
		if (isset($_skin_dir)) {
			include($_skin_dir . '/_head.php');
		}
	}
	function printLatestPosts($board_name, $count) {
		$board = Board::find_by_name($board_name);
?>
<div id="latest-<?=$board_name?>" class="latest-posts">
<div class="board-title"><?=link_to(htmlspecialchars($board->title), $board)?> <span class="feed"><?=link_to($this->feed_link, $board, 'rss')?></span></div>
<ul>
<? foreach ($board->get_feed_posts($count) as $post) { ?>
	<li>[<?=htmlspecialchars($post->name)?>] <?=link_to_post($post)?> <span class="comment-count"><?=link_to_comments($post)?></span></li>
<? } ?>
</ul>
</div>
<?php
	}
}
$metabbs = new MetaBBS;

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
