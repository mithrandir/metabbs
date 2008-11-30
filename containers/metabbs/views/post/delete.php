<?php
$template = get_template($board, 'delete');
$template->set('board', $board);
$template->set('ask_password', $account->is_guest());
//$template->set('link_cancel', url_for($post, '', get_search_params()));
$_params = get_search_params();
$_params['board-name'] = $board->name;
$_params['id'] = $post->id;
$template->set('link_cancel', url_for_metabbs('post', 'index', $_params));
$template->render();
