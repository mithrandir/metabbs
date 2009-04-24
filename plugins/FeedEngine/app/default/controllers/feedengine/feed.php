<?php
switch($id) {
	case 'owner':
		$_GET['feed'] = isset($_GET['feed']) ? $_GET['feed']:$_POST['feed'];
		$_GET['user'] = isset($_GET['user']) ? $_GET['user']:$_POST['user'];

		$feed = Feed::find($_GET['feed']);
		$user = User::find($_GET['user']);

//		DEBUG CODE
/*		ob_start();
		var_dump($_GET['feed']);
		var_dump($_GET['user']);
		var_dump($_POST['feed']);
		var_dump($_POST['user']);
		$content = ob_get_contents();
		ob_end_clean();

		$fp = fopen(METABBS_DIR . '/test.log', 'a');
		fwrite($fp, $content);
		fclose($fp);
		exit;*/
		if (!$feed->exists() || !$user->exists()) {
			header('HTTP/1.1 404 Not Found');
			print_notice(i('Feed not found'), i("Feed #%d doesn't exist.", $id));
		}
		$feed_user = FeedUser::find_by_user_and_feed($user, $feed);

		$url = empty($_GET['url']) ? $_POST['url'] : $_GET['url'];
		$key = empty($_GET['key']) ? $_POST['key'] : $_GET['key'];
		$parsed = parse_url($url);

		if(empty($url) || empty($key) || strstr($feed->link, $parsed['scheme']."://".$parsed['host']."/") > 0) {
			header('HTTP/1.1 403 Forbidden');
			print_notice(i('Invalid Request'), i('This Page is not Available.'));
		}
		header("Content-type: text/xml");
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		echo "<response>\n";
		if($feed_user->get_attribute('trackback-key') == $key) {
			$feed->owner_id = $feed_user->get_attribute('owner-id');
			$feed->active = true;
			$feed->update();
			$feed_user->remove_attribute('trackback-key');
			$feed_user->remove_attribute('owner-id');
			$feed_user->membed_id = 1;
			$feed_user->update();
			echo "<error>0</error>\n";
		} else {
			echo "<error>1</error>\n";
			echo "<message>Unable to athorize trackback</message>\n";
		}
		echo '</response>';
		break;
	case 'update':
		$board = Board::find($_GET['board']);
		if($board->exists() && $board->get_attribute('feed-at-board')) {
			FeedParser::collect_feeds_to_board_by_random($board, 3600);
			echo "ok";
		}
		break;
	case 'updateViews':
		$board = Board::find_by_name($_GET['board']);
		$post = Post::find($_GET['post']);
		if($board->exists() && $board->get_attribute('feed-at-board') && $post->exists()) {
			// backward compatibility; #156
			if (cookie_is_registered('seen_posts')) {
				$seen_posts = explode(',', cookie_get('seen_posts'));
				$_SESSION['seen_posts'] = $seen_posts;
				cookie_unregister('seen_posts');
			}

			if (!session_is_registered('seen_posts')) {
				$_SESSION['seen_posts'] = array();
			}
			
			if (!in_array($post->id, $_SESSION['seen_posts'])) {
				$post->update_view_count();
				$_SESSION['seen_posts'][] = $post->id;
			}
		}
		break;
}
exit;
?>