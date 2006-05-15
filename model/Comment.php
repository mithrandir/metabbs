<?php
class Comment extends Model {
    var $password;

    function find($id) {
        return model_find('comment', $id);
    }
    function delete() {
        model_delete('comment', 'id='.$this->id);
    }
    function get_board() {
        $post = $this->get_post();
        return $post->get_board();
    }
    function get_post() {
        return Post::find($this->post_id);
    }
    function create() {
        $this->created_at = time(); //XXX
        $this->id = model_insert('comment', array(
            'post_id'  => $this->post_id,
            'user_id'  => $this->user_id,
            'name'     => $this->name,
            'body'     => $this->body,
            'password' => md5($this->password),
            'created_at' => model_datetime()));
    }
}
?>
