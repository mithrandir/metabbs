<?php
var_dump($account);
if (!$account->is_admin()) {
	access_denied();
}
$view = ADMIN_VIEW;

?>
