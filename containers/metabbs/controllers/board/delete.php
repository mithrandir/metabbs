<?php
if (!$account->is_admin()) {
	access_denied();
} else {
	$board->delete();
//	redirect_to(url_for('admin'));
	redirect_to(url_for_admin());
}
?>
