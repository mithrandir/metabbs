<?php
$spam_words = array('casino', 'poker', 'porn', 'blackjack', 'roulette', 'viagra', 'phentermine', '[url=');

function simple_spam_has_spam_word($text) {
	global $spam_words;
	foreach ($spam_words as $word) {
		if ($word && strpos($text, $word) !== FALSE)
			return $word;
	}
	return false;
}
function simple_spam_filter($model) {
	$word = simple_spam_has_spam_word($model->body);
	if ($word !== FALSE) {
		echo "<h2>Warning!</h2>";
		echo "the word '$word' cannot be contained in the content.";
		exit;
	}
}

function simple_spam_init() {
	add_filter('PostSave', 'simple_spam_filter', 10);
	add_filter('PostComment', 'simple_spam_filter', 10);
}

register_plugin('SimpleSpam', 'Block posts containing bad words.', 'simple_spam_init');
?>
