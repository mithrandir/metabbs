<?php
if (substr($base_path, 0, -1) != '/') {
	$base_path .= '/';
}
require_once('lib/common.php');
class MetaBBS
{
	var $feed_link = 'RSS';
	function MetaBBS() {
		$this->user = UserManager::get_user();
	}
	function isGuest() {
		return $this->user == null;
	}
	function printLoginForm() {
?>
<form method="post" action="<?=url_with_referer_for("account", "login")?>">
<label>User ID</label> <input type="text" name="user" /><br />
<label>Password</label> <input type="password" name="password" /><br />
<input type="submit" value="Login" />
</form>
<?php
	}
	function getLatestPosts($board_name, $count) {
		$board = Board::find_by_name($board_name);
		return $board->get_posts(0, $count);
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
<? foreach ($board->get_posts(0, $count) as $post) { ?>
	<li>[<?=htmlspecialchars($post->name)?>] <?=link_to_post($post)?> <span class="comment-count"><?=link_to_comments($post)?></span></li>
<? } ?>
</ul>
</div>
<?php
	}
}
$metabbs = new MetaBBS;
?>
