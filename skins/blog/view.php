<div class="post">
	<h2><?php echo $post->title; ?></h2>
	<div class="date"><?php echo $post->created_at; ?></div>
	
	<p><?php echo format($post->body); ?></p>
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
<ul>
<?php foreach ($comments as $comment) { ?>
	<li class="comment">
		<div class="comment-info"><strong><?=$comment->name?></strong> <small><?=$comment->created_at?></small></div>
		<div class="comment-body"><p><?=format($comment->body)?></p></div>
	</li>
<?php } ?>
</ul>

<form method="post" action="<?=url_for($post, 'comment')?>">
<? if ($account->is_guest()) { ?>
<p><?=label_tag("Name", "comment", "name")?> <?=text_field("comment", "name", $name)?></p>
<p><?=label_tag("Password", "comment", "password")?> <?=password_field("comment", "password")?></p>
<? } ?>
<p><?=text_area("comment", "body", 5, 50, "", array("id" => "comment_body"))?></p>
<p><?=submit_tag("Save")?></p>
</form>
</div>

<? print_nav(); ?>
