<?php
function url_for_blog($blog) {
	if ($blog->name == 'blog')
		return url_for('blog');
	else
		return url_for($blog);
}
function plural_link($post, $noun, $count) {
	$url = url_for($post) . '#' . $noun . 's';
	if ($count == 0)
		$text = 'no ' . $noun . 's';
	else if ($count == 1)
		$text = '1 ' . $noun;
	else
		$text = $count . ' ' . $noun . 's';
	return link_text($url, $text);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?=$title?></title>
	<link rel="stylesheet" href="<?=$skin_dir?>/blog.css" type="text/css" />
<? if (isset($board)) { ?>
	<link rel="alternate" href="<?=url_for($board, 'rss')?>" type="application/rss+xml" title="RSS" />
<? } ?>
	<script type="text/javascript" src="<?=$skin_dir?>/script.js"></script>
</head>
<body>
<div id="container">
	<div id="header">
		<h1><span><a href="<?=url_for_blog($board)?>"><?=$board->title?></a></span></h1>
	</div>

	<div id="page">
		<div id="content">
