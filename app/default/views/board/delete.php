<?php
$template = get_template($board, 'delete');
$template->set('board', $board);
$template->set('ask_password', $account->is_guest());
$template->set('error_messages', $error_messages);
$template->set('link_cancel', url_for($post, null, get_search_params()));
$template->render();
