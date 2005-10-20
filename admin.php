<?php

require_once 'libs/Core.php';
require_once 'libs/BBS.php';
require_once 'libs/Template.php';

if (isset($passwd)) {
	if ($passwd == $admin_passwd) {
		setcookie(PREFIX.'_admin_login', md5($passwd));
		Core::Redirect('admin.php');
	}
}

$tpl = new Template('_admin');

if (!isset($_COOKIE[PREFIX.'_admin_login']) || $_COOKIE[PREFIX.'_admin_login'] != md5($admin_passwd)) {
	if (isset($changed)) {
		$tpl->assign('changed', true);
	}
	$tpl->display('login.tpl');
	exit;
}

if (!isset($action)) $action = '';

if ($action == 'logout') {
	setcookie(PREFIX.'_admin_login', '');
	Core::Redirect('admin.php');
} else if ($action == 'drop' && isset($bid)) {
	$bm->drop($bid);
	Core::Redirect('admin.php');
} else if ($action == 'create' && isset($bid)) {
	if (!$bm->isExists($bid) && $bid && $factor && $style) {
		$bbs = $bm->create($bid);
		$bbs->cfg = array('title' => $title, 'factor' => $factor, 'style' => $style, 'use_attachment' => $use_attachment);
		$bbs->saveSetting();
		Core::Redirect('admin.php');
	}
} else if ($action == 'save_config' && isset($bid)) {
	if ($bm->isExists($bid) && $bid && $factor && $style) {
		$bbs = new BBS($bid);
		$bbs->cfg = array('title' => $title, 'factor' => $factor, 'style' => $style, 'use_attachment' => $use_attachment);
		$bbs->saveSetting();
		Core::Redirect('admin.php');
	}
} else if ($action == 'save_global_config') {
	if ($new_passwd) {
		$bm->changePassword($new_passwd);
	}
	Core::Redirect('admin.php?changed=1');
}

$tpl->display('header.tpl');
if (!$action) {
	$list = $bm->getList();
	$tpl->assign('list', $list);
	$tpl->display('list.tpl');
} else if ($action == 'create') {
	$tpl->assign('styles', $bm->getTemplateList());
	$tpl->display('create.tpl');
} else if ($action == 'config' && isset($bid)) {
	$bbs = new BBS($bid);
	$tpl->assign('styles', $bm->getTemplateList());
	$tpl->assign('bid', $bid);
	$tpl->assign('cfg', $bbs->cfg);
	$tpl->display('config.tpl');
} else if ($action == 'global_config') {
	$tpl->display('global_config.tpl');
}
$tpl->display('footer.tpl');

?>
