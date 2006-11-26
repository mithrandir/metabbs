<?php
$boards = Board::find_all();
$boards = Board::correct_boards_name($boards);
?>
