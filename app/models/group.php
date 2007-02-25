<?php
class Group extends Model {
	var $model = 'group';
	var $name = '';

	function _init() {
		$this->table = get_table_name('group');
	}
}
?>
