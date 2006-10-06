<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>MetaBBS Administration</title>
  <link rel="stylesheet" type="text/css" href="<?=$skin_dir?>/admin.css" />
  <script type="text/javascript" src="<?=$skin_dir?>/script.js"></script>
</head>
<body>
<div id="meta">
	<h1><?=i('MetaBBS Administration')?></h1>
<div id="header">
<?=link_to(i('Boards'), 'admin')?> |
<?=link_to(i('Users'), 'admin', 'users')?> |
<?=link_to(i('Settings'), 'admin', 'settings')?> |
<?=link_to(i('Plugins'), 'admin', 'plugins')?> |
<?=link_to(i('Uninstall'), 'admin', 'uninstall')?> |
<a href="<?=url_with_referer_for('account', 'logout')?>"><?=i('Logout')?> &raquo;</a></p>
</div>
<div id="body">
<? if (isset($flash)) { ?>
<div class="flash <?=$flash_class?>">
<p><?=$flash?></p>
</div>
<? } ?>
<?=$content?>
</div>

</div>
</body>
</html>

