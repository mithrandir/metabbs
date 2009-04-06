<?php
if (!$account->is_admin()) {
	access_denied();
}
$view = ADMIN_VIEW;
if (empty($routes['controller']) and empty($routes['action']))
	redirect_to(url_admin_for('board'));
?>
