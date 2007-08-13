<div id="board-info">
	<?=i('Total %d posts', $board->get_post_count())?>
	<?=link_with_id_to("rss-feed", image_tag("$skin_dir/feed.png", "RSS Feed"), $board, 'rss')?>
</div>
<div id="meta-account">
<? print_nav(get_account_control($account)); ?>
</div>
<? if ($board->use_category) { ?>
<div id="categories">
<strong><?=i('Category')?>:</strong>
<a href="?" class="category"><?=i('All')?></a>
<? foreach ($categories as $_category) { ?>
<span class="category"><?=link_to_category($_category)?> <span class="posts-count">(<?=$_category->get_post_count()?>)</span></a>
<? } ?>
</div>
<? } ?>
<table id="posts">
<? foreach ($posts as $post) { ?>
<? if ($post->notice) { ?>
	<tr class="notice">
<? } else { ?>
	<tr>
<? } ?>
		<td class="meta">
			<div class="writer"><?=$post->name?></div>
			<div class="date"><?=strftime("%Y-%m-%d %H:%M", $post->created_at)?></div>
		</td>
		<td class="title">
			<? if ($board->use_category && $post->category_id) { ?>
			[<?=link_to_category($post->get_category())?>]
			<? } ?>
			<? if ($post->secret) { ?>
			<span class="secret">[<?=i('Secret Post')?>]</span>
			<? } ?>
			<? if ($post->moved_to) { ?>
			<?=i('Moved')?>:
			<? } ?>
			<?=link_to_post($post)?>
			<span class="comments-count"><?=link_to_comments($post)?></span>
			<div class="meta">
			<?=i('%d trackbacks', $post->get_trackback_count())?>,
			<?=i('%d views', $post->views)?>
			</div>
		</td>
	</tr>
<? } ?>
</table>

<div id="meta-actions">
<? if ($link_new_post) { ?><a href="<?=$link_new_post?>"><?=i('New Post')?></a><? } ?>
</div>

<div id="meta-nav">
<? print_pages($board); ?>

<form method="get" action="">
<input type="checkbox" name="title" id="search_title" value="1" <?=$title_checked?> /> <label for="search_title"><?=i('Title')?></label> 
<input type="checkbox" name="body" id="search_body" value="1" <?=$body_checked?> /> <label for="search_body"><?=i('Body')?></label> 
<input type="checkbox" name="comment" id="search_comment" value="1" <?=$comment_checked?> /> <label for="search_comment"><?=i('Comments')?></label> 
<input type="text" name="keyword" value="<?=$keyword?>" />
<input type="submit" value="<?=i('Search')?>" />
</form>
</div>
