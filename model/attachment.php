<?php
class Attachment extends Model
{
	function find($id) {
		return model_find('attachment', $id);
	}
	function get_board() {
		$post = $this->get_post();
		return $post->get_board();
	}
	function get_post() {
		return Post::find($this->post_id);
	}
	function create() {
		$this->id = model_insert('attachment', array(
			'post_id' => $this->post_id,
			'filename' => $this->filename));
	}
	function delete() {
		model_delete('attachment', 'id='.$this->id);
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
