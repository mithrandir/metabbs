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
	<h1>MetaBBS Administration</h1>
<div id="header">
	<p><a href="?action=index">Boards</a> | <a href="?action=users">Users</a> | <a href="?action=settings">Settings</a> | <a href="?action=uninstall">Uninstall</a> | <a href="account/logout?url=<?=get_base_path()?>admin.php">Logout &raquo;</a></p>
</div>
<div id="body">
<? if (isset($flash)) { ?>
<div class="flash fail">
<p><?=$flash?></p>
</div>
<? } ?>
<?=$content?>
</div>

</div>
</body>
</html>

