<?php
class EnglishPatient extends Plugin {
	var $plugin_name = '영어 환자';
	var $description = 'ASCII 문자로만 작성된 글/댓글/트랙백을 막습니다.'; 
	var $pattern = '/^[\\x{00}-\\x{7F}]+$/u';
	function on_init() {
		add_filter('PostTrackback', array(&$this, 'tb_filter'), 10);
		add_filter('PostComment', array(&$this, 'cmt_filter'), 20);
		add_filter('PostSave', array(&$this, 'post_filter'), 20);
	}
	function tb_filter($model) {
		if (preg_match($this->pattern, $model->title) && preg_match($this->pattern, $model->excerpt)) {
			$model->valid = false;
		}
	}
	function cmt_filter($model) {
		if (strlen($model->body) > 10 && preg_match($this->pattern, $model->body)) {
			echo "<h2>English Patient plugin enabled!</h2>";
			echo "you can't post a comment only with ascii characters.";
			exit;
		}
	}
	function post_filter($model) {
		if (preg_match($this->pattern, $model->title) &&
			preg_match($this->pattern, $model->body)) {
			echo "<h2>English Patient plugin enabled!</h2>";
			echo "you can't post a comment only with ascii characters.";
			exit;
		}
	}
}

register_plugin('EnglishPatient');
?>
