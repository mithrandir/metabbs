<?php
if (!isset($params['id'])) {
	header('HTTP/1.1 404 Not Found');
	print_notice(i('No post id'), i('Please append the post id.'));
}
$post = Post::find($params['id']);
if (!$post->exists()) {
	header('HTTP/1.1 404 Not Found');
	print_notice(i('Post not found'), i("Post #%d doesn't exist.", $params['id']));
}
$board = $post->get_board();
if ($post->moved_to) {
	if ($routes['action'] == 'index') $routes['action'] = null;
//	redirect_to(url_for(new Post(array('id' => $post->moved_to)), $action));
	redirect_to(url_for_metabbs('post', $routes['action'], array('board-name'=>$board->name, id=>$post->moved_to)));
}
$title = htmlspecialchars($board->get_title() . " - $post->title");
?>
