<?php
if (!$account->is_admin()) {
	access_denied();
}
$plugin = Plugin::find_by_name($id);

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
