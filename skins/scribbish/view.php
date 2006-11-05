<? include($_skin_dir . '/_post.php'); ?>

<h5><a name="trackbacks"><?=i('Trackbacks')?></a></h5>
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
<ol id="trackbacks">
<? foreach ($trackbacks as $trackback) { ?>
	<li><?=link_text($trackback->url, $trackback->title)?> from <?=$trackback->blog_name?></li>
<? } ?>
</ol>

<h5><a name="comments"><?=i('Comments')?></a></h5>
<div id="comments_div">
<ol id="comments" class="comments">
<?
$comment_stack = array();
foreach ($comments as $comment) {
	include($_skin_dir . '/_comment.php');
}
?>
</ol>
</div>

<? if ($commentable) { ?>
<form method="post" action="<?=url_for($post, 'comment')?>" id="commentform" class="comments">
<fieldset>
	<legend>Comments</legend>
<? if ($account->is_guest()) { ?>
	<p><?=label_tag("Name", "comment", "name")?><br /><?=text_field("comment", "name", $name)?></p>
	<p><?=label_tag("Password", "comment", "password")?><br /><?=password_field("comment", "password")?></p>
<? } ?>
	<p>Comments:<br /><?=text_area("comment", "body", 5, 50, "", array("id" => "comment_body"))?></p>
	<p><?=submit_tag("Comment")?></p>
</fieldset>
</form>
<? } ?>

