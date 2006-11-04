<? foreach ($posts as $post) { ?>
<? include ($_skin_dir . '/_post.php'); ?>
<? } ?>

<? print_pages($board); ?>

<div id="nav">
<? if ($link_new_post) { ?><a href="<?=$link_new_post?>"><?=i('New Post')?></a><? } ?>
</div>
