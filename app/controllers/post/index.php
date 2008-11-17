<?php
permission_required('read', $post);

if (isset($_GET['search'])) {
	$board->search = array_merge($board->search, $_GET['search']);
}

// backward compatibility; #156
if (cookie_is_registered('seen_posts')) {
	$seen_posts = explode(',', cookie_get('seen_posts'));
	$_SESSION['seen_posts'] = $seen_posts;
	cookie_unregister('seen_posts');
}

if (!session_is_registered('seen_posts')) {
	$_SESSION['seen_posts'] = array();
}

if (!in_array($post->id, $_SESSION['seen_posts'])) {
	$post->update_view_count();
	$_SESSION['seen_posts'][] = $post->id;
}

$style = $board->get_style();

$captcha = $config->get('captcha_name', false) != "none" && $board->use_captcha() && $guest
	? new Captcha($config->get('captcha_name', false), $captcha_arg) : null;

if ($post->user_id) {
	$user = $post->get_user();
}
apply_filters('PostView', $post);

$older_post = $post->get_older_post();
$newer_post = $post->get_newer_post();
if ($older_post) apply_filters('PostView', $older_post);
if ($newer_post) apply_filters('PostView', $newer_post);

$comments = $post->get_comments($style->skin->get_option('build_comment_tree', true));
apply_filters_array('PostViewComment', $comments);

if ($account->has_perm('read', $post) === ASK_PASSWORD) {
	$password_required = !is_post() || md5($_POST['password']) != $post->password;
} else {
	$password_required = FALSE;
}
