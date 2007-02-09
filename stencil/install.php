<?php
header("Content-Type: text/html; charset=UTF-8");

define('METABBS_DIR', '.');

/**
 * 통과 메시지를 출력한다.
 * @param $msg 화면에 출력할 메시지
 */
function pass($msg) {
	echo "<div class=\"flash pass\">$msg ... <em>OK :)</em></div>";
}

/**
 * 경고 메시지를 출력한다.
 * @param $msg 화면에 출력할 메시지
 */
function warn($msg) {
	echo "<div class=\"flash warn\"><em>Warning:</em> $msg</div>";
}

/**
 * 실패했을때 설정 파일을 제거하고 에러메시지를 출력한다. 
 * @param $msg 화면에 출력할 메시지
 */

function fail($msg) {
	if (file_exists('metabbs.conf.php')) {
		unlink('metabbs.conf.php');
	}
	echo "<div class=\"flash fail\">$msg. <a href=\"$_SERVER[REQUEST_URI]\">Retry?</a></div>";
	print_footer();
	exit;
}

/**
 * 필드를 생성하여 출력합니다.
 * @param $name input 마크업 태그의 name 속성
 * @param $display_name 레이블 태그에 들어갈 문구
 * @param $value input 마크업 태그의 디폴트 값
 * @param $type input 마크업 태그의 type 속성
 * @param $desc input 마크업 태그 이후에 따르는 설명
 */
function field($name, $display_name, $value = '', $type = 'text', $desc = '') {
	echo "<p><label>$display_name</label> <input type=\"$type\" name=\"config[$name]\" value=\"$value\" />\n<span class='desc'>$desc</span></p>";
}

/**
 * 백 엔드를 가져온다.
 * @return lib/backends 폴더 내의 디렉토리 목록을 배열로 리턴한다.
 */
function get_backends() {
	$backends = array();
	$dir = opendir('lib/backends');
	while ($backend = readdir($dir)) {
		if ($backend{0} != '.') {
			$backends[] = $backend;
		}
	}
	return $backends;
}

/**
 * 설치 중 에러가 발생시 호출되는 함수. 에러 메시지를 처리해준다.
 * @param $errno 에러 번호
 * @param $errstr 에러 메시지
 * @param $errfile 에러가 발생한 파일
 * @param $errline 에러가 발생한 라인
 */
function capture_errors($errno, $errstr, $errfile, $errline) {
	if ($errno & (E_ERROR | E_USER_ERROR)) {
		fail($errstr);
	}
}

/**
 * 헤더를 출력한다.
 * @param $step 진행 단계
 */
function print_header($step) {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>MetaBBS Installation</title>
  <style type="text/css">
  <!--
*{} /* for Opera */

* {
    font-family: Verdana, Arial, sans-serif;
}

body {
    margin: 0em;
    padding: 0em;
    font-size: 0.8em;
    color: black;
    background-color: #333;
}
#wrap {
    margin: 20px;
    background-color: white;
    border: 5px solid #ccc;
}
h1 {
    margin: 0em;
    padding: 0.6em 0.6em 0.4em 0.6em;
    font-family: Trebuchet MS, Verdana, Arial, sans-serif;
    font-size: 2.5em;
}
h2 {
    border-bottom: 1px solid #9c6;
    font-family: Trebuchet MS, Verdana, sans-serif;
    font-size: 1.3em;
    padding: 0.1em;
}
a:link, a:visited {
    color: #4e9a06;
}
a:hover {
    background-color: #efc;
}
#title {
    border-bottom: 1px solid #ccc;
    background: url(skins/_admin/bg.png) repeat-x top left;
}
#contents, #footer {
    margin: 1.5em;
}
#footer p {
    text-align: right;
    color: #999;
}
#step {
    font-size: 0.7em;
    font-weight: normal;
    color: #9c9;
}
.flash {
    border: 1px solid #ccc;
    padding: 0.5em;
    margin-bottom: 0.5em;
}
.flash a:link, .flash a:visited {
    font-weight: bold;
    color: black;
}
.flash a:hover {
    font-weight: bold;
    background: none;
    color: #555;
}
.fail {
    background-color: pink;
}
.pass {
    background-color: lightgreen;
}
.warn {
    background-color: yellow;
}
.desc {
    color: #999;
    font-size: 90%;
}
form label {
    display: block;
    padding-top: 0.2em;
    width: 13em;
    float: left;
}
form p {
    margin: 0px 0px 10px 0px;
}
  -->
  </style>
</head>
<body>
  <div id="wrap">
	<div id="title">
		<h1>MetaBBS Installation <span id="step">Step <?=$step?></span></h1>
	</div>
	<div id="contents">
<?php
}
function print_footer() {
?>
	</div><!-- contents -->
	<div id="footer">
		<p id="copyright">&copy; 2005-2006, <a href="http://metabbs.daybreaker.info">MetaBBS Team</a></p>
	</div>
  </div><!-- wrap -->
</body>
</html>
<?php
}
require_once 'lib/model.php';
require_once 'lib/config.php';
$config = new Config('metabbs.conf.php');

require_once 'lib/i18n.php';
require_once 'lib/tag_helper.php';

$backend = isset($_GET['backend']) ? $_GET['backend'] : 'mysql';
require "lib/backends/$backend/installer.php";

print_header(1);

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
		if (isset($GLOBALS['config'])) {
				$conn = get_conn();
				@include("db/uninstall.php");
			}
            @unlink(dirname(__FILE__).'/metabbs.conf.php');
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

	$dirs = array('data', 'data/uploads');
	foreach ($dirs as $dir) {
		mkdir($dir, 0707);
	}

	pass("Creating directories");
	$config->config = $_POST['config'];
	$config->set('backend', $backend);
    $config->set('revision', METABBS_DB_REVISION);
	$config->write_to_file();
	define('METABBS_TABLE_PREFIX', $config->get('prefix', 'meta_'));
	
	pass("Writing configuration to file");
	$htaccess = implode('', file('.htaccess.in'));
	$fp = fopen('.htaccess', 'w');
	fwrite($fp, str_replace('/url/to/metabbs/', dirname($_SERVER['REQUEST_URI']), $htaccess));
	fclose($fp);

	pass("Initializing Database");
	init_db();

	pass("Creating admin user");
	$backend = $config->get('backend');
	require_once "lib/backends/$backend/backend.php";
	require_once 'model/user.php';
	require_once 'lib/user_manager.php';
	$user = new User;
	$user->user = $_POST['admin_id'];
	$user->name = $_POST['admin_name'];
	$user->password = md5($_POST['admin_password']);
	$user->level = 255;
	$user->create();

    $safe = true;
	
	echo "<h2>Installation Finished</h2>";
	echo "<p>Thank you for installing MetaBBS. :-)</p>";
	echo "<p><a href='metabbs.php/admin'>Go to administration page &raquo;</a></p>";
}
print_footer();
?>
