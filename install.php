<?php
if (isset($_GET['rewrite'])) die('REWRITE OK');

header("Content-Type: text/html; charset=UTF-8");

define('METABBS_DIR', '.');

function pass($msg) {
	echo "<div class=\"flash pass\">$msg ... <em>OK :)</em></div>";
}
function warn($msg) {
	echo "<div class=\"flash warn\"><em>Warning:</em> $msg</div>";
}
function fail($msg) {
	if (file_exists('metabbs.conf.php')) {
		unlink('metabbs.conf.php');
	}
	echo "<div class=\"flash fail\">$msg. <a href=\"$_SERVER[REQUEST_URI]\">Retry?</a></div>";
	print_footer();
	exit;
}
function field($name, $display_name, $value = '', $type = 'text', $desc = '') {
	echo "<p><label>$display_name</label> <input type=\"$type\" name=\"config[$name]\" value=\"$value\" />\n<span class='desc'>$desc</span></p>";
}
function get_backends() {
	return array('mysql');
}
function capture_errors($errno, $errstr, $errfile, $errline) {
	if ($errno & (E_ERROR | E_USER_ERROR)) {
		global $safe;
		$safe = true;
		fail($errstr);
	}
}
function send_self_request($path) {
	$fp = fsockopen($_SERVER['HTTP_HOST'], $_SERVER['SERVER_PORT']);
	if (!$fp) return "";
	fwrite($fp, "GET $path HTTP/1.1\r\n");
	fwrite($fp, "Host: $_SERVER[HTTP_HOST]\r\n");
	fwrite($fp, "Connection: close\r\n");
	fwrite($fp, "\r\n");

	$response = "";
	while (!feof($fp))
		$response .= fgets($fp, 1024);
	fclose($fp);
	return $response;
}
function print_header() {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>MetaBBS Installation</title>
  <link rel="stylesheet" href="elements/style.css" type="text/css" />
</head>
<body id="installer">
  <div id="meta-admin">
	<h1>MetaBBS Installation</h1>
	<div id="header"></div>
	<div id="body">
<?php
}
function print_footer() {
?>
	</div>
	<div id="footer">
		<p id="copyright">&copy; 2005-2006, <a href="http://metabbs.org">MetaBBS Team</a></p>
	</div>
  </div>
</body>
</html>
<?php
}
ini_set('include_path', METABBS_DIR . PATH_SEPARATOR . ini_get('include_path'));

require_once 'lib/query.php';
require_once 'lib/model.php';
require_once 'lib/config.php';
$config = new Config('metabbs.conf.php');

require_once 'lib/i18n.php';
require_once 'lib/tag_helper.php';

$backend = isset($_GET['backend']) ? $_GET['backend'] : 'mysql';
require "lib/backends/$backend/installer.php";

import_default_language();
print_header();

if (is_writable('.')) {
	pass('Permission check');
} else {
	$path = realpath('.');
	fail("Please change permission of $path to 0707");
}

if (file_exists('metabbs.conf.php')) {
	echo '<div class="flash fail">MetaBBS is already installed. Please remove metabbs.conf.php and database.</div>';
	print_footer();
	exit;
}

if (!isset($_POST['config'])) {
?>
	<h2>Database Information</h2>
	<form id="dbinfo" method="post" action="install.php?backend=<?=$backend?>">
	<p>
		<label for="backend">Backend</label>
		<select name="backend" id="backend" onchange="location.replace('?backend='+this.value)">
<?php
        foreach (get_backends() as $b) {
                $sel = ($b == $backend) ? ' selected="selected"' : '';
                echo "<option value=\"$b\"$sel>$b</option>";
        }
?>
                </select>
                <span class="desc">어떤 방식으로 데이터를 저장할 것인지 선택합니다.</span>
	</p>
<?php
	if (!is_supported()) {
		fail('Your server doesn\'t support <em>' . $backend . '</em>');
	}
    db_info_form();
	field('prefix', 'Table Prefix', 'meta_', 'text', 'MetaBBS가 저장될 DB 테이블의 식별자를 입력합니다. (다중 설치인 경우 사용)');
?>
	<h2>Admin Information</h2>
	<p>
		<?=label_tag("Admin ID", 'admin', 'id')?>
		<input type="text" name="admin_id" id="admin_id" value="admin" />
		<span class="desc">관리자로 사용할 아이디를 입력합니다.</span>
	</p>
	<p>
		<?=label_tag("Admin Password", 'admin', 'password')?>
		<input type="password" name="admin_password" id="admin_password" />
		<span class="desc">관리자 아이디의 비밀번호를 입력합니다.</span>
	</p>
	<p>
		<?=label_tag("Admin Password (Again)", 'admin', 'password_verify')?>
		<input type="password" name="admin_password_verify" id="admin_password_verify" />
		<span class="desc">확인을 위해 관리자 아이디의 비밀번호를 한번 더 입력합니다.</span>
	</p>
	<p>
		<?=label_tag("Admin Name", 'admin', 'name')?>
		<input type="text" name="admin_name" id="admin_name" value="admin" />
		<span class="desc">관리자 아이디의 이름을 입력합니다.</span>
	</p>
	<p><?=submit_tag("Install")?></p>
	</form>
<?php
} else {
	set_error_handler('capture_errors');

    $safe = false;
    function check_unexcepted_exit() {
        global $safe;
        if (!$safe) {
            @unlink(dirname(__FILE__).'/metabbs.conf.php');
			if (isset($GLOBALS['config'])) {
				$conn = get_conn();
				@include("db/uninstall.php");
			}
        }
    }
    register_shutdown_function('check_unexcepted_exit');

	$_POST['admin_id'] = trim($_POST['admin_id']);
	$_POST['admin_password'] = trim($_POST['admin_password']);
	$_POST['admin_password_verify'] = trim($_POST['admin_password_verify']);
	if ($_POST['admin_id'] == '') {
		fail('Admin ID is empty');
	}
	if ($_POST['admin_name'] == '') {
		fail('Admin name is empty');
	}
	if ($_POST['admin_password'] != $_POST['admin_password_verify']) {
		fail('Please verify password');
	}

	$dirs = array('data', 'data/uploads', 'data/session');
	foreach ($dirs as $dir) {
		mkdir($dir, 0707);
	}

	include 'db/schema.php';

	pass("Creating directories");
	foreach ($_POST['config'] as $key => $value)
		$config->set($key, $value);
	$config->set('backend', $backend);
    $config->set('revision', METABBS_DB_REVISION);
	$config->write_to_file();
	
	pass("Writing configuration to file");
	$path = dirname($_SERVER['REQUEST_URI']);
	$fp = fopen('.htaccess', 'w');
	fwrite($fp, "RewriteEngine On\n");
	fwrite($fp, "RewriteBase $path\n");
	fwrite($fp, "RewriteRule ^testrewrite$ install.php?rewrite=1 [L]");
	fclose($fp);

	$response = send_self_request($path.'/testrewrite');
	$rewrite = strpos($response, "REWRITE OK") !== FALSE;

	$htaccess = implode('', file('.htaccess.in'));
	$fp = fopen('.htaccess', 'w');
	fwrite($fp, str_replace('/url/to/metabbs/', $path, $htaccess));
	fclose($fp);

	pass("Initializing Database");
	get_conn();
	set_table_prefix($config->get('prefix', 'meta_'));
	init_db();

	pass("Creating admin user");
	require_once 'app/models/user.php';
	require_once 'lib/account.php';
	$user = new User;
	$user->user = $_POST['admin_id'];
	$user->name = $_POST['admin_name'];
	$user->password = md5($_POST['admin_password']);
	$user->level = 255;
	$user->create();

    $safe = true;

    $admin_url = $rewrite ? 'admin' : 'metabbs.php/admin';

	echo "<h2>Installation Finished</h2>";
	echo "<p>Thank you for installing MetaBBS. :-)</p>";
	echo "<p><a href='$admin_url'>Go to administration page &raquo;</a></p>";
}
print_footer();
?>
