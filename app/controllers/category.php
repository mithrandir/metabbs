<?php
if (!$account->is_admin()) {
	access_denied();
}
$skin = '_admin';
$category = Category::find($id);
?>
