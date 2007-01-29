<script type="text/javascript">
function openPlayer(id, url) {
	$(id).innerHTML = '<object type="application/x-shockwave-flash" data="<?=$skin_dir?>/player.swf" width="290" height="24"><param name="movie" value="<?=$skin_dir?>/player.swf" /><param name="FlashVars" value="autostart=yes&amp;soundFile='+url+'" /></object>';
}
</script>
<div id="post">

<div class="post-title">
    <div class="info">
		<?=i('Posted by %s at %s', $post->name, meta_format_date("%Y-%m-%d %H:%M:%S", $post->created_at))?>
		| <?=i('%d views', $post->views)?>
<? if ($board->use_category && $post->category_id) { ?>
		| <?=i('Category')?>: <?=link_to_category($post->get_category())?>
<? } ?></div>
    <h2><?=htmlspecialchars($post->title)?></h2>
</div>

<div id="attachments">
<ul>
<? foreach ($attachments as $attachment): ?>
<? if (!$attachment->file_exists()) { ?>
	<li>Attachment: <del><?=$attachment->filename?></del></li>
<? } else { ?>
	<li>Attachment: <?=link_to($attachment->filename, $attachment)?> (<?=human_readable_size($attachment->get_size())?>)
<? if ($attachment->is_image()) { ?>
	<br /><img src="<?=url_for($attachment)?>" alt="<?=$attachment->filename?>" />
<? } else if ($attachment->is_music()) { ?>
	<a href="<?=url_for($attachment)?>" onclick="openPlayer('player-<?=$attachment->id?>', this.href); return false">Listen</a><div id="player-<?=$attachment->id?>"></div>
<? } ?>
	</li>
<? } endforeach; ?>
</ul>
</div>

<div id="body"><?=$post->body?></div>
<? if ($post->is_edited()) { ?>
<div id="editinfo"><?=i('Edited by %s at %s', link_to_user(User::find($post->edited_by)), meta_format_date("%Y-%m-%d %H:%M:%S", $post->edited_at))?></div>
<? } ?>
<? if (isset($signature)) { ?>
<div id="signature"><?=$signature?></div>
<? } ?>
</div>

<? if ($board->use_trackback) { ?>
<div id="trackbacks">
<h3><?=i('Trackbacks')?></h3>
<p><?=i('Trackback URL')?>: <?=link_text(full_url_for($post, 'trackback'), '', array('onclick' => 'return false'))?></p>
<!--
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	 xmlns:dc="http://purl.org/dc/elements/1.1/"
	 xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/">
<rdf:Description
	 rdf:about="<?=full_url_for($post)?>"
	 dc:title="<?=$post->title?>"
	 dc:identifier="<?=full_url_for($post)?>"
	 trackback:ping="<?=full_url_for($post, 'trackback')?>" />
</rdf:RDF>
-->
<ul>
<? foreach ($trackbacks as $trackback) { ?>
	<li><?=link_text($trackback->url, $trackback->title)?> from <?=$trackback->blog_name?> <? if ($account->level >= $board->perm_delete) { echo link_with_dialog_to('<strong>X</strong>', $trackback, 'delete'); } ?></li>
<? } ?>
</ul>
</div>
<? } ?>

<div id="comments">
<h3><?=i('Comments')?></h3>
<ul>
<?
$comment_stack = array();
foreach ($comments as $comment) {
	include($_skin_dir . '/_comment.php');
}
?>
</ul>
</div>

<? if ($commentable) { ?>
<form method="post" action="<?=url_for($post, 'comment')?>" onsubmit="return sendForm(this, 'comments', function () { $('comment_body').value='' })">
<input type="hidden" name="ajax" value="0" />
<? if ($account->is_guest()) { ?>
<p><?=label_tag("Name", "comment", "name")?> <?=text_field("comment", "name", $name)?></p>
<p><?=label_tag("Password", "comment", "password")?> <?=password_field("comment", "password")?></p>
<? } ?>
<p><?=text_area("comment", "body", 5, 50, "", array("id" => "comment_body"))?></p>
<p><?=submit_tag("Comment")?> <span id="sending"><?=image_tag("$skin_dir/spin.gif", "Sending...")?></span></p>
</form>
<? } ?>

<div id="neighbor-posts">
<p>
<? if ($newer_post->exists()) { ?>&laquo; <?=link_to_post($newer_post)?><? } ?>
<? if ($newer_post->exists() && $older_post->exists()) { ?> | <? } ?>
<? if ($older_post->exists()) { ?><?=link_to_post($older_post)?> &raquo;<? } ?>
</p>
</div>

<div id="nav">
<a href="<?=$link_list?>"><?=i('List')?></a> |
<? if ($link_new_post) { ?><a href="<?=$link_new_post?>"><?=i('New Post')?></a> <? } ?>
<? if ($owner) { ?>
| <a href="<?=$link_edit?>"><?=i('Edit')?></a>
| <a href="<?=$link_delete?>"><?=i('Delete')?></a>
<? } ?>
</div>
