<?php
if (is_post()) {
	$category->name = $_POST['new_name'];
	$category->update();
	redirect_to(url_for($category->get_board(), 'edit') . '?tab=category');
}
render('rename_category');

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
