<?php
if (isset($_GET['rewrite'])) die('REWRITE OK');

header("Content-Type: text/html; charset=UTF-8");

define('METABBS_DIR', '.');

function pass($msg) {
	echo "<div class=\"flash pass\">$msg ... <strong>OK</strong></div>";
}
function warn($msg) {
	echo "<div class=\"flash warn\"><strong>Warning:</strong> $msg</div>";
}
function fail($msg) {
	if (file_exists('metabbs.conf.php')) {
		unlink('metabbs.conf.php');
	}
	echo "<div class=\"flash fail\">$msg.</div>";
	print_footer();
	exit;
}
function field($name, $display_name, $value = '', $type = 'text', $desc = '') {
	echo "<tr>
	<th><label for=\"config_$name\">".i($display_name)."</label></th>
	<td><input type=\"$type\" name=\"config[$name]\" value=\"$value\" /></td>
	<td class=\"description\">$desc</td>
</tr>";
}
function get_backends() {
	return array('mysql');
}
function capture_errors($errno, $errstr, $errfile, $errline) {
	if ($errno & (E_ERROR | E_USER_ERROR)) {
		//global $safe;
		//$safe = true;
		fail($errstr);
	}
}
function send_self_request($path) {
	$fp = fsockopen($_SERVER['HTTP_HOST'], $_SERVER['SERVER_PORT'], $_, $_, 3);
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
  <link rel="stylesheet" href="media/style.css" type="text/css" />
	<script type="text/javascript">
	function toggleAdvancedOptions(link) {
		var adv = document.getElementById('advanced')
		if (adv.style.display == 'none') {
			adv.style.display = 'table'
			link.innerHTML = '숨기기'
		} else {
			adv.style.display = 'none'
			link.innerHTML = '보이기'
		}
	}
	</script>
</head>
<body id="installer">
<div id="meta-admin">
	<div id="header">
		<h1 style="float: none">MetaBBS 설치</h1>
	</div>
	<div id="content">
<?php
}
function print_footer() {
?>
	</div>
  </div>
</body>
</html>
<?php
}
ini_set('include_path', METABBS_DIR . PATH_SEPARATOR . ini_get('include_path'));

require_once 'core/query.php';
require_once 'core/model.php';
require_once 'app/models/metadata.php';
require_once 'core/config.php';
$config = new Config('metabbs.conf.php');

require_once 'core/i18n.php';
require_once 'core/tag_helper.php';

$backend = isset($_GET['backend']) ? $_GET['backend'] : 'mysql';
require "core/backends/$backend/installer.php";

$path = dirname($_SERVER['SCRIPT_NAME']);
if ($path == '\\' || $path == '/') $path = '';
$metabbs_base_path = $path . '/';

import_default_language();
print_header();

if (!is_writable('.')) {
	$path = realpath('.');
	fail(i("Please change permission of %s to 0707", $path));
}

if (file_exists('metabbs.conf.php')) {
	echo '<div class="flash fail">MetaBBS가 이미 설치되어 있습니다. 관리자 페이지에서 유지 보수 - 언인스톨을 이용하거나 metabbs.conf.php를 지워보세요.</div>';
	print_footer();
	exit;
}

if (!isset($_POST['config'])) {
?>
	<form method="post" action="install.php?backend=<?=$backend?>">
	<h2>데이터베이스 정보</h2>
	<table>
<? /* will not be supported in 0.9 series
	<tr>
		<>Backend</label>
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
	} */
	db_info_form();
?>
</table>

<h2>관리자 정보</h2>
<table>
	<tr>
		<th><?=label_tag("Admin ID", 'admin', 'id')?></th>
		<td><input type="text" name="admin_id" id="admin_id" value="admin" /></td>
	</tr>
	<tr>
		<th><?=label_tag("Admin Password", 'admin', 'password')?></th>
		<td><input type="password" name="admin_password" id="admin_password" /></td>
	</tr>
	<tr>
		<th><?=label_tag("Admin Password (Again)", 'admin', 'password_verify')?></th>
		<td><input type="password" name="admin_password_verify" id="admin_password_verify" /></td>
	</tr>
	<tr>
		<th><?=label_tag("Admin Name", 'admin', 'name')?></th>
		<td><input type="text" name="admin_name" id="admin_name" value="admin" /></td>
	</tr>
</table>

<h2>고급 설정 <span><a href="#advanced" onclick="toggleAdvancedOptions(this)">보이기</a></span></h2>

<table id="advanced" style="display: none">
<? field('prefix', 'Table Prefix', 'meta_', 'text', '테이블 이름 앞에 붙는 식별자입니다. 여러 곳에 설치할 때만 바꾸세요.'); ?>
<tr>
	<th><?=label_tag("Base Path", 'admin', 'base_path')?></th>
	<td><input type="text" name="base_path" id="base_path" value="<?=$metabbs_base_path?>" /></td>
	<td>MetaBBS URL을 강제로 설정합니다.</td>
</tr>
</table>

<p class="install"><?=submit_tag("Install")?></p>
</form>
<?php
} else {
	set_error_handler('capture_errors');

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
		mkdir($dir);
		chmod($dir, 0707);
	}

	$safe = false;
	function check_unexcepted_exit() {
		global $safe;
		if (!$safe) {
			@unlink(dirname(__FILE__).'/metabbs.conf.php');
			if (isset($GLOBALS['config'])) {
				$conn = get_conn();
				@include("core/schema/uninstall.php");
			}
		}
	}
	register_shutdown_function('check_unexcepted_exit');

	include 'core/schema/schema.php';

	pass("Creating directories");
	foreach ($_POST['config'] as $key => $value)
		$config->set($key, $value);
	$config->set('backend', $backend);
	$config->set('base_path', $_POST['base_path']);
	$config->set('revision', METABBS_DB_REVISION);
	$config->write_to_file();
	chmod('metabbs.conf.php', 0606);
	
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
	chmod('.htaccess', 0606);

	pass("Initializing Database");
	get_conn();
	set_table_prefix($config->get('prefix', 'meta_'));
	init_db();

	pass("Creating admin user");
	require_once 'app/models/user.php';
	require_once 'core/account.php';
	$user = new User;
	$user->user = $_POST['admin_id'];
	$user->name = $_POST['admin_name'];
	$user->password = md5($_POST['admin_password']);
	$user->level = 255;
	$user->create();

	$safe = true;

	$admin_url = ($rewrite ? '' : 'metabbs.php/') . 'account/login?url=../admin';

	echo "<h2>Installation Finished</h2>";
	echo "<p>Thank you for installing MetaBBS. :-)</p>";
	echo "<p><a href='$admin_url'>Go to administration page &raquo;</a></p>";
}
print_footer();
?>
