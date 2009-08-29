<?php
$title = htmlspecialchars(i('New Post') . ' - ' . $board->get_title());

$template = get_template($board, 'write');
$template->set('board', $board);
$template->set('post', $post);
$template->set('error_messages', $error_messages);
$template->set('preview', isset($preview) ? $preview : null);
$template->set('extra_attributes', $extra_attributes);
$template->set('link_list', url_for($board, null, get_search_params()));
$template->set('link_cancel', '');
$template->render();
