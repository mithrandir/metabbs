<rss version="2.0">
	<channel>
		<title><?=htmlspecialchars($title)?></title>
		<link><?=$url?></link>
		<description><?=htmlspecialchars($description)?></description>
<? if (!empty($posts)) { ?>
		<pubDate><?=meta_format_date_RFC822($posts[0]->created_at)?></pubDate>
<? } ?>
<? foreach ($posts as $post) { ?>
		<item>
			<title><![CDATA[<?=$post->title?>]]></title>
			<link><?=$post->permalink?></link>
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
