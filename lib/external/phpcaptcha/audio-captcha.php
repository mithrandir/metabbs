<?php
define('METABBS_DIR', '../../..');

session_save_path(METABBS_DIR.'/data/session');
session_start();

require METABBS_DIR . '/lib/config.php';
$config = new Config(METABBS_DIR . '/metabbs.conf.php');
$flite_path = $config->get('flite_path', false);

require('php-captcha.inc.php');
if(file_exists($flite_path)) {
	$oAudioCaptcha = new AudioPhpCaptcha($flite_path, '/tmp/');
	$oAudioCaptcha->Create();
}
?>
