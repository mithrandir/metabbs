<h1>User Information</h1>
<div id="profile">
<p><big><?=$user_->name?></big> (<?=$user_->user?>)</p>
<p>
<? if ($user_->email) { ?>
E-mail: <a href="mailto:<?=$user_->email?>"><?=str_replace("@", " at ", $user_->email)?></a><br />
<? } ?>
<? if ($user_->url) { ?>
Homepage: <?=link_text($user_->get_url())?><br />
<? } ?>
</p>
<p><?=$board->get_post_count()?> posts, <?=$board->get_comment_count()?> comments</p>
</div>
<table id="posts">
	<tr>
		<th class="name">Board</th>
		<th class="title">Title</th>
		<th class="date">Date</th>
	</tr>
<? foreach ($posts as $post) { ?>
	<tr>
		<td class="name"><a href="<?=url_for($post->get_board())?>"><?=$post->get_board_name()?></a></td>
		<td class="title"><?=link_to_post($post)?> <span class="comment-count"><?=link_to_comments($post)?></span></td>
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
</div>
