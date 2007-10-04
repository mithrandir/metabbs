<?php
class Wysiwyg extends Plugin {
	function on_init() {
		global $controller, $action;
		ini_set("include_path", dirname(__FILE__) . PATH_SEPARATOR . ini_get("include_path"));
		include_once 'HTML_Safe.php';
		add_filter('PostList', array(&$this, 'format'), 500);
		add_filter('PostView', array(&$this, 'format'), 500);
		add_filter('PostViewRSS', array(&$this, 'format'), 500);
		//add_filter('PostViewComment', 'format_body', 500);
		if ($controller == 'board' && $action == 'post' || $controller == 'post' && $action == 'edit')
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
		if ($post->get_attribute('format') != 'wysiwyg-html') {
			$post->body = format_plain($post->body);
		} else {
			$safe = new HTML_Safe;
			$post->body = $safe->parse($post->body);
		}
	}
}

register_plugin('Wysiwyg');
?>
