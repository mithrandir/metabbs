<?php
class SimpleSpam extends Plugin {
	var $description = 'Block posts containing bad words.';
	function on_init() {
		if (!file_exists('data/spam.txt')) {
			$fp = fopen('data/spam.txt', 'w');
			fwrite($fp, implode("\n", array('casino', 'poker', 'porn', 'blackjack', 'roulette', 'viagra', 'phentermine', '[url=')));
			fclose($fp);
		}
		$this->spam_words = array_map('rtrim', file('data/spam.txt'));
		add_filter('PostTrackback', array(&$this, 'tb_filter'), 10);
		add_filter('PostSave', array(&$this, 'filter'), 10);
		add_filter('PostComment', array(&$this, 'filter'), 10);
	}
	function on_uninstall() {
		@unlink('data/spam.txt');
	}
	function on_settings() {
		echo '<h2>SimpleSpam</h2>';
		if (is_post()) {
			$fp = fopen('data/spam.txt', 'w');
			fwrite($fp, $_POST['words']);
			fclose($fp);

			echo '<div class="flash pass">Settings saved.</div>';
		}
		echo '<form method="post" action="?">';
		echo '<p>Spam words:<br />';
		echo '<textarea name="words" rows="5" cols="30">';
		readfile('data/spam.txt');
		echo '</textarea><br />';
		echo '(one word per line)</p>';
		echo '<input type="submit" value="Save settings" />';
		echo '</form>';
	}
	function has_spam_word($text) {
		foreach ($this->spam_words as $word) {
			if ($word && strpos($text, $word) !== FALSE)
				return $word;
		}
		return false;
	}
	function filter($model) {
		$word = $this->has_spam_word($model->body);
		if ($word !== FALSE) {
			header('HTTP/1.1 406 Not Acceptable');
			echo "The word '$word' cannot be contained in the content.";
			exit;
		}
	}
	function tb_filter(&$trackback) {
		$word = $this->has_spam_word($trackback->excerpt);
		if ($word !== FALSE) {
			$trackback->valid = false;
		}
	}
}

register_plugin('SimpleSpam');
?>
