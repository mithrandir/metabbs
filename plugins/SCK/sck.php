<?php
require_once dirname(__FILE__) . '/../../site_manager.php';

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

function sck_menu_url($menu) {
	if ($menu->type == 'board')
		return url_for(new Board(array('name' => $menu->get_attribute('board_name'))));
	else
		return url_for($menu);
}

class Menu extends Model {
	var $name, $type, $position = 0, $parent;
	var $body = '';

	var $model = 'menu';
}
