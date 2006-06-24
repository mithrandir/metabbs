<table id="meta-list">
	<caption>
		Total <?=$board->get_post_count()?> posts</caption>
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
			<td class="name"><?=link_to_user($post->get_user())?></td>
			<td class="title">
				<?=link_to_post($post)?>
				<small><?=link_to_comments($post)?></small>
			</td>
			<td class="date"><?=date_format("%Y-%m-%d", $post->created_at)?></td>
		</tr>
<? } ?>
	</tbody>
</table>

<div id="meta-nav">
	<? print_pages($page); ?>
	<form method="get" action="">
		<p>
		<select name="searchtype" id="searchtype">
			<option value="tb">제목과 내용</option>
			<option value="t">제목</option>
			<option value="b">내용</option>
		</select>
		<?=input_tag("search", $board->search)?> <?=submit_tag("Search")?> <?=link_text("?", "Return")?>
		</p>
	</form>
<? if ($user->level >= $board->perm_write) { ?>
    <?=link_to("New Post", $board, 'post')?>
<? } ?>
</div>
