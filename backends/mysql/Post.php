<?php
require_once $lib_dir.'/Comment.php';

class Post extends Model {
    var $id, $count;
    
    function get_board() {
        return Board::find($this->board_id);
    }
    function find($id) {
        $db = get_conn();
        $attributes = $db->fetchrow("SELECT id, board_id, name, subject, body, password, UNIX_TIMESTAMP(created_at) as created_at FROM meta_posts WHERE id=$id");
        return new Post($attributes);
    }
    function create() {
        $this->db->query("INSERT INTO meta_posts (board_id, name, subject, body, password) VALUES($this->board_id, '$this->name', '$this->subject', '$this->body', MD5('$this->password'))");
        $this->id = $this->db->insertid();
    }
    function update() {
        $this->db->query("UPDATE meta_posts SET name='$this->name', subject='$this->subject', body='$this->body', created_at=NOW() WHERE id=$this->id");
    }
    function delete() {
        $this->db->query("DELETE FROM meta_posts WHERE id=$this->id");
    }
    function get_comments() {
        $comments = array();
        $_comments = $this->db->fetchall("SELECT id, post_id, name, password, body, UNIX_TIMESTAMP(created_at) as created_at FROM meta_comments WHERE post_id=$this->id");
        foreach ($_comments as $_ => $attributes) {
            $comments[] = new Comment($attributes);
        }
        return $comments;
    }
    function get_comment_count() {
        if (!$this->count) {
            $this->count = $this->db->fetchone("SELECT COUNT(*) FROM meta_comments WHERE post_id=$this->id");
        }
        return $this->count;
    }
}
?>
