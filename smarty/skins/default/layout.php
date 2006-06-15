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
	window.onload = function () {
<? if (isset($_GET['search'])) { ?>
<? if ($controller == 'post') { ?>
		highlight('#title', '<?=$_GET['search']?>');
		highlight('#body', '<?=$_GET['search']?>');
<? } else if ($controller == 'board') { ?>
		highlight('td.title a', '<?=$_GET['search']?>');
<? } ?>
<? } ?>
	}
	//-->
	</script>
</head>
<body>
<p>Hello, <?=link_to_user($user)?>! :) <? print_nav(get_account_control($user)); ?></p>

<div id="meta">
<?=$content?>

<div id="nav">
<p><? print_nav(); ?></p>
</div>
</div>
</body>
</html>
