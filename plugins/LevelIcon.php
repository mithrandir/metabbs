<?php
$level_icon_mapping = array(
	0 => 'guest.png',
	1 => 'user.png',
	255 => 'admin.png'
);

function prepend_level_icon($level, $name) {
	global $level_icon_mapping;
	if (array_key_exists($level, $level_icon_mapping)) {
		return image_tag(METABBS_BASE_PATH.'plugins/icons/'.$level_icon_mapping[$level], $level?'Lv.'.$level:'Guest', array('style' => 'vertical-align: middle')).' '.$name;
	}
}
function prepend_level_icon_filter(&$model) {
	$model->name = htmlspecialchars($model->name);
	if ($model->user_id) {
		$user = $model->get_user();
		$level = $user->level;
		$model->name = link_to($model->name, $user);
	} else {
		$level = 0;
	}
	$model->name = prepend_level_icon($level, $model->name);
}
function user_info_level_icon_filter(&$user) {
	$user->name = prepend_level_icon($user->level, htmlspecialchars($user->name));
}

class LevelIcon extends Plugin {
	var $description = 'Display a level icon';
	function on_init() {
		add_filter('PostView', 'prepend_level_icon_filter', 50);
		add_filter('PostList', 'prepend_level_icon_filter', 50);
		add_filter('PostViewComment', 'prepend_level_icon_filter', 50);
		add_filter('UserInfo', 'user_info_level_icon_filter', 50);
	}
}

register_plugin('LevelIcon');
?>
