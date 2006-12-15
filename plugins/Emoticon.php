<?php
class Emoticon extends Plugin {
	var $description = 'Replace emoticons to images';
	var $mapping = array(
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
	function on_init() {
		add_filter('PostView', array(&$this, 'emote_filter'), 1000);
		add_filter('PostViewComment', array(&$this, 'emote_filter'), 1000);
	}
	function emote_filter(&$model) {
		foreach ($this->mapping as $k => $v) {
			$model->body = str_replace($k, image_tag(METABBS_BASE_PATH.'plugins/emotes/'.$v), $model->body);
		}
	}
}

register_plugin('Emoticon');
?>
