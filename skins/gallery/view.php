<div class="post-title">
    <h2>
	<? if ($board->use_category && $post->category_id) { ?>[<?=link_to_category($post->get_category())?>]<? } ?>
	<span class="title"><?=htmlspecialchars($post->title)?></span>
	</h2>
    <div class="info"><?=$post->name?>, <?=strftime("%Y-%m-%d %H:%M:%S", $post->created_at)?></div>
</div>

<div id="attachments">
<? foreach ($attachments as $attachment) { ?>
<img src="<?=url_for($attachment)?>" alt="<?=$attachment->filename?>" />
<? } ?>
</div>

<div id="body"><?=$post->body?></div>
<? if (isset($signature)) { ?>
<div id="signature"><?=$signature?></div>
<? } ?>

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
	<li><?=link_text($trackback->url, $trackback->title)?> from <?=$trackback->blog_name?> <? if ($account->has_perm('admin', $board)) { echo link_with_dialog_to('<strong>X</strong>', $trackback, 'delete'); } ?></li>
<? } ?>
</ul>
</div>
<? } ?>

<div id="comments">
<h3><?=i('Comments')?></h3>
<ul id="comments-list">
<?
$comment_stack = array();
foreach ($comments as $comment) {
	include($_skin_dir . '/_comment.php');
}
?>
</ul>
</div>

<? if ($commentable) { ?>
<form method="post" action="<?=url_for($post, 'comment')?>" onsubmit="return addComment(this)" id="comment-form">
<? if ($account->is_guest()) { ?>
<p><?=label_tag("Name", "comment", "name")?> <?=text_field("comment", "name", $name)?></p>
<p><?=label_tag("Password", "comment", "password")?> <?=password_field("comment", "password")?></p>
<? } ?>
<p><?=text_area("comment", "body", 5, 50, "", array("id" => "comment_body"))?></p>
<p><?=submit_tag("Comment")?></p>
</form>
<? } ?>

<div id="nav">
<a href="<?=$link_list?>"><?=i('List')?></a> |
<? if ($link_new_post) { ?><a href="<?=$link_new_post?>"><?=i('New Post')?></a> <? } ?>
<? if ($owner) { ?>
| <a href="<?=$link_edit?>"><?=i('Edit')?></a>
| <a href="<?=$link_delete?>"><?=i('Delete')?></a>
<? } ?>
<? if ($account->is_admin()) { ?>
| <a href="<?=url_for($post, 'move')?>"><?=i('Move')?></a>
<? } ?>
</div>
