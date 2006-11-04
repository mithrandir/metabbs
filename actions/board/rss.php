<?php
require_once 'lib/feed.php';
$posts = feed_render_header($board, 'rss');
?>
<rss version="2.0">
	<channel>
		<title><![CDATA[<?=$board->get_title()?>]]></title>
		<link><?=full_url_for($board)?></link>
		<description>The latest posts from <?=$board->get_title()?></description>
<? foreach ($posts as $post) { ?>
		<item>
			<title><![CDATA[<?=$post->title?>]]></title>
			<link><?=full_url_for($post)?></link>
			<description><![CDATA[<?=format($post->body)?>]]></description>
			<author><![CDATA[<?=$post->name?>]]></author>
			<pubDate><?=meta_format_date_RFC822($post->created_at)?></pubDate>
<? if ($board->use_category && $category = $post->get_category()) { ?>
			<category><?=htmlspecialchars($category->name)?></category>
<? } ?>
		</item>
<? } ?>
	</channel>
</rss>
<?
// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>