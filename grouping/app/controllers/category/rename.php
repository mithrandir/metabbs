<?php
if (is_post()) {
	$category->name = $_POST['new_name'];
	$category->update();
	redirect_to(url_for($category->get_board(), 'edit') . '?tab=category');
}
?>
