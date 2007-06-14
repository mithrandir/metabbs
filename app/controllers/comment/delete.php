<?php
authz_require($account, 'delete', $comment);

$post = $comment->get_post();
if (is_post()) {
	if ($account->is_guest())
		$comment->deleted_by = $comment->name;
	else
		$comment->deleted_by = $account->name;
	$comment->delete();
	redirect_to(url_for($post));
} else {
	$link_cancel = url_for($post);
	$ask_password = false; // backward compatibility
}
?>
