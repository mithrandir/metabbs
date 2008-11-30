<?php
if (isset($_GET['board_id'])) {
	$board = Board::find($_GET['board_id']);
}
$error_messages = new Message();
//$params = get_params();
?>
