<?php
permission_required('reply', $comment);

if (is_post() && !isset($_POST['comment'])) {
	$_POST['comment'] = array(
		'name' => $_POST['author'],
		'password' => $_POST['password'],
		'body' => $_POST['body']
	);
}

$captcha = $config->get('captcha_name', false) != "none" && $board->use_captcha() && $guest
	? new Captcha($config->get('captcha_name', false), $captcha_arg) : null;

if (is_post()) {
	$_comment = new Comment($_POST['comment']);
	$_comment->user_id = $account->id;
	$_comment->post_id = $comment->post_id;
	$_comment->parent = $comment->id;
	if (!$_comment->valid()) {
		exit;
	}
	if (!$account->is_guest()) {
		$_comment->name = $account->name;
	} else {
		cookie_register('name', $_comment->name);
	}

	apply_filters('PostComment', $_comment, array('reply' => TRUE));

	$post = $comment->get_post();
	if (isset($captcha) && $captcha->ready() && $captcha->is_valid($_POST) 
		|| isset($captcha) && !$captcha->ready() 
		|| !isset($captcha)) {
		$post->add_comment($_comment);

		if (is_xhr()) {
			apply_filters('PostViewComment', $_comment);
			$template = get_template($board, '_comment');
			$template->set('board', $board);
			$template->set('comment', $_comment);
			$template->render_partial();
			exit;
		} else {
			redirect_to(url_for($post));
		}
	}
} else {
	$post = $comment->get_post();

	$template = get_template($board, 'reply');
	$template->set('board', $board);
	$template->set('captcha', $captcha);
	$template->set('comment', $comment);
	$template->set('name', cookie_get('name'));
//	$template->set('link_cancel', url_for($post));
	$template->set('link_cancel', url_for_metabbs('post', null, array('id'=>$post->id, 'board-name'=>$board->name)));
	if (is_xhr()) {
		$template->render_partial();
		exit;
	}
}
?>
