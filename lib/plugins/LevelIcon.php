<?php
$level_icon_mapping = array(
	0 => 'guest.png',
	1 => 'user.png',
	255 => 'admin.png'
);

function prepend_level_icon($level, $name) {
	global $level_icon_mapping;
	if (array_key_exists($level, $level_icon_mapping)) {
		return image_tag(METABBS_BASE_PATH.'lib/plugins/icons/'.$level_icon_mapping[$level], $level?'Lv.'.$level:'Guest').' '.$name;
	}
}
function prepend_level_icon_filter(&$model) {
	if ($model->user_id) {
		$user = $model->get_user();
		$level = $user->level;
	} else {
		$level = 0;
	}
	$model->name = prepend_level_icon($user->level, htmlspecialchars($model->name));
}
function user_info_level_icon_filter(&$user) {
	$user->name = prepend_level_icon($user->level, htmlspecialchars($user->name));
}

add_filter('PostView', 'prepend_level_icon_filter', 50);
add_filter('PostViewComment', 'prepend_level_icon_filter', 50);
add_filter('UserInfo', 'user_info_level_icon_filter', 50);
?>
