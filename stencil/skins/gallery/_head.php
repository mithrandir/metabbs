	<link rel="stylesheet" href="<?=$style_dir?>/style.css" type="text/css" />
<? if (isset($board)) { ?>
	<link rel="alternate" href="<?=url_for($board, 'rss')?>" type="application/rss+xml" title="RSS" />
<? } ?>
