<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?=$layout->title?></title>
	<?php $layout->print_head(); ?>
<? if (isset($board)) { ?>
	<link rel="alternate" href="<?=url_for($board, 'rss')?>" type="application/rss+xml" title="RSS" /> 
<? } ?>
</head>
<body>