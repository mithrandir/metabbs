<div id="post">
<div class="title">
<h2 id="title"><?=$post->title?></h2>
<div class="info">
<p>Posted by <?=link_to_user($post->get_user())?> at <?=date_format("%Y-%m-%d %H:%M:%S", $post->created_at)?></p>
</div>
</div>
<div id="attachments" style="clear: both">
<ul>
<? foreach ($attachments as $attachment) { ?>
<? if (!$attachment->exist()) { ?>
	<li>Attachment: <del><?=$attachment->filename?></del></li>
<? } else if ($attachment->is_image()) { ?>
	<li><img src="<?=url_for($attachment)?>" alt="<?=$attachment->filename?>" /></li>
<? } else { ?>
	<li>Attachment: <?=link_to($attachment->filename, $attachment)?> (<?=human_readable_size($attachment->get_size())?>)</li>
<? } ?>
<? } ?>
</ul>
</div>
<p id="body"><?=$post->get_body()?></p>
</div>

<div id="trackbacks">
<h3>Trackbacks</h3>
<p>Trackback URL: <?=link_text(full_url_for($post, 'trackback'))?></p>
<? //include($_skin_dir . '/trackback/_rdf.php'); ?>
<ul>
<? foreach ($trackbacks as $trackback) { ?>
	<li><?=link_text($trackback->url, $trackback->title)?> from <?=$trackback->blog_name?></li>
<? } ?>
</ul>
</div>

<div id="comments">
<h3>Comments</h3>
<ul id="comment-list">
<? foreach ($comments as $comment) {
	include($_skin_dir . '/_comment.php');
} ?>
</ul>
</div>

<? if ($board->perm_comment <= $user->level) { ?>
<form method="post" action="<?=url_for($post, 'comment')?>" onsubmit="return sendForm(this, 'comment-list', function (f) { $('comment_body').value='' })">
<? if ($user->is_guest()) { ?>
<p><label>Name:</label> <input type="text" name="comment[name]" value="<?=$name?>" /></p>
<p><label>Password:</label> <input type="password" name="comment[password]" /></p>
<? } ?>
<p><textarea name="comment[body]" cols="50" rows="5" id="comment_body"></textarea></p>
<p><input type="submit" value="Save" /> <span id="sending"><img src="<?=$skin_dir?>/spin.gif" alt="Sending" /> Sending...</span></p>
</form>
<? } ?>

<div id="nav">
<p><a href="<?=url_for($board, '', array('page' => Page::get_requested_page()))?>">List</a>
<? if ($user->level >= $board->perm_write) { ?>
| <a href="<?=url_for($board, 'post')?>">New Post</a>
<? } ?>
<? if ($post->user_id == 0 || $user->id == $post->user_id || $user->level >= $board->perm_delete) { ?>
| <a href="<?=url_for($post, 'edit')?>">Edit</a> or <a href="<?=url_for($post, 'delete')?>">Delete</a>
<? } ?></p>
</div>
