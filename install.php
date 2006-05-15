<?php
header("Content-Type: text/html; charset=UTF-8");

if (file_exists('metabbs.conf.php')) {
    print_header(1);
    echo '<div class="flash fail">MetaBBS is already installed. Please remove metabbs.conf.php and database.</div>';
    print_footer();
    exit;
}

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
function field($name, $display_name, $value = '', $type = 'text') {
    echo "<p><label>$display_name</label> <input type=\"$type\" name=\"config[$name]\" value=\"$value\" /></p>";
}
function get_backends() {
    $backends = array();
    $dir = opendir('backends');
    while ($backend = readdir($dir)) {
        if ($backend{0} != '.' && $backend != 'common') {
            $backends[] = $backend;
        }
    }
    return $backends;
}
function capture_errors($errno, $errstr, $errfile, $errline) {
    if ($errno & E_USER_ERROR) {
        fail($errstr);
    } else {
        warn($errstr);
    }
}
function check_perm() {
    if (is_writable('.')) {
        pass('Permission check');
    } else {
        $path = realpath('.');
        fail("Please change permission of $path to 0777");
    }
}
function print_header($step) {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>MetaBBS Installation</title>
  <link rel="stylesheet" href="installer/setup.css" />
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
    <p><label>Admin password</label> <input type="password" name="config[admin_password]" /></p>
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
    $config->set('admin_password', md5($config->get('admin_password')));
    $config->write_to_file();
    
    $htaccess = implode('', file('.htaccess.in'));
    $fp = fopen('.htaccess', 'w');
    fwrite($fp, str_replace('/url/to/metabbs/', dirname($_SERVER['REQUEST_URI']), $htaccess));
    fclose($fp);
    pass("Writing configuration to file");
    init_db();
    pass("Initializing Database");
    echo "<h2>Installation Finished</h2>";
    echo "<p>Thank you for installing MetaBBS. :-)</p>";
    echo "<p><a href='admin.php'>Go to administration page &raquo;</a></p>";
}
print_footer();
?>

<?php # vim: set et: ?>
