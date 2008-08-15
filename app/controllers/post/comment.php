<?php
permission_required('comment', $post);

if (!isset($_POST['comment'])) {
	$_POST['comment'] = array(
		'name' => @$_POST['author'],
		'password' => @$_POST['password'],
		'body' => $_POST['body']
	);
}

$comment = new Comment($_POST['comment']);
if (!$comment->valid()) {
	exit;
}
$comment->user_id = $account->id;
if (!$account->is_guest()) {
	$comment->name = $account->name;
} else {
	cookie_register('name', $comment->name);
}
$comment->post_id = $post->id;

apply_filters('PostComment', $comment, array('reply' => false));

if($config->get('captcha_name', false) != "none" && $board->use_captcha() && $guest)
	$captcha = new Captcha($config->get('captcha_name', false), $captcha_arg);

if (isset($captcha) && $captcha->ready() && $captcha->is_valid($_POST) 
	|| isset($captcha) && !$captcha->ready() 
	|| !isset($captcha)) {
	$post->add_comment($comment);

	if (is_xhr()) {
		$template = get_template($board, '_comment');
		apply_filters('PostViewComment', $comment);
		$template->set('board', $board);
		$template->set('comment', $comment);
		$template->render_partial();
		exit;
	} else {
		redirect_to(url_for($post));
	}
}
?>
