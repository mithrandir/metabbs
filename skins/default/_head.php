	<link rel="stylesheet" href="<?=$skin_dir?>/style.css" type="text/css" />
<? if (isset($board)) { ?>
	<link rel="alternate" href="<?=url_for($board, 'rss')?>" type="application/rss+xml" title="RSS" />
<? } ?>
	<script type="text/javascript" src="<?=$skin_dir?>/script.js"></script>
	<script type="text/javascript">
	<!--
	var skin_dir = '<?=$skin_dir?>';
	window.onload = function () {
<? if (isset($_GET['search'])) { ?>
<? if ($controller == 'post') { ?>
		highlight('#title', '<?=$board->search['text']?>');
		highlight('#body', '<?=$board->search['text']?>');
<? } else if ($controller == 'board') { ?>
		highlight('td.title a', '<?=$board->search['text']?>');
<? } ?>
<? } ?>
	}
	//-->
	</script>
