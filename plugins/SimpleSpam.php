<?php
class SimpleSpam extends Plugin {
	var $description = 'Block posts containing bad words.';
	var $spam_words = array('casino', 'poker', 'porn', 'blackjack', 'roulette', 'viagra', 'phentermine', '[url=');
	function on_init() {
		add_filter('PostTrackback', array(&$this, 'tb_filter'), 10);
		add_filter('PostSave', array(&$this, 'filter'), 10);
		add_filter('PostComment', array(&$this, 'filter'), 10);
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
			echo "<h2>Warning!</h2>";
			echo "the word '$word' cannot be contained in the content.";
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
