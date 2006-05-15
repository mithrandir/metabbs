<?php
require_once $lib_dir.'/Post.php';

class Board extends Model {
    var $count;

    function get_id_for_href() {
        return $this->name;
    }
    function find_by_name($name) {
        return model_find('board', null, "name='$name'");
    }
    function find($id) {
        return model_find('board', $id);
    }
    function find_all() {
        return model_find_all('board');
    }
    function get_posts($offset, $limit) {
        return model_find_all('post', 'board_id='.$this->id, 'id DESC', $offset, $limit);
    }
    function get_post_count() {
        if (!$this->count) {
            $this->count = model_count('post', 'board_id='.$this->id);
        }
        return $this->count;
    }
    function create() {
        $board = Board::find_by_name($this->name);
        if ($board->exists()) {
            return false;
        } else {
            model_insert('board', array(
                'name' => $this->name,
                'skin' => $this->skin,
                'posts_per_page' => $this->posts_per_page,
                'title' => $this->title,
                'use_attachment' => $this->use_attachment));
            return true;
        }
    }
    function update() {
        model_update('board', array(
	    'name' => $this->name,
            'skin' => $this->skin,
            'posts_per_page' => $this->posts_per_page,
            'title' => $this->title,
            'use_attachment' => $this->use_attachment),
	    'id='.$this->id);
        return true;
    }
    function delete() {
        model_delete('board', 'id='.$this->id);
        model_delete('post', 'board_id='.$this->id);
    }
}
?>
