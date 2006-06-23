<?php foreach ($posts as $post) { ?>
<div class="post">
	<h2><?php echo link_to_post($post); ?></h2>
	<div class="date"><?php echo $post->created_at; ?></div>
	<p><?php echo format($post->body); ?></p>

	<div class="info">
		<?php echo link_text(url_for($post) . "#comments", $post->get_comment_count() . " Comments"); ?> |
		<?php echo link_text(url_for($post) . "#trackbacks", $post->get_trackback_count() . " Trackbacks"); ?>
	</div>
</div>
<?php } ?>

<? print_pages($page); ?>
