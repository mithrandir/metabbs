<?php
$board = $category->get_board();
$category->move_higher();
redirect_to(url_for($board, 'edit', array('tab'=>'category')));
?>