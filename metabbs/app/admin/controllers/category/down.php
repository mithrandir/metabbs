<?php
$board = $category->get_board();
$category->move_lower();
redirect_to(url_admin_for($board, 'edit', array('tab'=>'category')));
?>