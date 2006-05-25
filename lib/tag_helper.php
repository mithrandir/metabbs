<?php
function block_tag($name, $content, $options = array()) {
	$s = "<$name";
	foreach ($options as $key => $value) {
		$s .= " $key=\"$value\"";
	}
	if ($content !== null) {
		$s .= ">$content</$name>";
	} else {
		$s .= " />";
	}
	return $s;
}

function inline_tag($name, $options = array()) {
	return block_tag($name, null, $options);
}

function link_text($link, $text = '', $options = array()) {
    if (!$text) $text = $link;
    $options['href'] = $link;
	return block_tag('a', $text, $options);
}
function link_to($text, $controller, $action = null, $params = array()) {
	return link_text(url_for($controller, $action, $params), $text);
}
function link_with_id_to($id, $text, $controller, $action = null, $params = array()) {
	return link_text(url_for($controller, $action, $params), $text, array("id" => $id));
}
function link_to_if($condition, $default, $text, $controller, $action = null, $params = array()) {
	if ($condition) {
		return link_to($text, $controller, $action, $params);
	} else {
		return $default;
	}
}

function link_to_comments($post) {
    if ($post->get_comment_count() > 0) {
        return link_text(url_for($post) . "#comments", "[" . $post->get_comment_count() . "]");
    } else {
        return "";
    }
}
function link_to_user($user) {
    if ($user->is_guest()) {
        return $user->name;
    } else {
        return link_to($user->name, $user);
    }
}
function link_to_post($post) {
    return link_to($post->title, $post, '', array('page' => Page::get_requested_page()));
}

function image_tag($src, $alt = "") {
    return inline_tag("img", array("src" => $src, "alt" => $alt));
}

function label_tag($label, $model, $field) {
    return block_tag("label", $label, array("for" => "${model}_${field}"));
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
    return block_tag("textarea", htmlspecialchars($value), $options);
}
function submit_tag($label) {
    return inline_tag("input", array("type" => "submit", "value" => $label));
}
?>
