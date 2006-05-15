<?php
if (!$id) {
    $controller = 'notice';
    $action = 'board';
}
$board = Board::find_by_name($id);
?>
