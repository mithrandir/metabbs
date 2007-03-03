<?php
class LevelIcon extends Plugin {
	var $description = 'Display a level icon';
	var $mapping = array(
		0 => 'guest.png',
		1 => 'user.png',
		255 => 'admin.png'
	);

	function on_init() {
		add_filter('PostView', array(&$this, 'prepend_level_icon_filter'), 50);
		add_filter('PostList', array(&$this, 'prepend_level_icon_filter'), 50);
		add_filter('PostViewComment', array(&$this, 'prepend_level_icon_filter'), 50);
		add_filter('UserInfo', array(&$this, 'user_info_level_icon_filter'), 50);
	}
	function prepend_level_icon($level, $name) {
		if (array_key_exists($level, $this->mapping)) {
			return image_tag(METABBS_BASE_PATH.'plugins/icons/'.$this->mapping[$level], $level?'Lv.'.$level:'Guest', array('style' => 'vertical-align: middle')).' '.$name;
		} else {
			return $name;
		}
	}
	function prepend_level_icon_filter(&$model) {
		if ($model->user_id) {
			$user = $model->get_user();
			$level = $user->exists() ? $user->level : 0;
			if ($level > 0) $model->name = link_to($model->name, $user);
		} else {
			$level = 0;
		}
		$model->name = $this->prepend_level_icon($level, $model->name);
	}
	function user_info_level_icon_filter(&$user) {
		$user->name = $this->prepend_level_icon($user->level, htmlspecialchars($user->name));
	}
}

register_plugin('LevelIcon');
?>
