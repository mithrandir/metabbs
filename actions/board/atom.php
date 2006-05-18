<?php
setlocale(LC_TIME, "en_US");
if ($board->perm_read > $user->level) {
	exit;
}
$page = new Page($board, 1);
$posts = $page->get_posts();
header("Content-Type: text/xml; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<?xml-stylesheet type=\"text/xsl\" href=\"$skin_dir/board/atom.xsl\"?>\n";
?>
<feed xmlns="http://www.w3.org/2005/Atom">
	<title><![CDATA[<?=$board->title?>]]></title>
	<id><?=full_url_for($board)?></id>
	<updated><?=date_format("%Y-%m-%d"."T%H:%M:%SZ", $posts[0]->created_at)?></updated>
	<subtitle>The latest posts from <?=$board->title?></subtitle>
<? foreach ($posts as $post) { ?>
	<entry>
		<title><![CDATA[<?=$post->title?>]]></title>
		<id><?=full_url_for($post)?></id>
		<content><?=htmlspecialchars($post->get_body())?></content>
		<author><name><![CDATA[<?=$post->name?>]]></name></author>
		<updated><?=date_format("%Y-%m-%d"."T%H:%M:%SZ", $post->created_at)?></updated>
	</entry>
<? } ?>
</feed>
