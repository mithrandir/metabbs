<? if ($board->use_category) { ?>
<? if (isset($category)) { ?>
<h2><?=i('Category')?> '<?=$category->name?>'</h2>
<? } ?>
<form method="get" action="<?=url_for($board)?>">
<select name="search[category]" onchange="this.form.submit()">
<option value="0"><?=i('Select category')?></option>
<? foreach ($board->get_categories() as $_category) { ?>
<option value="<?=$_category->id?>"<? if (isset($category)&&$category->id==$_category->id) { ?> selected="selected"<? } ?>><?=$_category->name?></option>
<? } ?>
</select>
<input type="submit" value="Go" />
</form>
<? } ?>

<table id="meta-list">
	<caption>
		Total <?=$board->get_post_count()?> posts
        <?=link_with_id_to("rss-feed", image_tag("$skin_dir/feed.png", "RSS Feed"), $board, 'rss')?>
    </caption>
	<thead>
		<tr>
			<th class="name">Name</th>
			<th class="title">Title</th>
			<th class="date">Date</th>
		</tr>
	</thead>
	<tbody>
<? foreach ($posts as $post) { ?>
		<tr>
			<td class="name">
			<? if ($post->user_id) { ?>
				<?=link_to_user($post->get_user())?>
			<? } else { ?>
				<?=htmlspecialchars($post->name)?>
			<? } ?>
			</td>
			<td class="title">
				<? if ($board->use_category && $post->category_id) { ?>
				[<?=link_to_category($post->get_category())?>]
				<? } ?>
				<?=link_to_post($post)?>
				<span class="comment-count"><?=link_to_comments($post)?></span>
			</td>
			<td class="date"><?=meta_format_date("%Y-%m-%d", $post->created_at)?></td>
		</tr>
<? } ?>
	</tbody>
</table>
<? print_pages($board); ?>

<form method="get">
<p>
<?=check_box("search", "title", $board->search['title'])?> <?=i('Title')?>
 <?=check_box("search", "body", $board->search['body'])?> <?=i('Body')?>
 <?=text_field("search", "text", $board->search['text'])?> <?=submit_tag("Search")?> <?=link_text("?", i("Return"))?>
</p>
</form>
