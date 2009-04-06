<feed xmlns="http://www.w3.org/2005/Atom">
	<title><?=htmlspecialchars($title)?></title>
	<id><?=$url?></id>
<? if (!empty($comments)) { ?>
	<updated><?=meta_format_date_RFC822($comments[0]->created_at)?></updated>
<? } ?>
<? foreach ($comments as $comment) { ?>
	<entry>
		<title>Commented by <?=$comment->name?> at <?=date('Y-m-d H:i:s', $comment->created_at)?></title>
		<link href="<?=full_url_for($comment)?>" />
		<content type="html"><![CDATA[<?=$comment->body?>]]></content>
		<author><name><![CDATA[<?=$comment->name?>]]></name></author>
		<updated><?=meta_format_date_RFC822($comment->created_at)?></updated>
	</entry>
<? } ?>
</feed>
