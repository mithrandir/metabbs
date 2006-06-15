<?php
if (!$id) {
	$controller = 'notice';
	$action = 'board';
}
$board = Board::find_by_name($id);
if ($board->id == '') {
	echo '<h1>Board Not Found</h1>';
}
?>
