<?php
class Trackback extends Model {
    function get_board() {
        $post = $this->get_post();
        return $post->get_board();
    }
    function get_post() {
        return Post::find($this->post_id);
    }
    function create() {
        $this->id = model_insert('trackback', array(
            'post_id'   => $this->post_id,
            'blog_name' => $this->blog_name,
            'title'     => $this->title,
            'excerpt'   => $this->excerpt,
            'url'       => $this->url));
        return true;
    }
}
?>
