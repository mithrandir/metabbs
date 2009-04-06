<feed xmlns="http://www.w3.org/2005/Atom">
	<title><?=htmlspecialchars($title)?></title>
	<id><?=$url?></id>
<? if (!empty($posts)) { ?>
	<updated><?=meta_format_date_RFC822($posts[0]->created_at)?></updated>
<? } ?>
	<subtitle><?=htmlspecialchars($description)?></subtitle>
<? foreach ($posts as $post) { ?>
	<entry>
		<title><![CDATA[<?=$post->title?>]]></title>
		<link href="<?=full_url_for($post)?>" />
		<id><?=$post->permalink?></id>
<? if (!$post->secret) { ?>
		<content type="html"><? if (!$post->secret) { ?><![CDATA[
	<? foreach ($post->get_attachments() as $attachment) { ?>
	<? if ($attachment->is_image()) { ?><img src="<?=full_url_for($attachment)?>" alt="<?=$attachment->filename?>" /><? } } ?>
<?=$post->body?>]]><? } ?></content>
<? } ?>
		<author><name><![CDATA[<?=$post->name?>]]></name></author>
		<updated><?=meta_format_date_RFC822($post->created_at)?></updated>
<? if ($board->use_category && $category = $post->get_category()) { ?>
		<category term="<?=htmlspecialchars($category->name)?>" />
<? } ?>
	</entry>
<? } ?>
</feed>
