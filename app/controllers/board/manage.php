<?php
permission_required('admin', $board);

if (!$_POST['posts'])
	redirect_back();

if (isset($_POST['action'])) {
	switch ($_POST['action']) {
		case 'delete':
		foreach ($_POST['posts'] as $post_id) {
			$post = Post::find($post_id);
			$attachments = $post->get_attachments();
			foreach ($attachments as $attachment) {
				@unlink($attachment->get_filename());
				$attachment->delete();
			}
			$post->delete();
		}
		break;
		case 'change-category':
		foreach ($_POST['posts'] as $post_id) {
			$post = Post::find($post_id);
			$post->category_id = $_POST['category'];
			$post->update_category();
		}
		break;
		case 'move':
		$_board = new Board(array('id' => $_POST['board_id']));
		foreach ($_POST['posts'] as $post_id) {
			$post = Post::find($post_id);
			$post->move_to($_board, isset($_POST['track']));
		}
		break;
	}
	redirect_to(url_for($board));
}
?>
