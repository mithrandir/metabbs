<?php

class Attachment {
	var $bid, $id, $fileid, $filename;
	function Attachment($bid, $id, $fileid = 0) {
		$this->bid = $bid;
		$this->id = $id;
		$this->fileid = $fileid;
	}
	function getHash() {
		return $this->bid.'_'.$this->id.'_'.md5($this->filename).'.file';
	}
	function isImage() {
		return in_array(strrchr($this->filename, '.'), array('.gif', '.jpg', '.png'));
	}
}

?>
