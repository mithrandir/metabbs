<?php
function get_themes() {
	$d = opendir('themes');
	$themes = array();
	while ($f = readdir($d)) {
		if ($f[0] != '.' && is_dir('themes/'.$f))
			$themes[] = $f;
	}
	return $themes;
}

function get_current_theme() {
	return $GLOBALS['config']->get('theme', 'default');
}
