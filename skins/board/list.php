<? if ($board->use_category) { ?>
<? foreach ($categories as $_category) { ?>
<?=option_tag($_category->id, $_category->name, isset($category) && $category->id == $_category->id)?>
<? } ?>
<? } ?>
<div id="board-info">
	<?=i('Total %d posts', $board->get_post_count())?>
	<?=link_with_id_to("rss-feed", image_tag("$skin_dir/feed.png", "RSS Feed"), $board, 'rss')?>
</div>
<div id="meta-account">
<? print_nav(get_account_control($account)); ?>
</div>
<form method="post" action="<?=url_for($board, 'massdelete')?>" onsubmit="return confirm('<?=i('Are you sure?')?>')">
<table id="posts">
<? foreach ($posts as $post) { ?>
<? if ($post->is_notice()) { ?>
	<tr class="notice">
<? } else { ?>
	<tr>
<? } ?>
	<? if ($massdelete) { ?>
		<td class="massdelete"><input type="checkbox" name="delete[]" value="<?=$post->id?>" /></td>
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
			<div class="meta">
			<?=i('%d comments', $post->get_comment_count())?>,
			<?=i('%d views', $post->views)?>
			</div>
		</td>
	</tr>
<? } ?>
</table>

<div id="meta-actions">
<? if ($link_new_post) { ?><a href="<?=$link_new_post?>"><?=i('New Post')?></a><? } ?>
<? if ($massdelete) { ?>
<input type="submit" value="<?=i('Delete selected posts')?>" />
<? } ?>
</div>
</form>

<div id="meta-nav">
<? print_pages($board); ?>

<form method="get" action="?search[title]=1&amp;search[body]=1" id="searchform">
<?=text_field("search", "text", $board->search['text'])?> <?=submit_tag("Search")?> <? if ($board->search['text']) { ?><a href="?"><?=i('Cancel')?></a><? } ?>
</form>
</div>
