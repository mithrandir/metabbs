<?php
$t = new Table('plugin');
$t->column('name', 'string', 45);
$t->column('enabled', 'integer', 1);
$t->add_index('name');
$t->add_index('enabled');
$conn->add_table($t);

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
