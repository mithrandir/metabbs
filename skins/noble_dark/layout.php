<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo $title?></title>
	<link rel="stylesheet" href="<?php echo $skin_dir?>/style.css" type="text/css" />
<?php if (isset($board)) { ?>
	<link rel="alternate" href="<?php echo url_for($board, 'rss')?>" type="application/rss+xml" title="RSS" />
<?php } ?>
	<script type="text/javascript" src="<?php echo $skin_dir?>/script.js"></script>
	<script type="text/javascript">
	<!--
	var skin_dir = '<?php echo $skin_dir?>';
	function init() {
<?php if (isset($_GET['search'])) { ?>
<?php if ($controller == 'post') { ?>
		highlight('h2', '<?php echo $_GET['search']?>');
		highlight('#body', '<?php echo $_GET['search']?>');
<?php } else if ($controller == 'board') { ?>
		highlight('td.title a', '<?php echo $_GET['search']?>');
<?php } ?>
<?php } ?>
	}
	//-->
	</script>
</head>
<body onload="init()">
<div id="meta_control">
<?php if (!$user->is_guest()) { ?>
		Hello, <?php echo $user->name?>! :) <a href="<?php echo url_with_referer_for('user', 'logout')?>">Logout</a>
<?php if ($user->level == 255) { ?>
| <a href="<?php echo get_base_path()?>admin.php">Admin</a>
<?php } ?>
<?php } else { ?>
	<a href="<?php echo url_with_referer_for('user', 'login')?>">Login</a> | <a href="<?php echo url_with_referer_for('user', 'signup')?>">Sign Up</a>
<?php } ?>
</div>
<div id="meta">
<?php echo $content; ?>
</div>
</body>
</html>
