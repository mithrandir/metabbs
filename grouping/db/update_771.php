<?php
set_time_limit(0);

$t = new Table('group');
$t->column('name', 'string', 45);
$conn->add_table($t);

$conn->add_field('user', 'group_id', 'integer');
$conn->add_index('user', 'group_id');
$conn->add_field('user', 'admin', 'boolean');

$groups = array();
$users = User::find_all();
foreach ($users as $user) {
	if (!array_key_exists($user->level, $groups)) {
		$group = new Group;
		if ($user->level == 255)
			$group->name = "Administrators";
		else if ($user->level == 1)
			$group->name = "Users";
		else
			$group->name = "Level $user->level";
		$group->create();
		$groups[$user->level] = $group;
	}
	$user->group_id = $groups[$user->level]->id;
	if ($user->level == 255) $user->admin = true;
	$user->update();
}

$conn->drop_field('user', 'level');

$t = new Table('permission');
$t->column('board_id', 'integer');
$t->column('group_id', 'integer');
$t->column('read', 'boolean');
$t->column('write', 'boolean');
$t->column('comment', 'boolean');
$t->column('moderate', 'boolean');
$conn->add_table($t);

$boards = Board::find_all();
foreach ($boards as $board) {
	$p = array();
	foreach ($groups as $lv => $group) {
		$perm = new Permission;
		$perm->board_id = $board->id;
		$perm->group_id = $group->id;
		$p[$lv] = $perm;
	}

	for ($lv = $board->perm_read; $lv <= 255; $lv++)
		if (isset($p[$lv])) $p[$lv]->read = 1;
	for ($lv = $board->perm_write; $lv <= 255; $lv++)
		if (isset($p[$lv])) $p[$lv]->write = 1;
	for ($lv = $board->perm_comment; $lv <= 255; $lv++)
		if (isset($p[$lv])) $p[$lv]->comment = 1;
	for ($lv = $board->perm_delete; $lv <= 255; $lv++)
		if (isset($p[$lv])) $p[$lv]->moderate = 1;

	foreach ($p as $perm) {
		$perm->create();
	}
}

$conn->drop_field('board', 'perm_read');
$conn->drop_field('board', 'perm_write');
$conn->drop_field('board', 'perm_comment');
$conn->drop_field('board', 'perm_delete');
?>
