<?php
class Page extends Model {
	var $model = 'page';

	var $body;
	
	function _init() {
		$this->table = get_table_name('page');
		$this->user_table = get_table_name('user');
	}
	function get_id() {
		return $this->title;
	}
	function find_by_title($id) {
		$db = get_conn();
		$table = get_table_name('page');
		return $db->fetchrow("SELECT * FROM $table WHERE title=?", 'Page', array($id));
	}
	function get_user() {
		return $this->db->fetchrow("SELECT * FROM $this->user_table WHERE id=$this->user_id", 'User');
	}
}

function wiki_index() {
	redirect_to(url_for(new Page(array('title' => 'index'))));
}
function get_page() {
	global $id;
	$page = Page::find_by_title($id);
	if (!$page->title) $page->title = $id;
	return $page;
}
function wiki_link($matches) {
	$page = Page::find_by_title($matches[1]);
	if (!$page->title) $page->title = $matches[1];
	return link_text(url_for($page), $page->title, $page->exists() ? array() : array('style' => 'color: red'));
}
function format_wiki($body) {
	$body = format($body);
	$body = preg_replace_callback('/\[\[(.+?)\]\]/', 'wiki_link', $body);
	return $body;
}
function print_wiki_title($page) {
	echo '<h1><small>'.link_to('Wiki', 'wiki').' &raquo; </small>'.$page->title.'</h1>';
}
function page_index() {
	$page = get_page();
	if (!$page->exists()) {
		redirect_to(url_for($page, 'edit'));
	}
	print_wiki_title($page);
?>
<hr />
<p><?=format_wiki($page->body)?></p>
<hr />
<p>
<?=link_to(i('Edit'), $page, 'edit')?> |
Last edited <?=$page->created_at?> by <?=link_to_user($page->get_user())?>
</p>
<?php
}
function page_edit() {
	global $account;
	$page = get_page();
	if (is_post()) {
		$page->body = $_POST['body'];
		$page->user_id = $account->id;
		if ($page->exists())
			$page->update();
		else
			$page->create();
		redirect_to(url_for($page));
	}
	print_wiki_title($page);
?>
<form method="post" action="?">
<p><em>(editing)</em></p>
<textarea name="body" rows="12" cols="60"><?=$page->body?></textarea>
<p><?=submit_tag('Edit')?> <? if ($page->exists()) { ?><?=link_to(i('Cancel'), $page)?><? } ?></p>
</form>
<?php
}

class Wiki extends Plugin {
	var $description = 'Simple wiki engine for MetaBBS.';

	function on_init() {
		add_handler('wiki', 'index', 'wiki_index');
		add_handler('page', 'index', 'page_index');
		add_handler('page', 'edit', 'page_edit');
	}
	function on_install() {
		$t = new Table('page');
		$t->column('title', 'string', 45);
		$t->column('body', 'text');
		$t->column('user_id', 'integer');
		$t->column('created_at', 'timestamp');
		$t->add_index('title');
		$t->add_index('user_id');
		$this->db->add_table($t);
	}
	function on_uninstall() {
		$this->db->drop_table('page');
	}
}

register_plugin('Wiki');
?>
