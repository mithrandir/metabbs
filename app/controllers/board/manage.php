<?php
permission_required('admin', $board);

if (!$_POST['posts'])
	redirect_back();

if (isset($_POST['action'])) {
	switch ($_POST['action']) {
		case 'hide':
		foreach ($_POST['posts'] as $post_id) {
			$post = Post::find($post_id);
			$post->secret = 1;
			$post->update();
		}
		break;
		case 'show':
		foreach ($_POST['posts'] as $post_id) {
			$post = Post::find($post_id);
			$post->secret = 0;
			$post->update();
		}
		break;
		case 'delete':
		include 'lib/thumbnail.php';
		foreach ($_POST['posts'] as $post_id) {
			$post = Post::find($post_id);
			$attachments = $post->get_attachments();
			foreach ($attachments as $attachment) {
				$ext = get_image_extension($attachment->get_filename());
				$thumb_path = 'data/thumb/'.$attachment->id.'-small.'.$ext;
				if (file_exists($thumb_path)) {
					@unlink($thumb_path);
				}
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
		foreach (array_reverse($_POST['posts']) as $post_id) {
			$post = Post::find($post_id);
			$post->move_to($_board, isset($_POST['track']));
		}
		break;
	}
	$params = null;
	apply_filters('BeforeRedirectAtManagePosts', $params, $board);
	redirect_to(url_for($board, '', $params));
}
?>
