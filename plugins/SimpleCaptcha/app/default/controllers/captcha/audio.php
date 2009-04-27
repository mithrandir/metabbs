<?php
$config = new Config(METABBS_DIR . '/data/captcha.php');
$flite_path = $config->get('flite_path');
if(file_exists($flite_path)) {
	$oAudioCaptcha = new AudioPhpCaptcha($flite_path, '/tmp/');
	$oAudioCaptcha->Create();
}
?>