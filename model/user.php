<?php
class Guest extends Model
{
	var $user;
	var $id = 0;
	var $level = 0;
	var $name = 'guest';
	var $email, $url;
	function is_guest() {
		return true;
	}
	function is_admin() {
		return false;
	}
}
?>
