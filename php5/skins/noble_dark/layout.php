<? if (!print_header()) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?=$title?></title>
	<link rel="stylesheet" href="<?=$skin_dir?>/style.css" type="text/css" />
<? if (isset($board)) { ?>
	<link rel="alternate" href="<?=url_for($board, 'rss')?>" type="application/rss+xml" title="RSS" />
<? } ?>
	<script type="text/javascript" src="<?=$skin_dir?>/script.js"></script>
	<script type="text/javascript">
	<!--
	var skin_dir = '<?=$skin_dir?>';
	function init() {
<? if (isset($_GET['searchtype'])) { ?>
		$('searchtype').value = '<?=$_GET['searchtype']?>';
<? } ?>
<? if (isset($_GET['search'])) { ?>
<? if ($controller == 'post') { ?>
		highlight('h2', '<?=$_GET['search']?>');
		highlight('#body', '<?=$_GET['search']?>');
<? } else if ($controller == 'board') { ?>
		highlight('td.title a', '<?=$_GET['search']?>');
<? } ?>
<? } ?>
	}
	//-->
	</script>
</head>
<body onload="init()">
<? } ?>
<div id="meta">
<? if ($title != "MetaBBS") { ?>
	<h1><?=$title?></h1>
<? } ?>
	<div id="meta-control">
		Hello, <?=$account->name?>! :)
		<?=implode(' | ', get_account_control($account))?>
	</div>
	<div id="meta-content">
<?=$content?>
	<div id="meta-nav"><? print_nav(); ?></div>
	</div>
<? if (!print_footer()) { ?>
	<div id="meta-tail">
		<p>Powered by <a href="http://metabbs.org">MetaBBS</a></p>
	</div>
</div>
</body>
</html>
<? } ?>
