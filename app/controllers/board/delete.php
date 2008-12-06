<?php
if (!$account->is_admin()) {
	access_denied();
} else {
	$board->delete();
	Flash::set('Board has been deleted.');
	redirect_to(url_for('admin'));
}
?>
