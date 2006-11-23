<?php
function front_page_init() {
	add_handler('lobby', 'index', 'front_page_action');
}

function parse_expr($matches) {
	$parts = explode(' ', $matches[1]);
	$component = array_shift($parts);
	$options = array();
	foreach ($parts as $part) {
		list($key, $value) = explode('=', $part, 2);
		$options[$key] = $value;
	}
	if (function_exists('render_' . $component))
		return call_user_func('render_' . $component, $options);
	else
		trigger_error("unknown component '$component'", E_USER_WARNING);
}
function parse_template($str) {
	return preg_replace_callback('/\{\{(.+?)\}\}/', 'parse_expr', $str);
}

function front_page_action() {
	$data = implode('', file('data/front.html'));
	echo parse_template($data);
}
function front_page_setup() {
	if (is_post()) {
		$fp = fopen('data/front.html', 'w');
		fwrite($fp, $_POST['template']);
		fclose($fp);
	}
	echo '<form method="post" action="?">';
	echo '<textarea name="template" cols="60" rows="15" style="font-size: small">';
	readfile('data/front.html');
	echo '</textarea>';
	echo '<p><input type="submit" value="Save" /></p>';
	echo '</form>';
}
function front_page_install() {
	touch('data/front.html');
}

register_plugin('FrontPage', 'Provides a simple front page.', 'front_page_init', 'front_page_setup', 'front_page_install');
?>
