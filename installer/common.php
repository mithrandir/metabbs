<?php
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

function print_header($step) {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>MetaBBS Installation</title>
  <link rel="stylesheet" href="<?=basename($_SERVER['PHP_SELF'])=='install.php'?'installer/':''?>setup.css" />
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
?>
