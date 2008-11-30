<?php
class IPBlock extends Plugin {
	var $plugin_name = '아이피 차단';
	var $description = '특정 아이피로 접속하는 사용자를 차단합니다.';
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
		add_filter('PostSave', array(&$this, 'record_ip'), 42);
		add_filter('PostComment', array(&$this, 'record_ip'), 42);
		add_filter('PostList', array(&$this, 'append_ip'), 5000);
		add_filter('PostView', array(&$this, 'append_ip'), 5000);
		add_filter('PostViewComment', array(&$this, 'append_ip'), 5000);
	}
	function record_ip(&$model) {
		$model->ip = $_SERVER['REMOTE_ADDR'];
	}
	function append_ip(&$model) {
		global $account;
		if ($model->ip && $account->is_admin()) {
			$model->body .= "<p><small>IP Address: $model->ip</small></p>";
		}
	}
	function on_settings() {
		echo '<h2>IP Blocking</h2>';
		if (is_post()) {
			$fp = fopen('data/ipblock.txt', 'w');
			fwrite($fp, $_POST['words']);
			fclose($fp);

			echo '<div class="flash pass">Settings saved.</div>';
		}
		echo '<form method="post" action="?">';
		echo '<p>IP Blacklist:<br />';
		echo '<textarea name="words" rows="5" cols="30">';
		readfile('data/ipblock.txt');
		echo '</textarea><br />';
		echo '(one address per line. use * for wildcard matching)</p>';
		echo '<input type="submit" value="Save settings" />';
		echo '</form>';
	}
	function on_install() {
		$conn = get_conn();
		$conn->add_field('post', 'ip', 'string', 15);
		$conn->add_field('comment', 'ip', 'string', 15);
	}
	function on_uninstall() {
		$conn->drop_field('post', 'ip');
		$conn->drop_field('comment', 'ip');
	}
}

register_plugin('IPBlock');
?>
