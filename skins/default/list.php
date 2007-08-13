<h1><?=$title?></h1>
<? if ($board->use_category) { ?>
<? if (isset($category)) { ?>
<h2><?=i('Category')?> '<?=$category->name?>'</h2>
<? } ?>
<form method="get" action="<?=url_for($board)?>">
<select name="category" onchange="this.form.submit()">
<option value=""><?=i('Select category')?></option>
<? foreach ($categories as $_category) { ?>
<?=option_tag($_category->id, $_category->name, isset($category) && $category->id == $_category->id)?>
<? } ?>
</select>
<input type="submit" value="Go" />
</form>
<? } ?>
<form method="post" action="<?=url_for($board, 'massdelete')?>" onsubmit="return confirm('<?=i('Are you sure?')?>')">
<table id="posts">
	<caption>
        <?=i('Total %d posts', $board->get_post_count())?>
        <?=link_with_id_to("rss-feed", image_tag("$skin_dir/feed.png", "RSS Feed"), $board, 'rss')?>
    </caption>
	<thead>
	<tr>
	<? if ($massdelete) { ?>
		<th class="massdelete"><input type="checkbox" onclick="toggleAll(this.form, this.checked)" /></th>
	<? } ?>
		<th class="name"><?=i('Writer')?></th>
		<th class="title"><?=i('Title')?></th>
		<th class="date"><?=i('Date')?></th>
	</tr>
	</thead>
	<tbody>
<? foreach ($posts as $post) { ?>
<? if ($post->notice) { ?>
	<tr class="notice">
<? } else { ?>
	<tr>
<? } ?>
	<? if ($massdelete) { ?>
		<td class="massdelete"><input type="checkbox" name="delete[]" value="<?=$post->id?>" /></td>
	<? } ?>
		<td class="name"><?=$post->name?></td>
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
			<span class="comment-count"><?=link_to_comments($post)?></span>
			<span class="views"><?=i('%d views', $post->views)?></span>
		</td>
		<td class="date"><?=strftime("%Y-%m-%d", $post->created_at)?></td>
	</tr>
<? } ?>
	</tbody>
</table>
<? if ($massdelete) { ?>
<p><input type="submit" value="<?=i('Delete selected posts')?>" /></p>
<? } ?>
</form>

<? print_pages($board); ?>

<form method="get" action="">
<p>
<input type="checkbox" name="title" value="1" <?=$title_checked?> /> <?=i('Title')?> 
<input type="checkbox" name="body" value="1" <?=$body_checked?> /> <?=i('Body')?> 
<input type="checkbox" name="comment" value="1" <?=$comment_checked?> /> <?=i('Comments')?> 
<input type="text" name="keyword" value="<?=$keyword?>" />
<input type="submit" value="<?=i('Search')?>" />
</p>
</form>

<div id="nav">
<? if ($link_new_post) { ?><a href="<?=$link_new_post?>"><?=i('New Post')?></a><? } ?>
</div>
