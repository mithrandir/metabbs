<?php

// $Header: /cvsroot/rubybbs/rubybbs/libs/Comment.php,v 1.2 2004/12/27 22:27:05 ditto Exp $

class Comment {
	var $bid, $id;
	var $cid, $name, $text, $passwd, $date;
	function Comment($bid, $id) {
		$this->bid = $bid;
		$this->id = $id;
	}
}

?>