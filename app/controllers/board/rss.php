<?php
require_once 'lib/feed.php';
$posts = feed_render_header($board, 'rss');
?>
<rss version="2.0">
	<channel>
		<title><![CDATA[<?=$board->get_title()?>]]></title>
		<link><?=full_url_for($board)?></link>
		<description>The latest posts from <?=$board->get_title()?></description>
<? if (!empty($posts)) { ?>
		<pubDate><?=meta_format_date_RFC822($posts[0]->created_at)?></pubDate>
<? } ?>
<? foreach ($posts as $post) { ?>
		<item>
			<title><![CDATA[<?=$post->title?>]]></title>
			<link><?=full_url_for($post)?></link>
			<description><? if (!$post->secret) { ?><![CDATA[
	<? foreach ($post->get_attachments() as $attachment) { ?>
	<? if ($attachment->is_image()) { ?><img src="<?=full_url_for($attachment)?>" alt="<?=$attachment->filename?>" /><? } } ?>
<?=format($post->body)?>]]><? } ?></description>
			<author><![CDATA[<?=$post->name?>]]></author>
			<pubDate><?=meta_format_date_RFC822($post->created_at)?></pubDate>
<? if ($board->use_category && $category = $post->get_category()) { ?>
			<category><?=htmlspecialchars($category->name)?></category>
<? } ?>
		</item>
<? } ?>
	</channel>
</rss>
<? exit; ?>
