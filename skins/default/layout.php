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
    <script type="text/javascript">
    <!--
    var skin_dir = '<?=$skin_dir?>';
    //-->
    </script>
    <script type="text/javascript" src="<?=$skin_dir?>/script.js"></script>
</head>
<body>
<? if (!$user->is_guest()) { ?>
<p>Hello, <?=$user->name?>! :) <a href="<?=url_for('user', 'logout', true)?>">Logout</a>
<? if ($user->level == 255) { ?>
| <a href="<?=get_base_path()?>admin.php">Admin</a>
<? } ?>
</p>
<? } else { ?>
<p><a href="<?=url_for('user', 'login', true)?>">Login</a> | <a href="<?=url_for('user', 'signup', true)?>">Sign Up</a></p>
<? } ?>
<div id="meta">
<? include($content); ?>
</div>
</body>
</html>
