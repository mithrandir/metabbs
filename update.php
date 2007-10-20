<?php
require_once "lib/common.php";
require_once "lib/backends/$backend/installer.php";
include 'db/schema.php';

function print_rev_info() {
	global $current;
?>
<table>
	<tr>
		<th>Current version:</th>
		<td>r<?=$current?></td>
	</tr>
	<tr>
		<th>Latest version:</th>
		<td>r<?=METABBS_DB_REVISION?></td>
	</tr>
</table>
<?php
}

$conn = get_conn();
if (isset($_GET['rev'])) {
	$current = $_GET['rev'];
} else {
	$current = $config->get('revision', 347);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>MetaBBS Updater</title>
	<link rel="stylesheet" href="<?=METABBS_BASE_PATH?>elements/style.css" type="text/css" />
</head>
<body>
<div id="meta-admin">
<h1>MetaBBS Updater</h1>
<div id="body">
<?php
if ($current < METABBS_DB_REVISION) {
	if (is_post()) {
		// find updates
		$revs = array();
		$dh = opendir('db');
		while ($f = readdir($dh)) {
			if (preg_match('/^update_([0-9]+)\.php$/', $f, $matches)) {
				if ($matches[1] > $current) {
					$revs[] = $matches[1];
				}
			}
		}
		closedir($dh);

		sort($revs);
		echo '<ul>';
		foreach ($revs as $r) {
			echo "<li>Applying patch: r$r";
			include "db/update_$r.php";
			if (isset($description)) {
				echo " ($description)";
				unset($description);
			}
			echo "</li>";
		}
		$config->set('revision', METABBS_DB_REVISION);
		$config->write_to_file();
		echo '</ul><p>done.</p>';
	} else {
		print_rev_info();
?>
<form method="post" action="">
<p>New update is available.</p>
<? if (!is_writable('metabbs.conf.php') && !@chmod('metabbs.conf.php', 0707)) { ?>
<p>Configuration file is not writable. To continue the process, please change the permission of <code>metabbs.conf.php</code> to <code>0707</code>.</p>
<? } else { ?>
<p><input type="submit" value="Update now" /></p>
<? } ?>
</form>
<?php
	}
} else {
	print_rev_info();
?>
<p>This MetaBBS is up to date. You don't need to update.</p>
<?php
}
?>
</div>
</div>
</body>
</html>
