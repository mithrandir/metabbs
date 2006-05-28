<?php
require_once 'lib/common.php';

function go_back($action = '') {
	header('Location: admin.php' . ($action?'?action='.$action:''));
} 

function get_skins() {
	$skins = array();
	$dir = opendir('skins');
	while ($file = readdir($dir)) {
		if ($file{0} != '_' && $file{0} != '.' && is_dir("skins/$file")) {
			$skins[] = $file;
		}
	}
	closedir($dir);
return $skins;
}

function find_skin($action) {
	return 'skins/_admin/' . $action . '.php';
}

$base_uri = '.';

if (!$user->is_admin()) {
	redirect_to('metabbs.php/account/login?url='.get_base_path().'admin.php');
}

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

if ($action == 'index') {
	$boards = Board::find_all();
}
else if ($action == 'new') {
	$action = 'edit';
	$skins = get_skins();
	$board = new Board;
}
else if ($action == 'edit') {
	$board = Board::find($_GET['board_id']);
	$skins = get_skins();
}
else if ($action == 'save') {
	$validate = true;
	if (isset($_GET['board_id'])) {
		$board = Board::find($_GET['board_id']);
		if ($_POST['board']['name'] == $board->name) {
			$validate = false;
		}
	} else {
		$board = new Board;
	}
	$board->import($_POST['board']);
	if (!$validate || $board->validate()) {
		if ($board->exists()) {
			$board->update();
		} else {
			$board->create();
		}
		go_back();
	} else {
		$action = 'edit';
		$skins = get_skins();
		$flash = "Board '$board->name' already exists.";
	}
}
else if ($action == 'delete') {
	$board = Board::find($_GET['board_id']);
	$board->delete();
	go_back();
}
else if ($action == 'logout') {
	unset($_SESSION['admin_password']);
	go_back();
}
else if ($action == 'settings') {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$new_password = md5($_POST['settings']['admin_password']);
		if ($new_password != $user->password) {
			$user->password = $new_password;
			cookie_register('password', $user->password);
			$user->update();
		}
		$config->set('global_layout', $_POST['settings']['global_layout']);
		$config->write_to_file();
		go_back();
	}
	$settings = $config->config;
}
else if ($action == 'users') {
	$users = User::find_all();
}
else if ($action == 'user_edit') {
	$level = $_POST['level'];
	foreach ($_POST['user_id'] as $id => $check) {
		$user = User::find($id);
		$user->level = $level;
		$user->update();
	}
	go_back('users');
}
else if ($action == 'uninstall') {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$conn = get_conn();
		include('db/uninstall.php');
		unlink('metabbs.conf.php');
		echo 'uninstalled';
		exit;
	}
}
else {
	echo "no action '$action'";
}
$skin_dir = 'skins/_admin';
ob_start();
include 'skins/_admin/' . $action . '.php';
$content = ob_get_contents();
ob_end_clean();
include('skins/_admin/layout.php');
?>
