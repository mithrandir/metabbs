<?php
if (!$account->is_admin()) {
	access_denied();
}
$view = ADMIN_VIEW;
$category = Category::find($id);
?>
