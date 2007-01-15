	<link rel="stylesheet" href="<?=$skin_dir?>/style.css" type="text/css" />
<? if (isset($board)) { ?>
	<link rel="alternate" href="<?=url_for($board, 'rss')?>" type="application/rss+xml" title="RSS" />
<? } ?>
	<script type="text/javascript" src="<?=$skin_engine_dir?>/mootools.js"></script>
	<script type="text/javascript" src="<?=$skin_engine_dir?>/script.js"></script>
	<script type="text/javascript">
	<!--
	var skin_dir = '<?=$skin_dir?>';
	window.onload = function () {
<? if (isset($_GET['search'])) { ?>
		highlight('td.title a, .post-title h2, #body', '<?=$board->search['text']?>');
<? } ?>
	}
	//-->
	</script>
