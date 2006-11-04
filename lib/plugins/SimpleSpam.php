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

add_filter('PostSave', 'simple_spam_filter', 10);
add_filter('PostComment', 'simple_spam_filter', 10);

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
