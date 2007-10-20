<?php
$boards = Board::find_all();
foreach ($boards as $board) {
	if ($board->skin == 'default') {
		if ($board->style == '' || $board->style == 'default') {
			$board->style = 'default';
		} else if ($board->style == 'noble_dark') {
			$board->style = 'noble-dark';
		}
	} else if ($board->skin == 'blog') {
		if ($board->style == '' || $board->style == 'basic') {
			$board->style = 'blog-basic';
		} else if ($board->style == 'scribbish') {
			$board->style = 'blog-scribbish';
		}
	} else {
		$board->style = 'default';
	}
	$board->update();
}
$conn->drop_field('board', 'skin');
?>
