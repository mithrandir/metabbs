<?php
if (!$account->is_admin()) {
	access_denied();
}
$view = ADMIN_VIEW;
$layout->add_stylesheet(METABBS_BASE_PATH . 'media/style.css');
$layout->add_javascript(METABBS_BASE_PATH . 'media/admin.js');
$layout->header = $layout->footer = '';
if (empty($routes['controller']) and empty($routes['action']))
	redirect_to(url_admin_for('board'));
?>
