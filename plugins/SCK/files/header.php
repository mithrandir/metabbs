<?php
require_once dirname(__FILE__) . '/../sck.php';
$layout->add_stylesheet(METABBS_BASE_URI . 'sck/media/style.css');
$admin = !$metabbs->isGuest() && $metabbs->user->is_admin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?=$layout->title?></title>
	<?php $layout->print_head(); ?>
</head>
<body>
<h1><a href="<?=sck_home_url()?>"><?=sck_site_name()?></a></h1>

<ul id="menu">
	<li><a href="<?=sck_home_url()?>"><?=i('Home')?></a></li>
<?php foreach (sck_primary_menus() as $menu): ?>
	<li><a href="<?=sck_menu_url($menu)?>"><?=htmlspecialchars($menu->name)?></a></li>
<?php endforeach; ?>

<?php if ($admin): ?>
	<li class="admin-menu"><a href="<?=url_for('menu', 'add')?>"><?=i('Add Menu')?></a></li>
<?php endif; ?>
</ul>

<div id="sidebar">
<div id="account">
<?php if ($metabbs->isGuest()): ?>
	<a href="<?=url_with_referer_for('account', 'login')?>">로그인</a>
<?php else: ?>
	<p><?=i('Welcome, %s.', $metabbs->user->name)?></p>
	<p><a href="<?=url_with_referer_for('account', 'logout')?>"><?=i('Logout')?></a>
	 | <a href="<?=url_with_referer_for('account', 'edit')?>"><?=i('Edit Info')?></a>
	<?php if ($metabbs->user->is_admin()): ?>
	 | <a href="<?=url_for('admin')?>"><?=i('Admin')?></a>
	<?php endif; ?></p>
<?php endif; ?>
</div>
</div>

<div id="content">
