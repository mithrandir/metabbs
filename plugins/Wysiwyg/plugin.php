<?php
class Wysiwyg extends Plugin {
	var $plugin_name = '위지윅 편집기';
	var $description = '글 입력창을 위지윅 편집기로 바꿉니다.';
	function on_init() {
		global $controller, $action;
		ini_set("include_path", dirname(__FILE__) . PATH_SEPARATOR . ini_get("include_path"));

		add_filter('PostList', array(&$this, 'format'), 500);
		add_filter('PostView', array(&$this, 'format'), 500);
		add_filter('PostViewRSS', array(&$this, 'format'), 500);
		//add_filter('PostViewComment', 'format_body', 500);
		if(($controller == 'board' and $action == 'post') 
			or ($controller == 'post' and $action == 'edit'))
			$this->enable_editor();
	}
	function enable_editor() {
		global $layout;
		$layout->add_javascript(METABBS_BASE_PATH . 'plugins/Wysiwyg/tiny_mce/tiny_mce.js');
		$layout->footer .= '<script type="text/javascript">
Event.observe(window, "load", function () {
	$("post_body").form.onsubmit = function () {
		tinyMCE.triggerSave();
		if (!checkForm(this)) return false;
		setPostAttribute(this, "format", "wysiwyg-html");
		return true;
	}
});
tinyMCE.init({
	theme: "advanced",
	mode: "exact",
	elements: "post_body",
	add_form_submit_trigger: false,
	submit_patch: false,
	theme_advanced_toolbar_location: "top",
	theme_advanced_buttons1: "bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,outdent,indent,separator,fontsizeselect",
	theme_advanced_buttons2 : "link,unlink,anchor,image,separator,undo,redo,cleanup,code,separator,sub,sup,charmap",
    theme_advanced_buttons3 : ""
});
</script>';
	}
	function format(&$post) {
		if (!$post->body) return;
		if ($post->get_attribute('format') != 'wysiwyg-html')
			$post->body = format_plain($post->body);
		 else 
			$post->body = '<div class="wysiwyg">'.$post->body.'</div>';
	}
}

register_plugin('Wysiwyg');
?>
