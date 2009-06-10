<?php
class Xquared extends Plugin {
	var $plugin_name = 'Xquared 위지윅 편집기';
	var $description = '글 입력창을 Xquared 위지윅 편집기로 바꿉니다.';

	function on_init() {
		global $routes, $layout;
		ini_set('include_path', dirname(__FILE__).PATH_SEPARATOR.ini_get('include_path'));

		add_filter('PostList', array(&$this, 'format'), 500);
		add_filter('PostView', array(&$this, 'format'), 500);
		add_filter('PostViewRSS', array(&$this, 'format'), 500);

		if(($routes['controller'] == 'board' and $routes['action'] == 'post') 
			or ($routes['controller'] == 'board' and $routes['action'] == 'edit'))
			$this->enable_editor();
	}

	function enable_editor() {
		global $layout;
		$xquared_version = '20090512';
		$xquared_path = 'xquared-'.$xquared_version;
		$plugin_uri = METABBS_BASE_PATH.'plugins/Xquared/';

		$layout->add_stylesheet($plugin_uri.$xquared_path.'/stylesheets/xq_ui.css');
		$layout->add_javascript($plugin_uri.$xquared_path.'/javascripts/XQuared.js?load_others=1');
		$layout->add_javascript($plugin_uri.$xquared_path.'/javascripts/plugin/SpringnotePlugin.js');
		$layout->add_javascript($plugin_uri.$xquared_path.'/javascripts/plugin/EditorResizePlugin.js');
		$layout->add_javascript($plugin_uri.$xquared_path.'/javascripts/plugin/MacroPlugin.js');
		$layout->add_javascript($plugin_uri.$xquared_path.'/javascripts/plugin/FlashMovieMacroPlugin.js');
		$layout->add_javascript($plugin_uri.$xquared_path.'/javascripts/plugin/IFrameMacroPlugin.js');
//		$layout->add_javascript($plugin_uri.$xquared_path.'/javascripts/plugin/JavascriptMacroPlugin.js');

		$layout->add_javascript($plugin_uri.'/plugin.js');
		$layout->header = "
<script type=\"text/javascript\">
// <![CDATA[
var XquaredPluginUri = '$plugin_uri$xquared_path';
// ]]>
</script>
		".$layout->header;
	}

	function format(&$post) {
		if(!$post->body)
			return;

		if($post->get_attribute('format') != 'xquared-html')
			$post->body = format_plain($post->body);
		else 
			$post->body = '<div class="xquared">'.$post->body.'</div>';
	}
}

register_plugin('Xquared');
