<div class="post">
<h2><?=link_to($post->title, $post)?></h2>
<div class="date"><?=meta_format_date("%Y-%m-%d %H:%M:%S", $post->created_at)?></div>
<div class="attachments">
<ul>
<? foreach ($post->get_attachments() as $attachment) { ?>
<? if (!$attachment->file_exists()) { ?>
	<li>Attachment: <del><?=$attachment->filename?></del></li>
<? } else if ($attachment->is_image()) { ?>
	<li><img src="<?=url_for($attachment)?>" alt="<?=$attachment->filename?>" /></li>
<? } else { ?>
	<li>Attachment: <?=link_to($attachment->filename, $attachment)?> (<?=human_readable_size($attachment->get_size())?>)</li>
<? } ?>
<? } ?>
</ul>
</div>
<p><?=format($post->body)?></p>
</div>
