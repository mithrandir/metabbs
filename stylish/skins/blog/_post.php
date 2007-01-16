<div class="atomentry" id="article-<?=$post->id?>">
	<h2 class="title">
		<?=link_to($post->title, $post)?>
		<? if ($count = $post->get_comment_count()) { ?>
		<span class="comment_count"><?=$count?></span>
		<? } ?>
	</h2>
	<p class="author">
		Posted by <cite><?=$post->name?></cite>
		<abbr class="published" title="<?=meta_format_date_RFC822($post->created_at)?>"><?=meta_format_date("%Y-%m-%d %H:%M:%S", $post->created_at)?></abbr>
	</p>
	<div class="content">
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

	<?=format($post->body)?>
	</div>
	<ul class="meta">
	<? if ($board->use_category && $post->category_id) { ?>
	<li>Posted in <?=link_to_category($post->get_category())?></li>
	<? } ?>
	<li>Meta 
	<?=plural_link($post, 'comment', $post->get_comment_count())?>
	<? if ($board->use_trackback) { ?>
	<?=plural_link($post, 'trackback', $post->get_trackback_count())?>
	<? } ?>
	<a href="<?=url_for($post)?>" rel="bookmark">permalink</a>
	</li>
	</ul>
</div>
