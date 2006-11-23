<h1>Board: <?=$title?></h1>
<? if ($board->use_category) { ?>
<? if (isset($category)) { ?>
<h2><?=i('Category')?> '<?=$category->name?>'</h2>
<? } ?>
<form method="get" action="<?=url_for($board)?>">
<select name="search[category]" onchange="this.form.submit()">
<option value="0"><?=i('Select category')?></option>
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
	<tr>
	<? if ($massdelete) { ?>
		<th class="massdelete"><input type="checkbox" onclick="toggleAll(this.form, this.checked)" /></th>
	<? } ?>
		<th class="name"><?=i('Writer')?></th>
		<th class="title"><?=i('Title')?></th>
		<th class="date"><?=i('Date')?></th>
	</tr>
<? foreach ($posts as $post) { ?>
<? if ($post->is_notice()) { ?>
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
			<?=link_to_post($post)?>
			<span class="comment-count"><?=link_to_comments($post)?></span>
			<span class="views"><?=$post->views?> views</span>
		</td>
		<td class="date"><?=meta_format_date("%Y-%m-%d", $post->created_at)?></td>
	</tr>
<? } ?>
</table>
<? if ($massdelete) { ?>
<p><input type="submit" value="<?=i('Delete selected posts')?>" /></p>
<? } ?>
</form>

<? print_pages($board); ?>

<form method="get">
<p>
<?=check_box("search", "title", $board->search['title'])?> <?=i('Title')?>
 <?=check_box("search", "body", $board->search['body'])?> <?=i('Body')?>
 <?=check_box("search", "comment", $board->search['comment'])?> <?=i('Comments')?>
 <?=text_field("search", "text", $board->search['text'])?> <?=submit_tag("Search")?> <?=link_text("?", i("Return"))?>
</p>
</form>

<div id="nav">
<? if ($link_new_post) { ?><a href="<?=$link_new_post?>"><?=i('New Post')?></a><? } ?>
</div>
