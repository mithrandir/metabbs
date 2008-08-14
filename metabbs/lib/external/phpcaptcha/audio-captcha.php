<?php
define('METABBS_DIR', '../../..');

require METABBS_DIR . '/lib/config.php';
$config = new Config(METABBS_DIR . '/metabbs.conf.php');

require METABBS_DIR . '/lib/captcha.php';
$captcha = new Captcha($config->get('captcha_name', false), $captcha_arg);

session_save_path(METABBS_DIR.'/data/session');
session_start();
require('php-captcha.inc.php');
if(file_exists($captcha->flite_path)) {
	$oAudioCaptcha = new AudioPhpCaptcha($captcha->flite_path, '/tmp/');
	$oAudioCaptcha->Create();
}
?>
