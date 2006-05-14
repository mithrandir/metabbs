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

function link_to($text, $controller, $action = null, $params = array()) {
	return block_tag("a", $text, array("href" => url_for($controller, $action, $params)));
}
function link_to_if($condition, $text, $controller, $action = null, $params = array()) {
	if ($condition) {
		return link_to($text, $controller, $action, $params);
	} else {
		return "";
	}
}
?>
