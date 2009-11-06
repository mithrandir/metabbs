<?php
/**
 * 해당 페이지의 링크를 만든다.
 * @param $page 페이지
 * @param $text 출력할 문자열
 * @param $controller 콘트롤러
 * @param $action 액션
 * @return 게시판 명과 페이지를 기준으로 링크를 만든다.
 * $text가 있는 경우에는 텍스트를 없는 경우엔 페이지 번호를 텍스트로 삼는다.
 */
function link_to_page($page, $text = null, $controller = null, $action = null) {
	return link_text(url_for_page($page, $controller, $action), $text ? $text : $page);
}

/*function link_to_admin_page($page, $text = null, $controller = null, $action = null) {
	return link_text(url_admin_for_page($page, $controller, $action), $text ? $text : $page);
}*/

function url_for_page($page, $controller = null, $action = null) {
	$params = get_search_params();
	$params['page'] = $page; 
	if ($page == 1) unset($params['page']);
	return url_for($controller, $action, $params);
}

/*function url_admin_for_page($page, $controller = null, $action = null) {
	$params = get_search_params();
	$params['page'] = $page; 
	if ($page == 1) unset($params['page']);
	return url_admin_for($controller, $action, $params);
}*/

/**
 * 실제 페이지를 출력한다.
 * @param $board 게시판명
 * @param $padding 앞뒤로 필요한 간격
 * @param $arrows 앞뒤페이지 텍스트
 */
function print_pages($board, $padding = 2, $arrows = null) {
	global $finder;
	$page = get_requested_page();
	$count = $finder->get_post_count();
	_print_pages($page, $count, $board->posts_per_page, $padding, $board, $arrows);
}

function _print_pages($page, $count, $per_page, $padding = 2, $controller = null, $arrows = null) {
	$prev_page_text = isset($arrows['prev']) ? $arrows['prev']:'&lsaquo;';
	$next_page_text = isset($arrows['next']) ? $arrows['next']:'&rsaquo;';
	$page_count = $count ? ceil($count / $per_page) : 1;
	$prev_page = $page - 1;
	$next_page = $page + 1;
	$page_group_start = $page - $padding;
	if ($page_group_start < 1) $page_group_start = 1;
	$page_group_end = $page + $padding;
	if ($page_group_end > $page_count) $page_group_end = $page_count;

	echo '<ul id="pages">';
	if ($prev_page > 0) {
		echo '<li class="prev">'.link_to_page($prev_page, $prev_page_text, $controller).'</li>';
	}
	if ($page_group_start > 1) {
		echo '<li>'.link_to_page(1, null, $controller).'</li>';
		if ($page_group_start > 2) echo '<li>...</li>';
	}
	for ($p = $page_group_start; $p <= $page_group_end; $p++) {
		if ($p == $page) echo '<li class="here">';
		else echo '<li>';
		echo link_to_page($p, null, $controller) . '</li>';
	}
	if ($page_group_end != $page_count) {
		if ($page_group_end < ($page_count - 1)) echo '<li>...</li>';
		echo '<li>'.link_to_page($page_count, null, $controller).'</li>';
	}
	if ($next_page <= $page_count) {
		echo '<li class="next">'.link_to_page($next_page, $next_page_text, $controller).'</li>';
	}
	echo "</ul>";
}

/*function _print_admin_pages($page, $count, $per_page, $padding = 2, $controller = null) {
	$prev_page_text = isset($arrows['prev']) ? $arrows['prev']:'&lsaquo;';
	$next_page_text = isset($arrows['next']) ? $arrows['next']:'&rsaquo;';
	$page_count = $count ? ceil($count / $per_page) : 1;
	$prev_page = $page - 1;
	$next_page = $page + 1;
	$page_group_start = $page - $padding;
	if ($page_group_start < 1) $page_group_start = 1;
	$page_group_end = $page + $padding;
	if ($page_group_end > $page_count) $page_group_end = $page_count;
	
	echo '<ul id="pages">';
	if ($prev_page > 0) {
		echo '<li class="prev">'.link_to_admin_page($prev_page, $prev_page_text, $controller).'</li>';
	}
	if ($page_group_start > 1) {
		echo '<li>'.link_to_admin_page(1, null, $controller).'</li>';
		if ($page_group_start > 2) echo '<li>...</li>';
	}
	for ($p = $page_group_start; $p <= $page_group_end; $p++) {
		if ($p == $page) echo '<li class="here">';
		else echo '<li>';
		echo link_to_admin_page($p, null, $controller) . '</li>';
	}
	if ($page_group_end != $page_count) {
		if ($page_group_end < ($page_count - 1)) echo '<li>...</li>';
		echo '<li>'.link_to_admin_page($page_count, null, $controller).'</li>';
	}
	if ($next_page <= $page_count) {
		echo '<li class="next">'.link_to_admin_page($next_page, $next_page_text, $controller).'</li>';
	}
	echo "</ul>";
}*/


// new feature
class Pages {
	var $container;
	var $controller;
	var $action;
	var $params;
	var $pages;
	var $prev_page_text;
	var $next_page_text;

	function Pages($arrows = null, $controller = null, $action = null, $params = null, $container='default') {
		$this->controller = $controller;
		$this->action = $action;
		$this->params = $params;
		$this->container = $container;
		$this->pages = array();
		$this->prev_page_text = isset($arrows['prev']) ? $arrows['prev']:'&lsaquo;';
		$this->next_page_text = isset($arrows['next']) ? $arrows['next']:'&rsaquo;';
	}

	function get_pages($page, $count, $per_page = 10, $padding = 2) {
		$page_count = $count ? ceil($count / $per_page) : 1;
		$prev_page = $page - 1;
		$next_page = $page + 1;
		$page_group_start = $page - $padding;
		if ($page_group_start < 1) $page_group_start = 1;
		$page_group_end = $page + $padding;
		if ($page_group_end > $page_count) $page_group_end = $page_count;

		if ($prev_page > 0)
			array_push($this->pages, array('text' =>$prev_page, 'name'=>'prev', 'url'=>$this->url_for_page($prev_page)));

		if ($page_group_start > 1) {
			array_push($this->pages, array('text' =>1, 'name'=>'page', 'url'=>$this->url_for_page(1)));
			if ($page_group_start > 2) array_push($this->pages, array('name'=>'padding', 'text'=>'...'));
		}
		for ($p = $page_group_start; $p <= $page_group_end; $p++)
			array_push($this->pages, array('text' =>$p, 'name'=>($p == $page ? 'here':'page'), 'url'=>$this->url_for_page($p)));

		if ($page_group_end != $page_count) {
			if ($page_group_end < ($page_count - 1)) array_push($this->pages, array('name'=>'padding', 'text'=>'...'));
			array_push($this->pages, array('text' =>$page_count, 'name'=>'page', 'url'=>$this->url_for_page($page_count)));
		}
		if ($next_page <= $page_count)
			array_push($this->pages, array('text' =>$next_page, 'name'=>'next', 'url'=>$this->url_for_page($next_page)));

		return $this->pages;
	}
	function url_for_page($page) {
		global $dispatcher;

		$params = get_search_params();
		$params['page'] = $page; 
		if ($page == 1) unset($params['page']);

		return $dispatcher->url_for($this->controller, $this->action, $params, $this->container);
	}
}

function get_board_pages($padding = 5) {
	global $finder;

	$board = $finder->get_board();
	$page = get_requested_page();
	$count = $finder->get_post_count();
	return get_pages($page, $count, $board->posts_per_page, $padding, $board);
}
function get_pages($page, $count, $per_page, $padding = 2, $controller = null, $container = null) {
	$_pages = New Pages(null, $controller, null, null, $container);
	$pages = $_pages->get_pages($page, $count, $per_page, $padding);
	ob_start();

	echo '<ul id="pages">';
	foreach($pages as $page):
		if ($page['name'] == 'padding'):
			echo '<li class="'.$page['name'].'">'.$page['text'].'</li>';
		elseif ($page['name'] == 'prev'):
			echo '<li class="'.$page['name'].'"><a href="'.$page['url'].'">'.$_pages->prev_page_text.'</a></li>';
		elseif ($page['name'] == 'next'):
			echo '<li class="'.$page['name'].'"><a href="'.$page['url'].'">'.$_pages->next_page_text.'</a></li>';
		else:
			echo '<li class="'.$page['name'].'"><a href="'.$page['url'].'">'.$page['text'].'</a></li>';
		endif;
	endforeach;
	echo '</ul>';

	$ob = ob_get_contents();
	ob_end_clean();
	return $ob;
}

?>
