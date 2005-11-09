<?php
require_once 'metabbs.php';

class MetaBBS extends Controller {
    function MetaBBS() {
        if (!isset($_GET['bid']) && isset($_GET['id'])) {
            $this->post = Post::find($_GET['id']);
            $this->board = $this->post->get_board();
            $this->bid = $this->board->name;
        }
        else if (isset($_GET['bid'])) {
            $this->bid = $_GET['bid'];
            $this->board = Board::find_by_name($this->bid);
        }
        else {
            die("no board name or id");
        }
        $this->skin = $this->board->skin;
    }
    function action_list() {
        $posts_per_page = $this->board->posts_per_page;
        if (isset($_GET['page'])) {
            $this->page = $_GET['page'];
        } else {
            $this->page = 1;
        }
        $this->posts = $this->board->get_posts(($this->page - 1) * $posts_per_page, $posts_per_page);
    }
    function action_show() {
    }
    function action_new() {
    }
    function action_edit() {
    }
    function action_delete() {
        if (isset($_POST['password']) && $this->post->password == md5($_POST['password'])) {
            $this->post->delete();
            redirect_to_board($this->board->name);
        }
        $this->render('ask_password');
    }
    function action_save() {
        global $flash;
        $post = $_POST['post'];
        if (!$this->post) {
            $this->post = new Post($post);
            $this->post->board_id = $this->board->id;
        } else {
            $p = $this->post->password;
            $this->post->import($post);
            if ($p != md5($post['password'])) {
                $flash = "Wrong password";
                $this->render("edit");
                return;
            }
        }
        $this->post->save();
        $id = $this->post->id;
        redirect_to("?id=$id&action=show");
    }
    function action_comment() {
        $comment = new Comment($_POST['comment']);
        $comment->post_id = $this->post->id;
        $comment->save();
        redirect_to("?id=$comment->post_id&action=show");
    }
}

if (!isset($_GET['action'])) {
    if (isset($_GET['id'])) {
        $action = 'show';
    }
    else if (isset($_GET['bid'])) {
        $action = 'list';
    }
} else {
    $action = $_GET['action'];
}

$metabbs = new MetaBBS();
$metabbs->execute($action);
?>
