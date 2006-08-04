<?php
if (!$account->is_admin()) {
	access_denied();
}
$category = new Category($id);
$board = $category->get_board();
$category->delete();
redirect_to(url_for($board, 'edit', array('tab'=>'category')));
?>
