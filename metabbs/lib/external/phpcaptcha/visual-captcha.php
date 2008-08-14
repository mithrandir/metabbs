<?php
define('METABBS_DIR', '../../..');

$base = 'fonts';
$dirs = scandir($base."/");
$fonts = array();
foreach ($dirs as $dir)
	if (is_file("$base/$dir") && $dir != '.' && $dir != '..' && strstr($dir, ".ttf"))
		array_push($fonts, "$base/$dir");

//$fonts = array('fonts/VeraBd.ttf', 'fonts/VeraIt.ttf', 'fonts/Vera.ttf');
session_save_path(METABBS_DIR.'/data/session');
session_start();
require('php-captcha.inc.php');
$oVisualCaptcha = new PhpCaptcha($fonts, 120, 18);
$oVisualCaptcha->SetMinFontSize(12);
$oVisualCaptcha->SetMaxFontSize(15);
$oVisualCaptcha->Create();
?>