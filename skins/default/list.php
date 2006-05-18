<h1>Board: <?=$title?></h1>
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
	<tr>
		<td class="name"><?=link_to_user($post->get_user())?></td>
		<td class="title">
			<?=link_to_post($post)?>
			<span class="comment-count"><?=link_to_comments($post)?></span>
		</td>
		<td class="date"><?=date_format("%Y-%m-%d", $post->created_at)?></td>
	</tr>
<? } ?>
</table>

<div id="nav">
<ul id="pages">
<? if (!$page->is_first()) { ?>
	<li class="first"><a href="<?=get_href($page->first())?>">&laquo;</a></li>
<? } ?>
<? if ($page->has_prev()) { ?>
	<li class="next"><a href="<?=get_href($page->prev())?>">&lsaquo;</a></li>
<? } ?>
<? foreach ($pages as $p) { ?>
<? if (!$p->here()) { ?>
	<li><a href="<?=get_href($p)?>"><?=$p->page?></a></li>
<? } else { ?>	
	<li class="here"><a href="<?=get_href($p)?>"><?=$p->page?></a></li>
<? } ?>
<? } ?>
<? if ($page->has_next()) { ?>
	<li class="next"><a href="<?=get_href($page->next())?>">&rsaquo;</a></li>
<? } ?>
<? if (!$page->is_last()) { ?>
	<li class="last"><a href="<?=get_href($page->last())?>">&raquo;</a></li>
<? } ?>
</ul>

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

<p>
<? if ($user->level >= $board->perm_write) { ?>
    <?=link_to("New Post", $board, 'post')?>
<? } ?>
</p>
</div>
