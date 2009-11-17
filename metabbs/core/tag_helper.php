<?php
function block_tag($name, $content, $options = null) {
	if (is_null($options)) $options = array();
	$s = "<$name";
	foreach ($options as $key => $value) {
		if (isset($value) && !empty($value)) $s .= " $key=\"$value\"";
	}
	if (isset($content)) {
		$s .= ">$content</$name>";
	} else {
		$s .= " />";
	}
	return $s;
}

function inline_tag($name, $options = null) {
	return block_tag($name, null, $options);
}

function link_text($link, $text = '', $options = null) {
    if (!$text) $text = $link;
    $options['href'] = $link;
	return block_tag('a', $text, $options);
}
function link_to($text, $controller, $action = null, $params = null, $options = null) {
	return link_text(url_for($controller, $action, $params), $text, $options);
}
function link_with_id_to($id, $text, $controller, $action = null, $params = null, $options = null) {
	if (is_null($options)) $options = array();
	$options['id'] = $id;
	return link_text(url_for($controller, $action, $params), $text, $options);
}
function link_with_dialog_to($text, $controller, $action = null, $params = null, $options = null) {
	if (is_null($options)) $options = array();
	$options['onclick'] = 'return confirm(\''.i('Are you sure?').'\')';
	return link_text(url_for($controller, $action, $params), $text, $options);
}
function link_by_post_to($text, $controller, $action = null, $params = null, $options = null) {
	if (is_null($options)) $options = array();
	$options['onclick'] = 'var f = document.createElement(\'form\');f.style.display = \'none\';this.parentNode.appendChild(f);f.method = \'POST\';f.action = this.href;f.submit();return false;';
	return link_text(url_for($controller, $action, $params), $text, $options);
}
function link_with_dialog_by_post_to($text, $controller, $action = null, $params = null, $options = null) {
	if (is_null($options)) $options = array();
	$options['onclick'] = 'if (confirm(\''.i('Are you sure?').'\')) { var f = document.createElement(\'form\');f.style.display = \'none\';this.parentNode.appendChild(f);f.method = \'POST\';f.action = this.href;f.submit();}return false;';
	return link_text(url_for($controller, $action, $params), $text, $options);
}

function link_admin_to($text, $controller, $action = null, $params = null, $options = null) {
	return link_text(url_admin_for($controller, $action, $params), $text, $options);
}
function link_admin_with_referer_to($text, $controller, $action = null, $params = null, $options = null) {
	return link_text(url_admin_with_referer_for($controller, $action, $params), $text, $options);
}
function link_admin_with_dialog_to($text, $controller, $action = null, $params = null, $options = null) {
	if (is_null($options)) $options = array();
	$options['onclick'] = 'return confirm(\''.i('Are you sure?').'\')';
	return link_text(url_admin_for($controller, $action, $params), $text, $options);
}
function link_admin_by_post_to($text, $controller, $action = null, $params = null, $options = null) {
	if (is_null($options)) $options = array();
	$options['onclick'] = 'var f = document.createElement(\'form\');f.style.display = \'none\';this.parentNode.appendChild(f);f.method = \'POST\';f.action = this.href;f.submit();return false;';
	return link_text(url_admin_for($controller, $action, $params), $text, $options);
}
function link_admin_with_dialog_by_post_to($text, $controller, $action = null, $params = null, $options = null) {
	if (is_null($options)) $options = array();
	$options['onclick'] = 'if (confirm(\''.i('Are you sure?').'\')) {var f = document.createElement(\'form\');f.style.display = \'none\';this.parentNode.appendChild(f);f.method = \'POST\';f.action = this.href;f.submit();}return false;';
	return link_text(url_admin_for($controller, $action, $params), $text, $options);
}

function link_list_tab($link, $name, $text) {
	global $routes;
	$anchor = link_text($link, $text);
	return block_tag('li', $anchor, array('id' => "tab-$name", 'class' => $routes['action']==$name ? "selected" : null));
}
function link_to_comments($post) {
	$count = $post->get_comment_count();
    if ($count == 0) {
		return "";
	} else {
        return "<a href=\"".url_for($post)."#comments\">[$count]</a>";
    }
}
function link_to_user($user) {
	$name = $user->name;
    if ($user->is_guest()) {
        return $name;
    } else {
        return link_to($name, $user);
    }
}
function link_to_post($post) {
	global $account;
	if ($post->secret && !$account->has_perm('read', $post)) {
		return htmlspecialchars($post->title);
	} else {
		return link_to(htmlspecialchars($post->title), $post, '', get_search_params());
	}
}
function link_to_category($category) {
	return link_to(htmlspecialchars($category->name), $category->get_board(), '', array('category' => $category->id));
}

function image_tag($src, $alt = "", $options = array()) {
	$options['src'] = $src;
	$options['alt'] = $alt;
    return inline_tag("img", $options);
}

function label_tag($label, $model, $field) {
    return block_tag("label", i($label), array("for" => "${model}_${field}"));
}
function input_tag($name, $value, $type='text', $options=array()) {
    $options['name'] = $name;
    $options['value'] = htmlspecialchars($value);
    $options['type'] = $type;
    return inline_tag("input", $options);
}
function text_field($model, $field, $value = '', $size = 20) {
    return input_tag("${model}[${field}]", $value, 'text', array("id" => "${model}_${field}", "size" => $size));
}
function password_field($model, $field, $value = '', $size = 20) {
    return input_tag("${model}[${field}]", $value, 'password', array("id" => "${model}_${field}", "size" => $size));
}
function check_box($model, $field, $checked, $options = array()) {
	if ($checked) {
		$options['checked'] = 'checked';
	}
	$options['id'] = "${model}_${field}";
	return input_tag("${model}[$field]", 0, 'hidden') . input_tag("${model}[$field]", 1, 'checkbox', $options);
}
function text_area($model, $field, $rows = 10, $cols = 50, $value='', $options=array()) {
    $options['name'] = "${model}[${field}]";
    $options['rows'] = $rows;
    $options['cols'] = $cols;
	$options['id'] = "${model}_${field}";
    return block_tag("textarea", htmlspecialchars($value), $options);
}
function option_tag($value, $text, $selected = false, $options = array()) {
	$options['value'] = htmlspecialchars($value);
	if ($selected) $options['selected'] = 'selected';
	return block_tag('option', htmlspecialchars($text), $options);
}
function submit_tag($label) {
    return inline_tag("input", array("type" => "submit", "value" => i($label)));
}
?>
