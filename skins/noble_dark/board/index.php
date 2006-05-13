<table id="meta-list">
	<caption>Total <?=$board->get_post_count()?> posts <a href="<?=url_for($board, 'rss')?>" class="feed" title="RSS Feed"><img src="<?=$skin_dir?>/feed.png" alt="Syndication" /></a></caption>
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
			<td class="name"><a href="<?=url_for($post->get_user())?>"><?=$post->name?></a></td>
			<td class="title"><a href="<?=url_for($post, '', array('page' => Page::get_requested_page()))?>"><?=$post->title?></a> <? if ($post->get_comment_count()>0) { ?><a href="<?=url_for($post)?>#comments"><small>[<?=$post->get_comment_count()?>]</small></a><? } ?></td>
			<td class="date"><?=date_format("%Y-%m-%d", $post->created_at)?></td>
		</tr>
<? } ?>
	</tbody>
</table>

<div id="meta-nav">
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
	<form method="get" action="<?=$PHP_SELF?>">
		<p>
		<select name="searchtype" id="searchtype">
			<option value="tb">제목과 내용</option>
			<option value="t">제목</option>
			<option value="b">내용</option>
		</select>
		&nbsp;<input type="text" name="search" value="<?=$board->search?>" /> <input type="submit" value="Search" /> <a href="?">return</a>
		</p>
	</form>
<? if ($user->level >= $board->perm_write) { ?>
	<p><a href="<?=url_for($board, 'post')?>">New Post</a></p>
<? } ?>
</div>
