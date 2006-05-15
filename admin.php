<?php

require_once 'common.php';

function go_back() {
    header('Location: admin.php');
} 
function text_field($model, $name, $value = '', $size = 15) {
	$data = @$GLOBALS[$model];
	if (is_object($data)) {
		$value = $data->$name;
	}
	else {
		$value = $data[$name];
	}
	$value = htmlspecialchars($value);
	return sprintf('<input type="text" name="%s[%s]" value="%s" size="%d" />',
			$model, $name, $value, $size);
}

function password_field($model, $name, $value = '', $size = 15) {
	return sprintf('<input type="password" name="%s[%s]" />', $model, $name);
}

function check_box($model, $name) {
	$data = @$GLOBALS[$model];
	$checked = '';
	if (@$data->$name) {
		$checked = ' checked="checked"';
	}
	$key = $model . '[' . $name . ']';
	return "<input name=\"$key\" type=\"hidden\" value=\"0\" /><input type=\"checkbox\" name=\"$key\" value=\"1\"$checked />";
}

function get_skins() {
    $skins = array();
    $dir = opendir('skins');
    while ($file = readdir($dir)) {
        if ($file{0} != '_' && $file{0} != '.') {
            $skins[] = $file;
        }
    }
    closedir($dir);
    return $skins;
}

$base_uri = '.';

if (isset($_POST['login'])) {
    if (md5($_POST['login']) == $config->get('admin_password')) {
        $_SESSION['admin_password'] = $config->get('admin_password');
        go_back();
    } else {
        $flash = 'Wrong password';
    }
}

if (!is_admin()) {
    include 'skins/_admin/login.php';
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

if ($action == 'index') {
    $boards = Board::find_all();
}
else if ($action == 'new') {
    $action = 'edit';
    $skins = get_skins();
}
else if ($action == 'edit') {
    $board = Board::find($_GET['board_id']);
    $skins = get_skins();
}
else if ($action == 'save') {
    if (isset($_GET['board_id'])) {
        $board = Board::find($_GET['board_id']);
    } else {
        $board = new Board;
    }
    $board->import($_POST['board']);
    if ($board->save()) {
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
        $config->set('admin_password', ($_SESSION['admin_password']=md5($_POST['settings']['admin_password'])));
        $config->set('global_layout', $_POST['settings']['global_layout']);
        $config->write_to_file();
        go_back();
    }
    $settings = $config->config;
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
