<?php

if (!extension_loaded('tidy')) return;

class TidyIt extends Plugin {
	var $plugin_name = 'Tidy It!';
	var $description = '사용자가 입력한 HTML에 대해 엄격하게 검사합니다.';
	var $tidy;

	var $config = array(
		'output-xhtml' => true,
		'wrap' => 0,
		'drop-empty-paras' => true,
		'drop-font-tags' => true,
		'drop-proprietary-attributes' => true,
		'logical-emphasis' => true,
		'lower-literals' => true
	);

	function on_init() {
		$this->tidy = new tidy;

		add_filter('PostList', array(&$this, 'format'), 2000);
		add_filter('PostView', array(&$this, 'format'), 2000);
		add_filter('PostViewRSS', array(&$this, 'format'), 2000);
		add_filter('PostViewComment', array(&$this, 'format'), 2000);
		add_filter('CommentViewFeed', array(&$this, 'format'), 2000);
	}

	function format(&$model) {
		if (!$model->body) return;

		$this->tidy->parseString($model->body, $this->config, 'utf8');
		$this->tidy->cleanRepair();

		$model->body = ereg_replace(
			'(^[[:space:]]*<body>|</body>[[:space:]]*$)', '',
			$this->tidy->body()
		);
	}
}

register_plugin('TidyIt');

?>
