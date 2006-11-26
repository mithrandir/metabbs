<div id="post">

<div class="title">
    <h2 id="title"><?=$post->title?></h2>
    <div class="info">
    <p>Posted by <?=link_to_user($post->get_user())?> at <?=meta_format_date("%Y-%m-%d %H:%M:%S", $post->created_at)?></p>
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

<div id="body"><?=format($post->body)?></div>
</div>

<div id="trackbacks">
<h3>Trackbacks</h3>
<p>Trackback URL: <?=link_text(full_url_for($post, 'trackback'))?></p>
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
	<li><?=link_text($trackback->url, $trackback->title)?> from <?=$trackback->blog_name?></li>
<? } ?>
</ul>
</div>

<div id="comments">
<h3>Comments</h3>
<ul id="comment-list">
<? foreach ($comments as $comment) { ?>
	<? include($_skin_dir . '/_comment.php'); ?>
<? } ?>
</ul>
</div>

<? if ($board->perm_comment <= $account->level) { ?>
<form method="post" action="<?=url_for($post, 'comment')?>" onsubmit="return sendForm(this, 'comment-list', function (f) { $('comment_body').value='' })">
<? if ($account->is_guest()) { ?>
<p><?=label_tag("Name:", "comment", "name")?> <?=text_field("comment", "name", $name)?></p>
<p><?=label_tag("Password:", "comment", "password")?> <?=password_field("comment", "password")?></p>
<? } ?>
<p><?=text_area("comment", "body", 5, 50, "", array("id" => "comment_body"))?></p>
<p><?=submit_tag("Save")?> <span id="sending"><?=image_tag("$skin_dir/spin.gif", "Sending")?> Sending...</span></p>
</form>
<? } ?>
