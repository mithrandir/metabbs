<?php
if (!$plugin->exists()) {
	$plugin->name = $id;
	$plugin->enabled = 1;
	$plugin->create();
} else {
	$plugin->enable();
}
redirect_to(url_for('admin', 'plugins'));

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
