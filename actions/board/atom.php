<?php
require_once 'lib/feed.php';
$posts = feed_render_header($board, 'atom');
?>
<feed xmlns="http://www.w3.org/2005/Atom">
	<title><![CDATA[<?=$board->get_title()?>]]></title>
	<id><?=full_url_for($board)?></id>
	<updated><?=meta_format_date_RFC822($posts[0]->created_at)?></updated>
	<subtitle>The latest posts from <?=$board->get_title()?></subtitle>
<? foreach ($posts as $post) { ?>
	<entry>
		<title><![CDATA[<?=$post->title?>]]></title>
		<id><?=full_url_for($post)?></id>
		<content><![CDATA[<?=format($post->body)?>]]></content>
		<author><name><![CDATA[<?=$post->name?>]]></name></author>
		<updated><?=meta_format_date_RFC822($post->created_at)?></updated>
<? if ($board->use_category && $category = $post->get_category()) { ?>
		<category term="<?=htmlspecialchars($category->name)?>" />
<? } ?>
	</entry>
<? } ?>
</feed>
<?
// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>