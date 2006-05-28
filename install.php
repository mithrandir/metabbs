<?php
header("Content-Type: text/html; charset=UTF-8");

require_once 'installer/common.php';

$backend = isset($_GET['backend']) ? $_GET['backend'] : 'mysql';
require "lib/backends/$backend/installer.php";

print_header(1);

if (is_writable('.')) {
	pass('Permission check');
} else {
	$path = realpath('.');
	fail("Please change permission of $path to 0777");
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
?>
<?php
        db_info_form();
?>
	<h2>Admin Information</h2>
	<p>
		<label for="admin_id">Admin ID</label>
		<input type="text" name="admin_id" id="admin_id" value="admin" />
                <span class="desc">관리자로 사용할 아이디를 입력합니다.</span>
        </p>
	<p>
		<label for="admin_password">Admin Password</label>
		<input type="password" name="admin_password" id="admin_password" />
                <span class="desc">관리자 아이디의 비밀번호를 입력합니다.</span>
	</p>
        <p>
                <label for="admin_password_verify">Admin Password (Again)</label>
                <input type="password" name="admin_password_verify" id="admin_password_verify" />
                <span class="desc">확인을 위해 관리자 아이디의 비밀번호를 한번 더 입력합니다.</span>
        </p>
	<p>
		<label for="admin_name">Admin Name</label>
		<input type="text" name="admin_name" id="admin_name" value="admin" />
                <span class="desc">관리자 아이디의 이름을 입력합니다.</span>
	</p>
	<p><input type="submit" value="Install" /></p>
	</form>
<?php
} else {
	set_error_handler('capture_errors');

    $safe = false;
    function check_unexcepted_exit() {
        global $safe;
        if (!$safe) {
            unlink(dirname(__FILE__).'/metabbs.conf.php');
        }
    }
    register_shutdown_function('check_unexcepted_exit');

	// TODO : clearing var. need policy
	$_POST['admin_id'] = trim($_POST['admin_id']);
	$_POST['admin_password'] = trim($_POST['admin_password']);
	$_POST['admin_password_verify'] = trim($_POST['admin_password_verify']);
	if ($_POST['admin_id'] == '') {
		fail('Admin ID Is Empty');
	}
	if ($_POST['admin_name'] == '') {
		fail('Admin name Is Empty');
	}
	if ($_POST['admin_password'] != $_POST['admin_password_verify']) {
		fail('Password Verify');
	}

	$dirs = array('data', 'data/uploads');
	foreach ($dirs as $dir) {
		mkdir($dir, 0777);
	}

	pass("Creating directories");
	require_once 'lib/config.php';
	$config = new Config('metabbs.conf.php');
	$config->config = $_POST['config'];
	$config->set('backend', $backend);
	$config->write_to_file();
	
	pass("Writing configuration to file");
	$htaccess = implode('', file('.htaccess.in'));
	$fp = fopen('.htaccess', 'w');
	fwrite($fp, str_replace('/url/to/metabbs/', dirname($_SERVER['REQUEST_URI']), $htaccess));
	fclose($fp);

	pass("Initializing Database");
	init_db();

	pass("Creating admin user");
	$backend = $config->get('backend');
	require_once 'lib/core.php';
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
	echo "<p><a href='admin.php'>Go to administration page &raquo;</a></p>";
}
print_footer();
?>

<?php # vim: set et: ?>
