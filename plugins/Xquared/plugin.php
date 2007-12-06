<?php
class Xquared extends Plugin {
	var $plugin_name = 'Xquared 위지윔 편집기';
	var $description = '글 입력창을 Xquared 위지윔 편집기로 바꿉니다.';

	function on_init() {
		global $controller, $action;

		ini_set('include_path', dirname(__FILE__).PATH_SEPARATOR.ini_get('include_path'));
		if(!class_exists('HTML_Safe'))
			include_once 'HTML_Safe.php';

		add_filter('PostList', array(&$this, 'format'), 500);
		add_filter('PostView', array(&$this, 'format'), 500);
		add_filter('PostViewRSS', array(&$this, 'format'), 500);

		if($controller == 'board' and $action == 'post' or $controller == 'post' and $action == 'edit')
			$this->enable_editor();
	}

	function enable_editor() {
		global $layout;

		$plugin_uri = METABBS_BASE_PATH.'plugins/Xquared';

		$layout->add_javascript("$plugin_uri/js/xquared-min.js");
		$layout->add_stylesheet("$plugin_uri/css/xq_ui.css");
		$layout->add_javascript("$plugin_uri/plugin.js");
		$layout->header = "
			<script type=\"text/javascript\">
			// <![CDATA[
			var XquaredPluginUri = '$plugin_uri';
			// ]]>
			</script>
		".$layout->header;
	}

	function format(&$post) {
		if(!$post->body)
			return;

		if($post->get_attribute('format') != 'xquared-html')
			$post->body = format_plain($post->body);
		else {
			$safe = new HTML_Safe;
			$post->body = $safe->parse($post->body);
		}
	}
}

register_plugin('Xquared');
