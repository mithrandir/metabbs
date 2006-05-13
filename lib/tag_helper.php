<?php
function block_tag($name, $content, $options = array()) {
	$s = "<$name";
	foreach ($options as $key => $value) {
		$s .= " $key=\"$value\"";
	}
	$s .= ">$content</$name>";
	return $s;
}
?>
