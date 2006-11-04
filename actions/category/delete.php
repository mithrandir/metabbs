<?php
$board = $category->get_board();
$category->delete();
redirect_to(url_for($board, 'edit', array('tab'=>'category')));

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
