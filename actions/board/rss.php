<?php
setlocale(LC_TIME, "en_US");
if ($board->perm_read > $account->level) {
	exit;
}
$posts = $board->get_feed_posts($board->posts_per_page);
header("Content-Type: text/xml; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
if (file_exists("skins/$board->skin/board/rss.xsl")) {
	$path = get_base_path();
	echo "<?xml-stylesheet type=\"text/xsl\" href=\"$path/skins/$board->skin/board/rss.xsl\"?>\n";
}
?>
<rss version="2.0">
	<channel>
		<title><![CDATA[<?=$board->title?>]]></title>
		<link><?=full_url_for($board)?></link>
		<description>The latest posts from <?=$board->title?></description>
<? foreach ($posts as $post) { ?>
		<item>
			<title><![CDATA[<?=$post->title?>]]></title>
			<link><?=full_url_for($post)?></link>
			<description><![CDATA[<?=format($post->body)?>]]></description>
			<author><![CDATA[<?=$post->name?>]]></author>
			<pubDate><?=date_format("%d %b %Y %H:%M:%S", $post->created_at)?></pubDate>
		</item>
<? } ?>
	</channel>
</rss>
