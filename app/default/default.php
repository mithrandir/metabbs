<?php
$css = 'themes/'.get_current_theme().'/style.css';
if (file_exists($css))
	$layout->add_stylesheet(METABBS_BASE_PATH . $css);
$layout->add_javascript(METABBS_BASE_PATH . 'media/script.js');
?>
