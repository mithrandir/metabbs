<?php
class LevelIcon extends Plugin {
	var $plugin_name = '레벨 아이콘';
	var $description = '사용자의 레벨에 따라 닉네임 앞에 아이콘을 붙입니다.';
	var $icons = array();

	function on_install() {
		mkdir('data/icons');
		copy(dirname(__FILE__).'/icons/admin.png', 'data/icons/255.png');
		copy(dirname(__FILE__).'/icons/user.png', 'data/icons/1.png');
		copy(dirname(__FILE__).'/icons/guest.png', 'data/icons/0.png');
	}
	function on_init() {
		if (!file_exists(METABBS_DIR . '/data/icons'))
			$this->on_install();

		add_filter('PostView', array(&$this, 'prepend_level_icon_filter'), 1000);
		add_filter('PostList', array(&$this, 'prepend_level_icon_filter'), 1000);
		add_filter('PostViewComment', array(&$this, 'prepend_level_icon_filter'), 1000);
		add_filter('UserInfo', array(&$this, 'user_info_level_icon_filter'), 1000);
	}
	function cache_icons() {
		$dir = opendir(METABBS_DIR.'/data/icons');
		while ($f = readdir($dir)) {
			if (preg_match('/^[0-9]+/', $f, $matches)) {
				$this->icons[$matches[0]] = $f;
			}
		}
	}
	function prepend_level_icon($level, $name) {
		$this->cache_icons();
		if (array_key_exists($level, $this->icons))
			return $this->get_image_tag($name, $level, $this->icons[$level]);
		else
			return $name;
	}
	function get_image_tag($name, $level, $icon) {
		return image_tag(METABBS_BASE_PATH.'data/icons/'.$icon, $level?'Lv.'.$level:'Guest', array('style' => 'vertical-align: middle')).' '.$name;
	}
	function prepend_level_icon_filter(&$model) {
		if ($model->user_id) {
			$user = $model->get_user();
			$level = $user->exists() ? $user->level : 0;
		} else {
			$level = 0;
		}
		$model->name = $this->prepend_level_icon($level, $model->name);
	}
	function user_info_level_icon_filter(&$user) {
		$user->name = $this->prepend_level_icon($user->level, htmlspecialchars($user->name));
	}
	function delete_icon($level) {
		if (isset($this->icons[$level])) {
			unlink('data/icons/'.$this->icons[$level]);
			unset($this->icons[$level]);
		}
	}
	function on_settings() {
		$this->cache_icons();
		if (is_post()) {
			$level = $_POST['level'];
			if (preg_match('/^[0-9]+$/', $level) && $level >= 0 && $level < 256 && is_uploaded_file($_FILES['icon']['tmp_name'])) {
				$ext = strrchr($_FILES['icon']['name'], '.');
				$this->delete_icon($level);
				move_uploaded_file($_FILES['icon']['tmp_name'], 'data/icons/'.$level.$ext);
				$this->icons[$level] = $level.$ext;
			}
		}
		if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
			$this->delete_icon($_GET['delete']);
			redirect_to('?');
		}
		ksort($this->icons);
?>
<table>
<tr>
	<th><?=i('Level')?></th>
	<th>Icon</th>
	<th><?=i('Actions')?></th>
</tr>
<?php foreach ($this->icons as $level => $icon) { ?>
<tr>
	<td><?=$level?></td>
	<td><?=$this->get_image_tag('', $level, $icon)?></td>
	<td><a href="?delete=<?=$level?>"><?=i('Delete')?></a></td>
</tr>
<?php } ?>
</table>

<form method="post" action="?" enctype="multipart/form-data">
<dl>
	<dt><label><?=i('Level')?> (0~255)</label></dt>
	<dd><input type="text" name="level" size="3" /></dd>

	<dt><label>Icon image</label></dt>
	<dd><input type="file" name="icon" size="40" /></dd>
</dl>
<p><input type="submit" value="Upload" /></p>
</form>
<?php
	}
}

register_plugin('LevelIcon');
?>
