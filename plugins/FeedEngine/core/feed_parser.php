<?php
class FeedParser {
	var $sp;
	var $supported_mimes = array('image/gif'=>'gif', 'image/png'=>'png', 'image/jpeg'=>'jpg', 'image/pjpeg'=>'jpg');
	var $min_image_x = 130;
	var $min_image_y = 130;
	var $cache_duration = 3600;

	function FeedParser() {
		ini_set("include_path", dirname(__FILE__) . PATH_SEPARATOR . ini_get("include_path"));
		requireCoreofPlugin('FeedEngine', 'simplepie');

		$this->sp = new SimplePie();
		$this->sp->set_cache_location(METABBS_DIR ."/data/feed_cache");
		$this->sp->set_cache_duration($this->cache_duration);
		$this->sp->set_image_handler(METABBS_HOST_URL.'/feedengine/image/', 'q');
	}
	//class methods
	function relate_feed_by_users($level) {
		$db = get_conn();
		$table = get_table_name('user');
		$users = $db->fetchall("SELECT * FROM $table WHERE level >= $level", 'User');
		foreach ($users as $user) {
			if (!empty($user->url)) {
				FeedParser::relate_feed_by_user($user->url, $user);
			}
		}
	}
	function relate_feed_by_user($url, $user, $set_trackback_key = false, $owner_id = null) {
		$result = false;

		$fp = new FeedParser();
		$fp->sp->set_feed_url($url);
		if ($fp->sp->init()) {
			$fp->sp->handle_content_type();
			$feed = Feed::find_by_url($fp->sp->feed_url);
			if (!$feed->exists()) {
				unset($feed);
				$feed = new Feed();
				$feed->url = $fp->sp->feed_url;
				$feed->link = $fp->sp->get_link();
				$feed->title = $fp->sp->get_title();
				$feed->description = $fp->sp->get_description();
				$feed->owner_id = -1;
				$feed->create();
			}
			if (!$feed->is_related($user)) {
				$feed->relate_to_user($user);
				if (!is_null($owner_id)) {
					$feed->owner_id = $owner_id;
				} else {
					if ($set_trackback_key) {
						$feed_user = FeedUser::find_by_user_and_feed($user, $feed);
						if ($feed_user->exists()) {
							$feed_user->set_attribute('trackback-key', md5(microtime() . uniqid(rand(), true)));
							$feed_user->set_attribute('owner-id',$user->id);
						} else
							return false;
					}
				}
				$feed->update();
			}
			unset($feed);
			$result = true;
		}

		unset($fp);
		return $result;
	}
	function collect_feeds_to_board($board) {
		switch ($board->get_attribute('feed-range')) {
			case 0:
				$feeds = Feed::find_all();
				break;
			case 1:
				$feeds = Feed::find_all_having_owner();
				break;
			case 2:
				$feeds = Feed::find_all_by_board($board);
				break;
			case 3:
				$feeds = Feed::find_all_by_board_having_owner($board);
				break;
		}
		foreach ($feeds as $feed) {
			if (!empty($feed->url) && $feed->active)
				FeedParser::collect_feed_to_board($feed, $board);
		}
	}
	function collect_feeds_to_board_by_random($board, $duration) {
		switch ($board->get_attribute('feed-range')) {
			case 0:
				$feed = Feed::find_one_in_random($duration);
				break;
			case 1:
				$feed = Feed::find_one_having_owner_in_random($duration);
				break;
			case 2:
				$feed = Feed::find_one_by_board_in_random($board, $duration);
				break;
			case 3:
				$feed = Feed::find_one_by_board_having_owner_in_random($board, $duration);
				break;
		}
		if ($feed->exists() && !empty($feed->url) && $feed->active) {
			FeedParser::collect_feed_to_board($feed, $board);
		}
	}


	function collect_feed_to_board($feed, $board) {
		$result = false;

		$feedengine = new Config(METABBS_DIR . '/data/feedengine.php');
		$feed_mode = $feedengine->get('feed_mode', 0);
		unset($feedengine);

		$fp = new FeedParser();
		$fp->sp->set_feed_url($feed->url);
		if ($fp->sp->init()) {
			$fp->sp->handle_content_type();
			foreach ($fp->sp->get_items() as $item) {
				//특정 태그만 받음
				if ($board->get_attribute('feed-kind') == 1) {
					$categories = $item->get_categories(); 
					$tags = array();
					if(isset($categories)) {
						foreach($categories as $category) {
							if(isset($category)) {
								$term = $category->get_term();
								if(!empty($term))
									array_push($tags, str_replace(',','',$term));
							}
						}
					}

					if (serialize(array_diff($tags, explode(',', $board->get_attribute('tags')))) === serialize($tags))
						continue;
				}

				// 한국 피드들의 상황에 맞게 재배치
				$item_data = FeedParser::arrange_item_at_kor_env($item, $feed);
				// 이미지링크를 뽑아내고
				$image_urls = FeedParser::get_image_urls($item_data['body']);
				// 퍼머링크의 포스트가 존재하는지 
				$post = Feed::get_post_by_link($item_data['feed_link'], $board);
				if (!$post->exists()) {
					unset($post);

					$item_data['board_id'] = $board->id;
					$item_data['feed_id'] = $feed->id;
					// 한국형 필터
					FeedParser::filter_at_kor_env($item_data);
					$post = new Post($item_data);
					$post->create();
					// 피드 태그 재설정
					$post->arrange_tags_after_create();

					// 소유자가 있으면 소유자 프로필내용으로 업데이트
					if (!empty($feed->owner_id)) {
						$owner = User::find($feed->owner_id);
						if($owner->exists()) {
							$post->name = $owner->name;
							$post->user_id = $owner->id;
							$post->update();
						}
					} 
					// 생성 날짜를 다시 설정
					$post->created_at = $item_data['feed_pub_date'];
					$post->update();
					// 썸네일용 이미지 추가
					FeedParser::add_images($post, $image_urls);
					// 다채널 자동 그룹핑
					if ($board->get_attribute('feed-kind') == 2) {
						FeedParser::set_groups($board, $post);
					}
				} else {
					if ($post->feed_fp != $item_data['feed_fp']) {

						$item_data['body'] = strip_tags($item_data['body']);
						$post->import($item_data);
						// 생성 날짜를 다시 설정
						$post->created_at = $item_data['feed_pub_date'];
						$post->updated_at = time();
						$post->update();
						// 피드 태그 재설정
						$post->arrange_tags_after_update();
						
						if ($feed_mode == 0) {
							// 내용이 다를때 이전 이미지를 삭제하고 새로 추가
							FeedParser::remove_images($post);
							// 썸네일용 이미지 추가
							FeedParser::add_images($post, $image_urls);
							// 다채널 자동 그룹핑
							if ($board->get_attribute('feed-kind') == 2) {
								FeedParser::set_groups($board, $post);
							}
						}
					}
				}
			}

			$feed->update_at = time();
			$feed->update();
		} else
			$result = false;

		unset($fp);

		return $result;
	}
	// class methods
	function set_groups($board, $post) {
		$tags = array_trim(explode(',', $post->tags));
		$groups = Group::find_all();
		foreach ($groups as $group) {
			$group_tags = array_trim(explode(',', $group->tags));
			if(count(array_intersect($tags, $group_tags)) > 0)
				$group->relate_to_post($post);
			else
				$group->unrelate_to_post($post);

		}
	}
	function get_eolin_screenshot($url) {
		$temp = '';
		$response = file_get_contents('http://bmimg.eolin.com/wing/?url='.$url);
		if (empty($response)) {
			preg_match('/<error>(.+)<\/error>/', $response, $matches);
			if ($matches[1] != '1') {
				preg_match('/<captureimg>(.+)<\/captureimg>/', $response, $matches);
				$temp = $matches[1];
			}
		}
		return $temp;
	}
	function get_image_urls($temp) {
		$result = array();
		while (preg_match('/<img\s[^>]+/i', $temp, $matches)) {
			if (preg_match('/src\s*=\s*("|\')(.+?)\1/i', $matches[0], $m))
				array_push($result, $m[2]);
			else if (preg_match('/src\s*=\s*([^\s]+)/i', $matches[0], $m))
				array_push($result, $m[1]);
			$temp = substr($temp, strpos($temp, $matches[0]) + strlen($matches[0]) + 1);
		}
		return $result;
	}
	function add_images($post, $image_urls) {
		$fp = new FeedParser();

		if (!empty($image_urls)) {
			$attachments = array();
			$attachment_count = 0;
			foreach ($image_urls as $image_url) {
				$image_size= getimagesize($image_url);
				if (in_array($image_size['mime'], array_keys($fp->supported_mimes)) 
					&& $image_size[0] > $fp->min_image_x 
					&& $image_size[1] > $fp->min_image_y) {
					$image_filename = "attachment_" . $attachment_count . "." . $fp->supported_mimes[$image_size['mime']];
					$attachments[] = new Attachment( array('filename' => $image_filename, 
						'image_url' => $image_url, 
						'type' => $image_size['mime']) );
					$attachment_count ++;
					break;
				}
			}

			foreach ($attachments as $attachment) {
				$image_src = imagecreatefromstring(file_get_contents($attachment->image_url));
				$post->add_attachment($attachment);
				switch ($attachment->type) {
					case 'image/gif':
						imagegif($image_src, METABBS_DIR .'/data/uploads/'.$attachment->id);
						break;
					case 'image/png':
						imagepng($image_src, METABBS_DIR .'/data/uploads/'.$attachment->id);
						break;
					case 'image/jpeg':
						imagejpeg($image_src, METABBS_DIR .'/data/uploads/'.$attachment->id, 100);
						break;
				}

				imagedestroy($image_src);
				chmod(METABBS_DIR .'/data/uploads/' . $attachment->id, 0606);
			}
			$post->update_attachment_count();
		}

		unset($fp);
	}
	function remove_images($post) {
		include_once METABBS_DIR .'/core/thumbnail.php';
		$attachments = $post->get_attachments();
		foreach ($attachments as $attachment) {
			$ext = get_image_extension($attachment->get_filepath(true));
			$thumb_path = METABBS_DIR .'/data/thumb/'.$attachment->id.'-small.'.$ext;
			if (file_exists($thumb_path)) {
				@unlink($thumb_path);
			}
			@unlink($attachment->get_filename());
			$attachment->delete();
		}
		$post->attachment_count = 0;
		$post->update();
	}
	// kor_env
	function arrange_item_at_kor_env($item, $feed) {
		$feed_link = $item->get_link();
		
		$author = $item->get_author();
		if (isset($author)) {
			$author_name = $author->get_name();
			$author_email = $author->get_email();
			unset($author);
			$author = trim(empty($author_name) ? (empty($author_email) ? '':$author_email) : $author_name);
		} else
			$author = '';

		$title = $item->get_title();
		$description = $item->get_description();

		$categories = $item->get_categories();
		$tags = array();
		if(isset($categories)) {
			foreach($categories as $category) {
				if(isset($category)) {
					$term = $category->get_term();
					if(!empty($term))
						array_push($tags, str_replace(',','',$term));
				}
			}
		}
//		@array_shift($tags);	// first tags is category 

		$pub_date = $item->get_date('U');
		$feed_fp = md5($author.$title.$description.serialize($tags).$pub_date);

		$item = array();
		$item['name'] = empty($feed->owner_name) ? (empty($author) ? i('No Author') : $author) : $feed->owner_name;
		$item['password'] = '';
		$item['title'] = empty($title) ? i('No Title') : $title;
//		$item['body'] = empty($description) ? i('No Description') : $description;
		$item['body'] = empty($description) ? '&nbsp;' : $description;
		$item['tags'] = implode(",", $tags);
		$item['feed_link'] = $feed_link;
		$item['feed_pub_date'] = $pub_date;
		$item['feed_fp'] = $feed_fp;

		return $item;
	}
	function filter_at_kor_env(&$item_data) {
		$item_data['body'] = strip_tags($item_data['body']);
		$item_data['title'] = strip_tags($item_data['title']);

		$item_data['title'] = str_replace('&nbsp;', ' ', $item_data['title']);
		$item_data['body'] = str_replace('&nbsp;', ' ', $item_data['body']);

		$item_data['title'] = htmlspecialchars_decode($item_data['title']);
		$item_data['body'] = htmlspecialchars_decode($item_data['body']);
	}

	function get_feed_by_url($url) {
		$result = false;

		$fp = new FeedParser();
		$fp->sp->set_feed_url($url);
		if ($fp->sp->init()) {
			$fp->sp->handle_content_type();
			$result = $fp->sp;
		} else
			$result = false;

		unset($fp);
		return $result;
	}
}
?>