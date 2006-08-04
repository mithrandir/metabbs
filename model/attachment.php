<?php
class Attachment extends Model
{
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
	function is_image() {
		return is_image($this->filename);
	}
	function get_filename() {
		return 'data/uploads/' . $this->id;
	}
	function get_size() {
		return filesize($this->get_filename());
	}
	function exist() {
		return file_exists($this->get_filename());
	}
}
?>
