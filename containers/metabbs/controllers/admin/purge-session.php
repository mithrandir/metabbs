<?php
if (is_post()) {
	$count = 0;
	$d = opendir('data/session');
	while ($f = readdir($d)) {
		if ($f[0] == '.') continue;
		$path = 'data/session/'.$f;
		$c = file_get_contents($path);
		if (!preg_match('/seen_posts/', $c)) {
			if (@unlink($path)) $count++;
		}
	}
	closedir($d);
}
?>
