<?php
$board = $user_; // XXX
$posts = $user_->get_posts((get_requested_page() - 1) * 10, 10);

render('user');
?>
