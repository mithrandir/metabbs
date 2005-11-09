<?php
function url_for_board($board, $action) {
    return "?bid=$board->name&action=$action";
}
function url_for_post($post, $action) {
    return "?id=$post->id&action=$action";
}

function redirect_to($url) {
    header("Location: $url");
    exit;
}
function redirect_to_board($board, $action) {
    redirect_to(url_for_board($board, $action));
}
function redirect_to_post($post, $action) {
    redirect_to(url_for_post($post, $action));
}
function go_back() {
    $url = "";
    if (isset($_GET['url'])) {
        $url = $_GET['url'];
    }
    else if (isset($_SERVER['HTTP_REFERER'])) {
        $url = $_SERVER['HTTP_REFERER'];
    }
    if ($url) {
        redirect_to($url);
    }
}

function link_to($url, $text = '') {
    if (!$text) {
        $text = $url;
    }
    return sprintf('<a href="%s">%s</a>', $url, $text);
}
function link_to_board($board, $text, $action = 'list') {
    return link_to(url_for_board($board, $action), $text);
}
function link_to_post($post, $text = '', $action = 'show') {
    if (!$text) {
        $text = $post->subject;
    }
    return link_to(url_for_post($post, $action), $text);
}
?>
