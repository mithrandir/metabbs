<? if (!print_header()) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?=$title?></title>
	<? include($_skin_dir . '/_head.php'); ?>
</head>
<body>
<p>Hello, <?=link_to_user($account)?>! :) <? print_nav(get_account_control($account)); ?></p>
<? } ?>
<div id="meta">
<?=$content?>

<div id="nav">
<p><? print_nav(); ?></p>
</div>
</div>
<? if (!print_footer()) { ?>
</body>
</html>
<? } ?>
