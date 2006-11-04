<?php
if (isset($_GET['board_id'])) {
	$board = Board::find($_GET['board_id']);
}


// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
