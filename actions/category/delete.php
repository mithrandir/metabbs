<?php
if (!$account->is_admin()) {
	access_denied();
}
$category = Category::find($id);
$board = $category->get_board();
$category->delete();
redirect_to(url_for($board, 'edit', array('tab'=>'category')));
?>
