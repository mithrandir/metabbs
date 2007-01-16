<?php
if (isset($_GET['board_id'])) {
	$board = Board::find($_GET['board_id']);
}
?>
