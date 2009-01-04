<?php
$template_engine = 'standard';
$options = array(
	'get_body_in_the_list' => false,
	'preload_attachments' => true,
	'exclude_notice' => true,
	'build_comment_tree' => false
);

$GLOBALS['layout']->add_stylesheet(METABBS_BASE_PATH.$this->get_path().'/lightbox/css/lightbox.css');
?>
