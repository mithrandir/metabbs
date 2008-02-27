<?php
function fixture($model, $label) {
	global $fixtures;
	return $fixtures[$model][$label];
}

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

$category_fixture = array(
	'test' => array(
		'id' => 1,
		'board_id' => 1,
		'name' => 'Test Category'
	)
);

$post_fixture = array(
	'first' => array(
		'id' => 1,
		'board_id' => 1,
		'title' => 'Hello!',
		'body' => 'Hello, world!',
		'category_id' => 1
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
		'notice' => 1 //TRUE
	),
	'will be deleted' => array(
		'id' => 4,
		'board_id' => 2,
		'body' => 'RIP'
	),
	'metadata test' => array(
		'id' => 5,
		'board_id' => 3,
		'body' => '...',
		'meta' => array('foo' => 'bar')
	)
);

$comment_fixture = array(
	'test' => array(
		'id' => 1,
		'board_id' => 1,
		'post_id' => 1,
		'body' => 'hi'
	),
	'second' => array(
		'id' => 2,
		'board_id' => 1,
		'post_id' => 1,
		'body' => 'third'
	),
	'child' => array(
		'id' => 3,
		'board_id' => 1,
		'post_id' => 1,
		'parent' => 1,
		'body' => 'reply!'
	)
);

$fixtures = array(
	'post_meta' => array(), // dummy
	'board' => $board_fixture,
	'post'  => $post_fixture,
	'comment' => $comment_fixture,
	'category' => $category_fixture
);
?>
