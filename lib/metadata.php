<?php
$extra_attributes = array();

class Attribute {
	var $size = 50;

	function Attribute($key, $name = '') {
		if (!$name) $name = $key;
		$this->key = $key;
		$this->name = $name;
	}
	function render($value) {
		echo "<input type=\"text\" name=\"meta[$this->key]\" size=\"$this->size\" value=\"$value\" />";
	}
	function add() {
		global $extra_attributes;
		$extra_attributes[] = &$this;
	}
}
class ComboBox extends Attribute {
	var $items = array();

	function add_item($value, $text) {
		$this->items[] = array($value, $text);
	}
	function render($value) {
		echo "<select name=\"meta[$this->key]\">";
		foreach ($this->items as $item) {
			echo option_tag($item[0], $item[1], $item[0] == $value);
		}
		echo "</select>";
	}
}
class Radio extends ComboBox {
	function render($value) {
		if ($value === '') $value = $this->items[0][0];
		foreach ($this->items as $item) {
			$checked = ($value == $item[0]) ? ' checked="checked"' : '';
			echo "<input type=\"radio\" name=\"meta[$this->key]\" value=\"$item[0]\"$checked /> $item[1]";
		}
	}
}
class Checkbox extends Attribute {
	function render($value) {
		echo check_box('meta', $this->key, $value == 1);
	}
}
$c = new Attribute('tst');
$c->add();
?>
