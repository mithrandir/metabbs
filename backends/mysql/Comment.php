<?php
class Comment extends Model {
    function create() {
        $this->db->query("INSERT INTO meta_comments (post_id, name, body, password) VALUES($this->post_id, '$this->name', '$this->body', MD5('$this->password'))");
        $this->id = $this->db->insertid();
    }
}
?>
