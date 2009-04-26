<?php
if (is_post()) {
	if (isset($params['feed_board'])) {
		if (!empty($params['feed_board']['board_id']) && !empty($params['feed_board']['feed_id'])) {
			$feed_board = FeedBoard::find_by_feed_id_and_board_id($params['feed_board']['feed_id'], $params['feed_board']['board_id']);
			if (!$feed_board->exists()) {
				$feed_board = new FeedBoard(array('board_id'=> $params['feed_board']['board_id'], 'feed_id' => $params['feed_board']['feed_id']));
				$feed_board->create();
				Flash::set('피드-게시판 관계를 생성했습니다');
			} else {
				Flash::set('피드-게시판 관계가 존재합니다');
			}
			redirect_back();
		}
	}
	if (isset($params['delete']) && is_numeric($params['delete'])) {
		$feed_board = FeedBoard::find($params['delete']);
		var_dump($feed_board);
		$feed_board->delete();
		Flash::set('피드-게시판 관계를 삭제했습니다');
		redirect_back();
	}
}

$feed_boards = FeedBoard::find_all();
$boards = Board::find_all();
$feeds = Feed::find_all();
?>