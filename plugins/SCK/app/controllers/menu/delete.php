<?php
if (!$account->is_admin())
	access_denied();

$menu = find('menu', $id);
$menu->delete();
redirect_to(url_for('menu'));
