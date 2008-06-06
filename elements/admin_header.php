<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?=$title?></title>
	<?php $layout->print_head(); ?>
</head>
<body>
<div id="meta-admin">
<div id="header">
<h1><?=i('MetaBBS Administration')?></h1>

<div id="account">
<?=htmlspecialchars($account->name)?>님, 환영합니다. <a href="<?=url_with_referer_for('account', 'logout')?>"><?=i('Logout')?> &raquo;</a></p>
</div>

<ul id="nav">
	<li><?=link_to(i('Boards'), 'admin')?></li>
	<li><?=link_to(i('Users'), 'admin', 'users')?></li>
	<li><?=link_to(i('Settings'), 'admin', 'settings')?></li>
	<li><?=link_to(i('Plugins'), 'admin', 'plugins')?></li>
	<li><?=link_to(i('Maintenance'), 'admin', 'maintenance')?></li>
	<li><?=link_to(i('Information'), 'admin', 'info')?></li>
	<? foreach ($__admin_menu as $item): ?>
	<li><?=$item?></li>
	<? endforeach ?>
</ul>
</div>

<div id="content">
<? if (isset($flash)) { ?>
<div class="flash <?=$flash_class?>">
<p><?=$flash?></p>
</div>
<? } ?>
