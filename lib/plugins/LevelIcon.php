<?php
$level_icon_mapping = array(
	0 => 'guest.png',
	1 => 'user.png',
	255 => 'admin.png'
);

function prepend_level_icon_filter(&$model) {
	global $level_icon_mapping;
	if ($model->user_id) {
		$user = $model->get_user();
		$level = $user->level;
	} else {
		$level = 0;
	}
	$model->name = htmlspecialchars($model->name); // XXX
	if (array_key_exists($level, $level_icon_mapping)) {
		$model->name = image_tag(METABBS_BASE_PATH.'lib/plugins/icons/'.$level_icon_mapping[$level], $level?'Lv.'.$level:'Guest').' '.$model->name;
	}
}

add_filter('PostView', 'prepend_level_icon_filter', 50);
add_filter('PostViewComment', 'prepend_level_icon_filter', 50);

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
