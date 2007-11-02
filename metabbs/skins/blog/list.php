<? foreach ($posts as $post) { ?>
<? include ($_skin_dir . '/_post.php'); ?>
<? } ?>

<div class="pagination">Older posts: <? print_pages($board); ?></div>
