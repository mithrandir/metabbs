<?php
function url_for_blog($blog) {
	if ($blog->name == 'blog')
		return url_for('blog');
	else
		return url_for($blog);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?=$title?></title>
	<? include($_skin_dir . '/_head.php'); ?>
</head>
<body>
<p><? print_nav(get_account_control($account)); ?></p>

<div id="head">
	<h1><a href="<?=url_for_blog($board)?>"><?=$board->title?></a></h1>
</div>

<div id="content">
