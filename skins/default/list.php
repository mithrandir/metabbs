<h1>Board: <?=$title?></h1>
<? if ($board->use_category) { ?>
<? if (isset($category)) { ?>
<h2><?=i('Category')?> '<?=$category->name?>'</h2>
<? } ?>
<form method="get" action="<?=url_for($board)?>">
<select name="category" onchange="this.form.submit()">
<option value="0">Select category</option>
<? foreach ($board->get_categories() as $_category) { ?>
<option value="<?=$_category->id?>"<? if (isset($category)&&$category->id==$_category->id) { ?> selected="selected"<? } ?>><?=$_category->name?></option>
<? } ?>
</select>
<input type="submit" value="Go" />
</form>
<? } ?>
<table id="posts">
	<caption>
        Total <?=$board->get_post_count()?> posts
        <?=link_with_id_to("rss-feed", image_tag("$skin_dir/feed.png", "RSS Feed"), $board, 'rss')?>
    </caption>
	<tr>
		<th class="name">Name</th>
		<th class="title">Title</th>
		<th class="date">Date</th>
	</tr>
<? foreach ($posts as $post) { ?>
<? if ($post->is_notice()) { ?>
	<tr class="notice">
<? } else { ?>
	<tr>
<? } ?>
		<td class="name"><?=link_to_user($post->get_user())?></td>
		<td class="title">
			<? if ($board->use_category && $post->category_id) { ?>
			[<?=link_to_category($post->get_category())?>]
			<? } ?>
			<?=link_to_post($post)?>
			<span class="comment-count"><?=link_to_comments($post)?></span>
		</td>
		<td class="date"><?=date_format("%Y-%m-%d", $post->created_at)?></td>
	</tr>
<? } ?>
</table>

<? print_pages($board); ?>

<form method="get">
<p>
<select name="searchtype" id="searchtype">
<? $types = array('tb' => 'Title+Body', 't' => 'Title', 'b' => 'Body'); foreach ($types as $type => $text) { ?>
<option value="<?=$type?>"<? if (isset($_GET['searchtype']) && $_GET['searchtype'] == $type) { ?> selected="selected"<? } ?>><?=$text?></option>
<? } ?>
</select>
<?=input_tag("search", $board->search)?> <?=submit_tag("Search")?> <?=link_text("?", "Return")?>
</p>
</form>
