<h1>User Information</h1>
<div id="profile">
<p><span class="name"><?=$user->name?></span> (<?=$user->user?>)</p>
<p>
<? if ($user->email) { ?>
E-mail: <a href="mailto:<?=$user->email?>"><?=str_replace("@", " at ", $user->email)?></a><br />
<? } ?>
<? if ($user->url) { ?>
Homepage: <?=link_text($user->get_url())?><br />
<? } ?>
</p>
<p><?=$user->get_post_count()?> posts, <?=$user->get_comment_count()?> comments</p>
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
		<td class="date"><?=meta_format_date("%Y-%m-%d", $post->created_at)?></td>
	</tr>
<? } ?>
</table>

<? print_pages($user); ?>
