<?php
$profiles = array(
	'board' => array(),
	'gallery' => array(
		'use_attachment' => true,
		'style' => 'gallery-default',
	),
	'blog' => array(
		'use_attachment' => true,
		'use_category' => true,
		'posts_per_page' => 5,
		'perm_write' => 255,
		'style' => 'blog-default',
	)
);

$board = new Board(array('name' => $_POST['name']));
if (empty($_POST['name'])) {
	echo "Board name is empty.";
	exit;
} else if (!$board->validate()) {
	header('HTTP/1.1 409 Conflict');
	echo "Board '$board->name' already exists.";
	exit;
} else {
	$profile = $profiles[$_POST['profile']];
	$board->import($profile);
	$board->create();
	redirect_to(url_for('admin'));
}
?>
