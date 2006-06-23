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
		return (get_requested_page() == $this->page);
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
}
function link_to_page($page, $text = null) {
	if (!$text) {
		$text = $page->page;
	}
	return link_to($text, $page->board, '', array('page' => $page->page));
}
function print_pages($page) {
	echo '<ul id="pages">';
	if (!$page->is_first()) {
		echo block_tag('li', link_to_page($page->first(), '&laquo;'), array('class' => 'first'));
	}
	if ($page->has_prev()) {
		echo block_tag('li', link_to_page($page->prev(), '&lsaquo;'), array('class' => 'prev'));
	}
	foreach ($page->get_page_group() as $p) {
		echo block_tag('li', link_to_page($p), $p->here() ? array('class' => 'here') : array());
	}
	if ($page->has_next()) {
		echo block_tag('li', link_to_page($page->next(), '&rsaquo;'), array('class' => 'next'));
	}
	if (!$page->is_last()) {
		echo block_tag('li', link_to_page($page->last(), '&raquo;'), array('class' => 'last'));
	}
	echo "</ul>";
}
?>
