<?php
$board_fixture = array(
	'test' => array(
		'id' => 1,
		'name' => 'test'
	),
	'second' => array(
		'id' => 2,
		'name' => 'second'
	)
);

$post_fixture = array(
	'first' => array(
		'id' => 1,
		'board_id' => 1,
		'title' => 'Hello!',
		'body' => 'Hello, world!'
	),
	'second' => array(
		'id' => 3,
		'board_id' => 1,
		'title' => 'second post',
		'body' => 'yeah'
	),
	'notice' => array(
		'id' => 2,
		'board_id' => 1,
		'title' => 'notice',
		'body' => 'ah, ah',
		'notice' => TRUE
	),
	'will be deleted' => array(
		'id' => 4,
		'board_id' => 2,
		'body' => 'RIP'
	)
);

$fixtures = array(
	'board' => $board_fixture,
	'post'  => $post_fixture
);
?>
