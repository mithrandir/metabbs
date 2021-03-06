<?php
$template = $style->get_template('list');
$template->set('board', $board);

include dirname(__FILE__) . '/_list.php';

$title = htmlspecialchars($board->get_title());
$layout->add_link('alternate', 'application/rss+xml', url_for($board, 'rss'), 'RSS Feed');
$template->render();
