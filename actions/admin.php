<?php
if (!$user->is_admin()) {
	access_denied();
}
$skin = '_admin';
render($action);
?>
