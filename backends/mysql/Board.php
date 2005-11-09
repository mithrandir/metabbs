<?php
require_once $lib_dir.'/Post.php';

class Board extends Model {
    var $count;

    /*static*/ function find_by_name($name) {
        $db = get_conn();
        return new Board($db->fetchrow("SELECT * FROM meta_boards WHERE name='$name'"));
    }
    /*static*/ function find($id) {
        $db = get_conn();
        return new Board($db->fetchrow("SELECT * FROM meta_boards WHERE id=$id"));
    }
    function get_posts($offset, $limit) {
        $posts = array();
        $_posts = $this->db->fetchall("SELECT id, board_id, name, subject, body, password, UNIX_TIMESTAMP(created_at) as created_at FROM meta_posts WHERE board_id=$this->id ORDER BY id DESC LIMIT $offset, $limit");
        foreach ($_posts as $_ => $attributes) {
            $posts[] = new Post($attributes);
        }
        return $posts;
    }
    function get_post_count() {
        if (!$this->count) {
            $this->count = $this->db->fetchone("SELECT COUNT(*) FROM meta_posts WHERE board_id=$this->id");
        }
        return $this->count;
    }
}
?>
