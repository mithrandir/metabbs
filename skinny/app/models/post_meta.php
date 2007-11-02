<?php
class PostMeta {
	function PostMeta(&$post) {
		$this->post = $post;
		$this->db = get_conn();
		$this->table = get_table_name('post_meta');
		$this->attributes = array();
		$this->loaded = false;
	}
	function load() {
		if ($this->loaded) return;
		$result = $this->db->get_result("SELECT * FROM $this->table WHERE post_id={$this->post->id}");
		while ($data = $result->fetch()) {
			$this->attributes[$data['key']] = $data['value'];
		}
	}
	function get($key) {
		return array_key_exists($key, $this->attributes) ? $this->attributes[$key] : '';
	}
	function set($key, $value) {
		if (!array_key_exists($key, $this->attributes)) {
			$this->db->query("INSERT INTO $this->table (post_id, `key`, value) VALUES({$this->post->id}, ?, ?)", array($key, $value));
		} else {
			$this->db->query("UPDATE $this->table SET value=? WHERE post_id={$this->post->id} AND `key`=?", array($value, $key));
		}
		$this->attributes[$key] = $value;
	}
	function reset() {
		$this->db->query("DELETE FROM $this->table WHERE post_id={$this->post->id}");
	}
}
?>
