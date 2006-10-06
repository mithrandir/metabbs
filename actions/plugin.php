<?php
if (!$account->is_admin()) {
	access_denied();
}
$plugin = Plugin::find_by_name($id);
?>
