<?php

require_once 'libs/Core.php';
require_once 'libs/MySQL.php';

if (!isset($step)) $step = 1;

if ($step == 3) {
	if ($host && $user && $dbname && $adminpw) {
		$conf = implode('', file('config.php.in'));
		$conf = str_replace('##adminpw##', $adminpw, $conf);
		$conf = str_replace('##host##', $host, $conf);
		$conf = str_replace('##user##', $user, $conf);
		$conf = str_replace('##passwd##', $passwd, $conf);
		$conf = str_replace('##dbname##', $dbname, $conf);
		$fp = fopen('config.php', 'w');
		fwrite($fp, $conf);
		fclose($fp);
		$conn = new MySQL;
		$conn->connect($host, $user, $passwd);
		$conn->select_db($dbname);
		$conn->query("CREATE TABLE rb_config (`bid` varchar(255) NOT NULL default '',`title` tinytext NOT NULL,`header` tinytext NOT NULL,`footer` tinytext NOT NULL,`factor` smallint(6) NOT NULL default '0',`page_factor` smallint(6) NOT NULL default '0',`style` varchar(255) NOT NULL default '',`use_attachment` enum('0','1') NOT NULL default '0',KEY `bid` (`bid`))");
		$conn->query("CREATE TABLE rb_attachment (`bid` varchar(32) NOT NULL default '',`idx` int(10) unsigned NOT NULL default '0',`fileid` int(10) unsigned NOT NULL auto_increment,`filename` varchar(255) NOT NULL default '',PRIMARY KEY  (`fileid`),KEY `bid` (`bid`,`idx`))");
		$conn->disconnect();
		mkdir("uploads", 0777);
	} else {
		$step = 2;
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>RubyBBS Install</title>
	<link rel="Stylesheet" href="templates/_admin/admin.css" type="text/css" />
</head>
<body>
	<h1>RubyBBS Install</h1>
	<h2>Step <?=$step?></h2>
	<div id="contents">
<?php if ($step == 1) { ?>
	<textarea id="license" cols="80" rows="20" readonly="readonly"><?php readfile('LICENSE.txt'); ?></textarea>
		<div style="margin: 10px; font-size: 1.4em;"><a href="?step=2">Agree</a> | <a href="#">Disagree</a></div>
<?php } else if ($step == 2) { ?>
	<form method="post" action="?step=3">
	<table id="create">
	<tr>
		<th>DB Hostname</th><td><input type="text" name="host" value="localhost" size="20" /></td>
	</tr>
	<tr>
		<th>DB Username</th><td><input type="text" name="user" size="20" /></td>
	</tr>
	<tr>
		<th>DB Password</th><td><input type="password" name="passwd" size="15" /></td>
	</tr>
	<tr>
		<th>DB Name</th><td><input type="text" name="dbname" size="20" /></td>
	</tr>
	<tr>
		<th>Admin Password</th><td><input type="password" name="adminpw" size="15" /></td>
	</tr>
	</table>
	<div id="legend">
		<input type="submit" value="Save Setting" class="right" />
	</div>
	</form>
<?php } else if ($step == 3) { ?>
	<p>install completed.</p>
	<p><a href="admin.php">go to admin page</a></p>
<?php } else { ?>
	-_-?
<?php } ?>
	</div>
</body>
</html>
