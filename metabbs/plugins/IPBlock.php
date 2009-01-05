<?php
class IPBlock extends Plugin {
	var $plugin_name = '아이피 차단';
	var $description = '글 쓸 때 아이피 주소를 기록하고, 특정 아이피로 접속하는 사용자를 차단합니다.';
	var $version = 1;

	function on_update() {
		if ($this->installed_version == 0) {
			$db = get_conn();
			$this->_move_to_metadata($db, 'post');
			$this->_move_to_metadata($db, 'comment');
			$this->update_to(1);
		}
	}
	function _move_to_metadata(&$db, $model) {
		$table = get_table_name($model);
		$result = $db->query("SELECT id, ip FROM $table WHERE ip != ''");
		while ($row = $result->fetch()) {
			insert('metadata', array(
				'model' => $model, 'model_id' => $row['id'],
				'key' => 'ip', 'value' => $row['ip']
			));
		}
		$db->drop_field($model, 'ip');
	}

	function on_init() {
		if (!file_exists(METABBS_DIR.'/data/ipblock.txt')) {
			fclose(fopen(METABBS_DIR.'/data/ipblock.txt', 'w'));
		} else {
			$fp = fopen(METABBS_DIR.'/data/ipblock.txt', 'r');
			while (!feof($fp)) {
				$ip = rtrim(fgets($fp, 20));
				if (preg_match('/^'.str_replace('*', '.*', str_replace('.', '\.', $ip)).'$/', $_SERVER['REMOTE_ADDR'])) {
					header('HTTP/1.1 403 Forbidden');
					print_notice(i('Access denied'), 'You are blocked by the administrator. (Your IP address: ' . $_SERVER['REMOTE_ADDR'] . ')');
					exit;
				}
			}
			fclose($fp);
		}
		add_filter('AfterPostSave', array(&$this, 'record_ip'), 42);
		add_filter('AfterPostComment', array(&$this, 'record_ip'), 42);
		add_filter('PostList', array(&$this, 'append_ip'), 5000);
		add_filter('PostView', array(&$this, 'append_ip'), 5000);
		add_filter('PostViewComment', array(&$this, 'append_ip'), 5000);
	}
	function record_ip(&$model) {
		$model->set_attribute('ip', $_SERVER['REMOTE_ADDR']);
	}
	function append_ip(&$model) {
		global $account;
		if ($model->body && (!$this->only_admin() || $account->is_admin()) &&
					($ip = $model->get_attribute('ip'))) {
			if (!$account->is_admin()) $ip = $this->scramble($ip);
			$model->body .= "<p><small>IP Address: $ip</small></p>";
		}
	}
	function scramble($ip) {
		$p = explode('.', $ip);
		$p[2] = str_repeat('x', strlen($p[2]));
		return implode('.', $p);
	}
	function on_settings() {
		echo '<h2>IP Blocking</h2>';
		if (is_post()) {
			$fp = fopen('data/ipblock.txt', 'w');
			fwrite($fp, $_POST['words']);
			fclose($fp);
			
			$this->set_attribute('only_admin', $_POST['only_admin']);

			echo '<div class="flash pass">Settings saved.</div>';
		}
		echo '<form method="post" action="?">';
		echo '<p>IP Blacklist:<br />';
		echo '<textarea name="words" rows="5" cols="30">';
		readfile('data/ipblock.txt');
		echo '</textarea><br />';
		echo '(one address per line. use * for wildcard matching)</p>';

		echo '<p><input type="hidden" name="only_admin" value="f" /><input type="checkbox" name="only_admin" value="t"' . ($this->only_admin() ? ' checked="checked"' : '') . ' /> Show IP addresses only to administrators</p>';
		echo '<input type="submit" value="Save settings" />';
		echo '</form>';
	}
	function only_admin() {
		$option = $this->get_attribute('only_admin');
		if (!$option || $option == 't')
			return true;
		else
			return false;
	}
	function on_uninstall() {
		delete_all('metadata', "(model='post' OR model='comment') AND `key`='ip'");
	}
}

register_plugin('IPBlock');
?>
