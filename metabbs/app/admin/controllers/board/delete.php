<?php
if (is_post()) {
	$board->delete();
	Flash::set(i('Board has been deleted'));
	redirect_to(url_admin_for('board'));
}
?>
