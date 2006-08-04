<?php
class Trackback extends Model {
	var $post_id, $blog_name, $title, $excerpt, $url;
	function _init() {
		$this->post = $this->belongs_to('post');
	}
	function get_board() {
		$post = $this->get_post();
		return $post->get_board();
	}
	function get_post() {
		return $this->post->find();
	}
	function validate() {
		return $this->url && $this->blog_name;
	}
}
?>
