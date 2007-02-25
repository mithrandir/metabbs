<?php
class Permission extends Model {
	var $model = 'permission';

	var $board_id;
	var $group_id;
	var $read = 0, $write = 0, $comment = 0, $moderate = 0;

	function _init() {
		$this->table = get_table_name('permission');
	}
}
?>
