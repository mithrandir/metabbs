<?php
$board = $category->get_board();
$category->delete();
redirect_to(url_for($board, 'edit', array('tab'=>'category')));
?>
