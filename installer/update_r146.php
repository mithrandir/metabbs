<?php
require_once 'common.php';

$dir = dirname(__FILE__).'/../';
require_once $dir.'config.php';
$config = new Config($dir.'metabbs.conf.php');

$backend = $config->get('backend');
if (!$backend) $backend = 'mysql';

$lib_dir = $dir.'backends/common';
require_once $lib_dir . '/Model.php';
require_once $dir.'backends/' . $backend . '/backend.php';
require_once $lib_dir . '/Board.php';

print_header(1);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (md5($_POST['admin_password']) != $config->get('admin_password')) {
		echo 'wrong password.';
		exit;
	}
	set_error_handler('capture_errors');
	pass('updating database');
	$conn = get_conn();
	$conn->query_from_file('../db/update_146_'.$config->get('backend').'.sql');
	pass('creating admin user');
	$user = new User;
	$user->user = $_POST['admin_id'];
	$user->name = $_POST['admin_name'];
	$user->password = $config->get('admin_password');
	$user->level = 255;
	$user->save();
	echo '<p>done. :)</p>';
	exit;
}
?>
<form method="post">
<h2>Updater (rev 146)</h2>
<p>
	<label for="admin_password">Admin Password</label>
	<input type="password" name="admin_password" />
</p>
<p>
	<label for="admin_id">Admin ID</label>
	<input type="text" name="admin_id" value="admin" />
</p>
<p>
	<label for="admin_name">Admin Name</label>
	<input type="text" name="admin_name" />
</p>
<input type="submit" value="Update!" />
</form>
<?php print_footer(); ?>
