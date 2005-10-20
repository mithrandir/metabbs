<?php

require_once 'libs/Core.php';
require_once 'libs/BBS.php';

if (!isset($bid)) Core::Error('no bid');

$bbs = new BBS($bid);
$list = $bbs->getList(0, 10);
$url_prefix = 'http://'.$_SERVER['HTTP_HOST'].($_SERVER['SERVER_PORT']!=80?':'.$_SERVER['HTTP_PORT']:'').dirname($_SERVER['PHP_SELF']).'/';

header("Content-Type: text/xml; charset=euc-kr");
echo '<?xml version="1.0" encoding="euc-kr"?>';
$tz = date('O');

?>

<rss version="2.0">
	<channel>
		<title><?php echo $bbs->cfg['title']?></title>
		<link><?php echo $url_prefix.'index.php?bid='.$bid?></link>
		<description />
		<pubDate><?php echo strftime('%a, %d %b %Y %H:%M:%S '.$tz)?></pubDate>
		<generator>RubyBBS <?php echo RUBYBBS_VERSION?></generator>
<?php foreach ($list as $article) { ?>
		<item>
			<title><?php echo htmlspecialchars($article->subject)?></title>
			<link><?php echo $url_prefix.'index.php?bid='.$bid.'&amp;id='.$article->id?></link>
			<description />
			<pubDate><?php echo strftime('%a, %d %b %Y %H:%M:%S ', $article->date).$tz?></pubDate>
			<author><?php echo htmlspecialchars($article->name)?></author>
		</item>
<?php } ?>
	</channel>
</rss>
