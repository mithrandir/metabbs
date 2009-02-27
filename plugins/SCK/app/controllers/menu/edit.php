<?php
if (!$account->is_admin())
	access_denied();

$menu = find('menu', $id);
if (is_post()) {
	if ($menu->type == 'dashboard') {
		$menu->name = $_POST['name'];
		$menu->update();

		foreach ($_POST['board_name'] as $position => $name)
			$menu->set_attribute("dashboard_$position", $name);
	} elseif ($menu->type == 'page') {
		$menu->title = $_POST['page_title'];
		$menu->body = $_POST['page_body'];
		$menu->update();
	}

	redirect_to(sck_menu_url($menu));
}
