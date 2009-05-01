<?php
permission_required('admin', $board);

if (!$params['posts']) {
	// flash message : 포스트를 선택하세요
	redirect_back();
}

if (is_post() and isset($params['action'])) {
	switch ($params['action']) {
		case 'hide':
		foreach ($params['posts'] as $post_id) {
			$post = Post::find($post_id);
			$post->secret = 1;
			$post->update();
		}
		break;
		case 'show':
		foreach ($params['posts'] as $post_id) {
			$post = Post::find($post_id);
			$post->secret = 0;
			$post->update();
		}
		break;
		case 'delete':
		requireCore('thumbnail');
		foreach ($params['posts'] as $post_id) {
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
		foreach ($params['posts'] as $post_id) {
			$post = Post::find($post_id);
			$post->category_id = $_POST['category'];
			$post->update_category();
		}
		break;
		case 'move':
		$_board = new Board(array('id' => $params['board_id']));
		foreach (array_reverse($params['posts']) as $post_id) {
			$post = Post::find($post_id);
			$post->move_to($_board, isset($params['track']));
		}
		break;
		default:
			// flash message : 행위를 정하지 않았습니다.
			redirect_back();
		break;
	}
	// flash message : 처리되었습니다
	redirect_back();
}
?>
