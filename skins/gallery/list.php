<h1><?=$title?></h1>

<? if ($board->use_category) { ?>
<div id="category">
<?=i('Category')?>:
<a href="?"><?=i('All')?></a> (<?=$board->get_post_count()?>)
<? foreach ($categories as $_category) { ?>
 <a href="?search[category]=<?=$_category->id?>"><?=$_category->name?></a> (<?=$_category->get_post_count()?>)
<? } ?>
</div>
<? } ?>

<ul id="gallery">
<? foreach ($posts as $post) { $attachments = $post->get_attachments(); ?>
	<li<? if ($post->notice) { ?> class="notice"<? } ?>>
	<? if (!$post->notice && $attachments) { ?>
	<a href="<?=url_for($post)?>" class="thumbnail"><img src="<?=url_for($attachments[0])?>?thumb=1" alt="<?=$post->title?>" /></a>
	<? } ?>
	<? if ($board->use_category && $post->category_id) { ?><span class="category">[<?=link_to_category($post->get_category())?>]</span><? } ?><span class="title"><?=link_to($post->title, $post)?></span>
	<? if ($count = $post->get_comment_count()) { ?>
	<span class="comments-count">*<?=$count?></span>
	<? } ?>
	<span class="writer"><?=$post->name?></span>
	</li>
<? } ?>
</ul>

<div id="gallery-footer">
<? print_pages($board); ?>

<a href="<?=$link_new_post?>"><?=i('New Post')?></a>
</div>
