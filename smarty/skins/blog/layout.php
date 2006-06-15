<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?=$board->title?></title>
	<link rel="stylesheet" href="<?php echo $skin_dir; ?>/blog.css" type="text/css" />
	<script type="text/javascript" src="<?php echo $skin_dir; ?>/script.js"></script>
</head>
<body>
<p><small><?php print_nav(get_account_control($user)); if (!$user->is_guest()) { echo ' | ' . link_to(i('New Post'), $board, 'post'); } ?></small></p>

<div id="head">
	<h1><? echo link_to($board->title, 'blog'); ?> <?php echo link_to(image_tag("$skin_dir/feed.png"), 'blog', 'rss'); ?></h1>
</div>

<div id="sidebar">
</div>

<div id="content">
	<?php echo $content; ?>
</div>
</body>
</html>
