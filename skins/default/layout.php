<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?=$board->title?></title>
    <link rel="stylesheet" href="<?=$skin_dir?>/style.css" type="text/css" />
    <link rel="alternate" href="<?=url_for($board, 'rss')?>" type="application/rss+xml" title="RSS" />
    <script type="text/javascript">
    <!--
    var skin_dir = '<?=$skin_dir?>';
    //-->
    </script>
    <script type="text/javascript" src="<?=$skin_dir?>/script.js"></script>
</head>
<body>
<div id="meta">
<?=$content?>
<p style="font-size:10px"><a href="<?=get_base_path()?>admin.php">admin</a></p>
</div>
</body>
</html>
