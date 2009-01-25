<?php
$template_engine = 'standard';
$options = array('get_body_in_the_list' => true, 'build_comment_tree' => false, 'preload_attachments' => true);

if (!function_exists('blog_url')) {
	function blog_url($board) {
		return $board->name == 'blog' ? url_for('blog') : url_for($board);
	}
}
?>
