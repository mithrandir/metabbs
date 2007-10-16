<?php

class UserPoint extends Plugin {
    var $plugin_name = '점수 계산';
    var $description = '작성한 글, 댓글 수 기준으로 회원의 점수를 계산합니다.';
	var $rule_file_path = 'data/user_point_rule.txt';

	function on_init() {
		if (is_readable($this->rule_file_path)) {
			$file = fopen($this->rule_file_path, 'r');
			$this->post_unit = (float) trim(fgets($file));
			$this->comment_unit = (float) trim(fgets($file));
		}
		else {
			$this->post_unit = 5;
			$this->comment_unit = 1;
		}

		add_filter('UserInfo', array(&$this, 'user_info_filter'), 1000);
	}

	function get_point($user) {
		if (!is_a($user, 'User'))
			$user = User::find((int) $user);

		return $user->get_post_count() * $this->post_unit + $user->get_comment_count() * $this->comment_unit;
	}

	function on_settings() {
		echo "<h2>점수 계산 방식</h2>";
		if (is_post()) {
			if (!file_exists($this->rule_file_path) || is_writable($this->rule_file_path)) {
				$this->post_unit = (float) $_POST['post_unit'];
				$this->comment_unit = (float) $_POST['comment_unit'];

				$fp = fopen($this->rule_file_path, 'w');
				fwrite($fp, "{$this->post_unit}\r\n{$this->comment_unit}");
				fclose($fp);

				echo '<div class="flash pass">규칙을 변경했습니다.</div>';
			}
			else {
				?><div class="flash pass">
					설정 파일을 저장하는데 실패했습니다.
					(<?php echo $this->rule_file_path; ?>에 쓰기 권한이 없습니다.)
				</div><?php 
			}
		}

		?><form method="post" action="?">
			<p>
				<label for="user-point-post-unit">작성한 글 수 ×</label>
				<input id="user-point-post-unit" type="text" name="post_unit" value="<?php echo $this->post_unit; ?>" size="5" />
				+ <label for="user-point-comment-unit">작성한 댓글 수 ×</label>
				<input id="user-point-comment-unit" type="text" name="comment_unit" value="<?php echo $this->comment_unit; ?>" size="5" />
			</p>

			<p><input type="submit" value="적용" /></p>
		</form><?php
	}

	function user_info_filter() {
		global $user;
		$user->additional_info .= "<p>점수: ".$this->get_point($user)."</p>";
	}

}

register_plugin('UserPoint');

