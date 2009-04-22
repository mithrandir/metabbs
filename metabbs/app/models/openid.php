<?php
class Openid extends Model {
	var $model = 'openid';
	var $openid, $user_id;
	var $position = 1;
	var $created_at;

	function _init() {
		$this->table = get_table_name('openid');
	}

	function find($id) {
		return find('openid', $id);
	}
	function find_by_openid($openid) {
		return find_by('openid', 'openid', $openid);
	}
	function find_by_user($user) {
		if (!$user->exists()) return false;
		return find_all('openid', "user_id=$user->id", "created_at");
	}	
	function find_all() {
		return find_all('openid');
	}
	function get_user() {
		return find('user', $this->user_id);
	}
	function create() {
		$this->created_at = time();
		$max_position = $this->db->fetchone("SELECT MAX(position) FROM $this->table WHERE user_id=$this->user_id");
		$this->position = empty($max_position) ? 1 : $max_position + 1;
		Model::create();
	}
	function reset_position() {
		$user = $this->get_user();
		$openids = $this->db->fetchall("SELECT id FROM $this->table WHERE user_id={$user->id} ORDER BY position ASC");
		$position = 1;
		foreach($openids AS $openid) {
			$this->db->execute("UPDATE $this->table SET position={$position} WHERE id={$openid->id}");
			$position++;
		}
	}	
}
?>