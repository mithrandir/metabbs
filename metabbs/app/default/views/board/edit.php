<?php
$template = get_template($board, 'write');
$template->set('board', $board);
$template->set('post', $post);
$template->set('error_messages', $error_messages);
$template->set('extra_attributes', $extra_attributes);
$params = get_search_params();
$template->set('link_list', url_for($board, null, $params));
$template->set('link_cancel', url_for($post, null, $params));
$template->set('preview', isset($preview) ? $preview : null);
$template->render();
