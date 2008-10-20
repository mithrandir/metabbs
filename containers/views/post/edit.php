<?php
$template = get_template($board, 'write');
$template->set('board', $board);
$template->set('post', $post);
$template->set('extra_attributes', $extra_attributes);
$params = get_search_params();
$template->set('link_list', url_for($board, '', $params));
$template->set('link_cancel', url_for($post, '', $params));
$template->set('preview', isset($preview) ? $preview : null);
$template->render();
