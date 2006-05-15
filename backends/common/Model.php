<?php
class Model
{
    var $id;

    function Model($attributes = array()) {
        $this->import($attributes);
        $this->db = get_conn();
        $this->model = strtolower(get_class($this));
    }
    function import($attributes) {
        if (!is_array($attributes)) {
            return;
        }
        foreach ($attributes as $key => $value) {
	    if ($key == 'posts_per_page' && $value <= 0) {
		$value = 10;
	    }
            $this->$key = $value;
        }
    }
    function exists() {
        return $this->id;
    }
    function save() {
        return (!$this->exists()) ? $this->create() : $this->update();
    }
    function create() { }
    function update() { }
    function get_body() {
        return format($this->body);
    }
    function get_id_for_href() {
    	return $this->id;
    }
    function get_href() {
	return get_base_uri() . $this->model . '/' . $this->get_id_for_href();
    }
}

?>
