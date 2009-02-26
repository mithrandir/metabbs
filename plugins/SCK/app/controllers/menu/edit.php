<?php
if (is_post()) {
	$menu = find('menu', $id);
	if ($menu->type == 'dashboard')
		$menu->set_attribute("dashboard_" . $_POST['position'], $_POST['board_name']);

	redirect_to(sck_menu_url($menu));
}
