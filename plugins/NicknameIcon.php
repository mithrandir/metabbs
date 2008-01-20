<?php
class NicknameIcon extends Plugin {
	var $plugin_name = '닉네임 아이콘';
	var $description = '닉네임 대신 아이콘을 표시합니다.';

	function on_install() {
		mkdir('data/usericons');
	}
	function on_init() {
		add_filter('PostView', array(&$this, 'replace_icon_filter'), 599);
		add_filter('PostList', array(&$this, 'replace_icon_filter'), 599);
		add_filter('PostViewComment', array(&$this, 'replace_icon_filter'), 599);
		add_filter('UserInfo', array(&$this, 'user_info_icon_filter'), 599);
	}
	function replace_icon_filter(&$model) {
		if (!$model->user_id) return;
		if (file_exists('data/usericons/'.$model->user_id)) {
			$model->name = "<img src=\"".METABBS_BASE_PATH."data/usericons/$model->user_id\" alt=\"$model->name\" />";
		}
	}
	function user_info_icon_filter(&$user) {
		if (file_exists('data/usericons/'.$user->id)) {
			$user->name = "<img src=\"".METABBS_BASE_PATH."data/usericons/$user->id\" alt=\"$user->name\" />";
		}
	}
	function delete_icon($userid) {
		unlink('data/usericons/'.$userid);
	}
	function get_user_icons() {
		$icons = array();
		$dir = opendir('data/usericons');
		while ($id = readdir($dir)) {
			if (!is_numeric($id)) continue;
			$u = User::find($id);
			$icons[$id] = $u->name;
		}
		return $icons;
	}
	function on_settings() {
		if (is_post()) {
			$userid = $_POST['user'];
			$user = User::find_by_user($userid);
			if (!$user->exists()) {
				$msg = '없는 사용자 아이디입니다.';
			} else if (is_uploaded_file($_FILES['icon']['tmp_name'])) {
				move_uploaded_file($_FILES['icon']['tmp_name'], 'data/usericons/'.$user->id);
				$msg = '아이콘을 추가했습니다.';
			} else {
				$msg = '업로드에 실패했습니다.';
			}
		}
		if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
			unlink('data/usericons/'.$_GET['delete']);
			$msg = '아이콘을 삭제했습니다.';
		}
?>
<? if (isset($msg)) { ?>
<p class="flash"><?=$msg?></p>
<? } ?>
<table>
<tr>
	<th>사용자</th>
	<th>아이콘</th>
	<th><?=i('Actions')?></th>
</tr>
<?php foreach ($this->get_user_icons() as $id => $name) { ?>
<tr>
	<td><?=$name?></td>
	<td><img src="<?=METABBS_BASE_PATH."data/usericons/$id"?>" alt="<?=$name?>" /></td>
	<td><a href="?delete=<?=$id?>"><?=i('Delete')?></a></td>
</tr>
<?php } ?>
</table>

<form method="post" action="?" enctype="multipart/form-data">
<dl>
	<dt><label><?=i('User ID')?></label></dt>
	<dd><input type="text" name="user" /></dd>

	<dt><label>Icon image</label></dt>
	<dd><input type="file" name="icon" size="40" /></dd>
</dl>
<p><input type="submit" value="Upload" /></p>
</form>
<?php
	}
}

register_plugin('NicknameIcon');
?>
