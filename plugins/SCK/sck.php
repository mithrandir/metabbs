<?php
require_once dirname(__FILE__) . '/../../site_manager.php';

$GLOBALS['sck_context'] = null;

function sck_site_name() {
	global $config;
	return htmlspecialchars($config->get('sck_site_name'));
}

function sck_home_url() {
	return METABBS_BASE_PATH;
}

function sck_primary_menus() {
	return find_all('menu');
}

function sck_sidemenu_items() {
	global $sck_context;

	if ($sck_context)
		return $sck_context->get_submenu_items();
	else
		return array();
}

function sck_menu_url($menu) {
	if ($menu->type == 'board')
		return url_for(new Board(array('name' => $menu->get_attribute('board_name'))));
	else
		return url_for($menu);
}

function sck_stylesheet() {
	readfile(dirname(__FILE__) . '/files/style.css');
}

function sck_stylesheet_write($data) {
	$fp = fopen(dirname(__FILE__) . '/files/style.css', 'w');
	fwrite($fp, $data);
	fclose($fp);
}

class Menu extends Model {
	var $name, $type, $position = 0, $parent;
	var $body = '';

	var $model = 'menu';

	function get_submenu_items() {
		if ($this->type == 'board')
			return array();
		elseif ($this->type == 'dashboard')
			return array(/* TODO: dashboard items */);
		else
			return array();
	}
}

class SCKManagerMenu {
	function get_submenu_items() {
		return array(
			new MenuItem(i('Site'), url_for('sck', 'settings')),
			new MenuItem(i('Menus'), url_for('menu'))
		);
	}
}

class MenuItem {
	function MenuItem($text, $url) {
		$this->text = $text;
		$this->url = $url;
	}
}
