<?php
if (is_post()) {
	$profiles = array(
		'board' => array(
			'order_by' => 'created_at DESC'),
		'gallery' => array(
			'use_attachment' => true,
			'style' => 'gallery-default',
			'order_by' => 'created_at DESC',
		),
		'blog' => array(
			'use_attachment' => true,
			'use_category' => true,
			'posts_per_page' => 5,
			'perm_write' => 255,
			'style' => 'blog-default',
			'order_by' => 'created_at DESC',
		)
	);

	if (!isset($params['name']) || $params['name'] == '')
		$error_messages->add(i('Board name is empty'));
	else 
		if (preg_match('/^([a-zA-Z0-9_\-]+)$/', $params['name']) == 0) 
			$error_messages->add(i('Board name\'s pattern is \'%s\'', '[a-zA-Z0-9_-]+'));

	$board = Board::find_by_name($params['name']);
	if ($board->exists()) {
		$error_messages->add(i('Board \'%s\' already exists', $board->name));
	} else {
		$board = new Board(array('name' => $params['name']));
	}

	if (!$error_messages->exists()) {
		$profile = $profiles[$params['profile']];
		$board->import($profile);
		$board->create();
		Flash::set('Board has been created');
		redirect_to(url_admin_for('board'));
	}
}
	
$boards = Board::find_all();
?>
