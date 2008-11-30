<?php
$template = get_template($board, 'write');
$template->set('board', $board);
$template->set('post', $post);
$template->set('extra_attributes', $extra_attributes);
//$params = get_search_params();
$_params = get_search_params();
$_params['board-name'] = $board->name;
//$template->set('link_list', url_for($board, '', $params));
//$template->set('link_cancel', url_for($post, '', $params));
$template->set('link_list', url_for_metabbs('board', 'index', $_params));
$_params['id'] = $post->id;
$template->set('link_cancel', url_for_metabbs('post', 'index', $_params));
$template->set('preview', isset($preview) ? $preview : null);
$template->render();
