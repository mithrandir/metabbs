<?php
class URIParser {
	function parse($uri) {
		$parts = explode('/', substr($uri, 1));
		$len = count($parts);

		// 몇몇 주소는 예전 방식으로 처리
		if (in_array($parts[0], array('account', 'admin', 'auth', 'feed', 'category', 'comment', 'plugin', 'trackback')))
			if ($len == 3) { // /controller/action/id
				return array($parts[0], $parts[1], $parts[2] ? $parts[2] : NULL);
			} else if ($parts[0] && ($len == 1 || $len == 2)) { // /controller/id
				return array($parts[0], 'index', $len == 2 && $parts[1] ? $parts[1] : NULL);
			} else {
				return FALSE;
			}

		if ($len == 1)
			if ($parts[0][0] == '~')
				return array('user', 'index', substr($parts[0], 1));
			else
				return array('board', 'index', $parts[0]);
		else
			if (is_numeric($parts[1]))
				return array('post', @$parts[2] ? $parts[2] : 'index', $parts[1]);
			else
				return array('board', $parts[1], $parts[0]);
	}
}
