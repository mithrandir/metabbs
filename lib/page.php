<?php
class Page
{
	function Page(&$board, $page, $temp = false) {
		$this->page = $page;
		$this->padding = 2;
		if (!$temp) {
			$count = $board->get_post_count();
			if ($count) {
				$this->page_count = ceil($count / $board->posts_per_page);
			} else {
				$this->page_count = 1;
			}
		}
		$this->board = $board;
	}
	function has_next() {
		return ($this->page + 1) <= $this->page_count;
	}
	function next() {
		return new Page($this->board, $this->page + 1, true);
	}
	function has_prev() {
		return ($this->page - 1) > 0;
	}
	function prev() {
		return new Page($this->board, $this->page - 1, true);
	}
	function get_page_group() {
		$end = $this->end();
		$pages = array();
		for ($i = $this->start(); $i <= $end; $i++) {
			$pages[] = new Page($this->board, $i, true);
		}
		return $pages;
	}
	function get_href() {
		return url_for($this->board, '', array('page' => $this->page));
	}
	function start() {
		$start = $this->page - $this->padding;
		return ($start < 1) ? 1 : $start;
	}
	function end() {
		$end = $this->page + $this->padding;
		return ($end > $this->page_count) ? $this->page_count : $end;
	}
	function get_posts() {
		return $this->board->get_posts(($this->page - 1) * $this->board->posts_per_page, $this->board->posts_per_page);
	}
	function here() {
		return (Page::get_requested_page() == $this->page);
	}
	function is_first() {
		return $this->page == 1;
	}
	function first() {
		return new Page($this->board, 1, true);
	}
	function is_last() {
		return $this->page == $this->page_count;
	}
	function last() {
		return new Page($this->board, $this->page_count, true);
	}
	/*static*/ function get_requested_page() {
		return (isset($_GET['page']) ? $_GET['page'] : 1);
	}
}
?>
