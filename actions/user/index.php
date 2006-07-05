<?php
$posts = $user->get_posts((get_requested_page() - 1) * 10, 10);

render('user');
?>
