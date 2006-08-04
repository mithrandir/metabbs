<?php
class Trackback extends Model {
	var $post_id, $blog_name, $title, $excerpt, $url;
	function get_board() {
		$post = $this->get_post();
		return $post->get_board();
	}
	function get_post() {
		return Post::find($this->post_id);
	}
	function validate() {
		return $this->url && $this->blog_name;
	}
}
?>
