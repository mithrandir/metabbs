<?php
if (!$user->is_admin()) {
	access_denied();
} else {
	$board->delete();
	redirect_to(url_for('admin'));
}
?>
