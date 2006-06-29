<?php
if (substr($base_path, 0, -1) != '/') {
	$base_path .= '/';
}
require_once('lib/common.php');
class MetaBBS
{
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
	function printHeader() {
		global $skin_dir;
		if (isset($skin_dir)) {
			echo "<link rel=\"stylesheet\" href=\"$skin_dir/style.css\" />";
		}
	}
}
$metabbs = new MetaBBS;
?>
