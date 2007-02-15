<?php
$post = Post::find($id);

if ($board->perm_read > $account->level) {
	access_denied();
}

$style->set('post', $post);

if ($post->secret) {
	if ($post->user_id != $account->id && !$account->is_admin()) {
		access_denied();
	} else if ($post->user_id == 0 && $account->is_guest()) {
		if (is_post() && md5($_POST['password']) == $post->password) {
		} else {
			$style->render('secret');
			return;
		}
	}
}

apply_filters('PostView', $post);
$comments = $post->get_comments();
apply_filters_array('PostViewComment', $comments);

$style->set('newer_post', $post->get_newer_post());
$style->set('older_post', $post->get_older_post());
$style->set('attachments', $post->get_attachments());
$style->set('comments', $comments);
$style->set('trackbacks', $post->get_trackbacks());

$style->set('commentable', $account->level >= $board->perm_comment);
$style->set('owner', $account->id == $post->user_id || $account->level >= $board->perm_delete);

// TODO: 페이지 자동 계산
$style->set('link_list', url_for($board, null, array('page' => get_requested_page())));
$style->set('link_new_post', url_for($board, 'post'));
$style->set('link_edit', url_for($post, 'edit'));
$style->set('link_delete', url_for($post, 'delete'));

$style->render('view');
?>
