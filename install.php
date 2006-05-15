<?php
header("Content-Type: text/html; charset=UTF-8");

require_once 'installer/common.php';

function check_perm() {
    if (is_writable('.')) {
        pass('Permission check');
    } else {
        $path = realpath('.');
        fail("Please change permission of $path to 0777");
    }
}
if (file_exists('metabbs.conf.php')) {
    print_header(1);
    echo '<div class="flash fail">MetaBBS is already installed. Please remove metabbs.conf.php and database.</div>';
    print_footer();
    exit;
}

$backend = isset($_GET['backend']) ? $_GET['backend'] : 'mysql';
require "backends/$backend/installer.php";
print_header(1);
check_perm();
if (!isset($_POST['config'])) {
?>
    <h2>Database Information</h2>
    <form id="dbinfo" method="post" action="?backend=<?=$backend?>">
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
        <input type="text" name="admin_id" value="admin" />
    </p>
    <p>
        <label for="admin_password">Admin Password</label>
        <input type="password" name="admin_password" />
    </p>
    <p>
        <label for="admin_name">Admin Name</label>
        <input type="text" name="admin_name" />
    </p>
    <p><input type="submit" value="Install" /></p>
    </form>
<?php
} else {
    $dirs = array('data', 'data/session', 'data/uploads');
    set_error_handler('capture_errors');
    foreach ($dirs as $dir) {
        mkdir($dir, 0777);
    }
    pass("Creating directories");
    require_once 'config.php';
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
    require_once 'model/Model.php';
    require_once "backends/$backend/backend.php";
    require_once 'model/User.php';
    $user = new User;
    $user->user = $_POST['admin_id'];
    $user->name = $_POST['admin_name'];
    $user->password = md5($_POST['admin_password']);
    $user->level = 255;
    $user->save();
    
    echo "<h2>Installation Finished</h2>";
    echo "<p>Thank you for installing MetaBBS. :-)</p>";
    echo "<p><a href='admin.php'>Go to administration page &raquo;</a></p>";
}
print_footer();
?>

<?php # vim: set et: ?>
