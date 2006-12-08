<?php
$emote_mapping = array(
	'O:-)' => 'face-angel.png',
	':)' => 'face-smile.png',
	':-)' => 'face-smile.png',
	':(' => 'face-sad.png',
	':-(' => 'face-sad.png',
	':|' => 'face-plain.png',
	':-|' => 'face-plain.png',
	';)' => 'face-wink.png',
	';-)' => 'face-wink.png',
	';\'-(' => 'face-crying.png',
	';\'(' => 'face-crying.png',
	':-D' => 'face-grin.png',
	':D' => 'face-grin.png',
	':-O' => 'face-surprise.png',
	':O' => 'face-surprise.png',
	':evil:' => 'face-devil-grin.png',
	'8-|' => 'face-glasses.png'
);

function emote_filter(&$model) {
	global $emote_mapping;
	foreach ($emote_mapping as $k => $v) {
		$model->body = str_replace($k, image_tag(METABBS_BASE_PATH.'plugins/emotes/'.$v), $model->body);
	}
}

class Emoticon extends Plugin {
	var $description = 'Replace emoticons to images';
	function on_init() {
		add_filter('PostView', 'emote_filter', 1000);
		add_filter('PostViewComment', 'emote_filter', 1000);
	}
}

register_plugin('Emoticon');
?>
