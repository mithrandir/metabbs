<?php
class URIParser {
	function parse($uri) {
		$parts = explode('/', $uri, 4);
		$len = count($parts);
		if ($len == 4) { // /controller/action/id
			return array($parts[1], $parts[2], $parts[3] ? $parts[3] : NULL);
		} else if ($parts[1] && ($len == 2 || $len == 3)) { // /controller/id
			return array($parts[1], 'index', $len == 3 && $parts[2] ? $parts[2] : NULL);
		} else {
			return FALSE;
		}
	}
}
