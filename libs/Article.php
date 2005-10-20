<?php

// $Header: /cvsroot/rubybbs/rubybbs/libs/Article.php,v 1.10 2005/01/22 00:16:18 ditto Exp $

require_once 'libs/Comment.php';
require_once 'libs/Attachment.php';

class Article {
	var $bid, $id, $name, $subject, $text, $date, $passwd, $total_cmts=0;
	function Article($bid) {
		$this->bid = $bid;
		$this->table = PREFIX.'bbs_'.$bid;
		$this->cmt_table = PREFIX.'cmt_'.$bid;
		$this->attach_table = PREFIX.'attachment';
		$this->db = _get_conn();
	}
	function getTotalComments() {
		return $this->total_cmts;
	}
	function getComments() {
		$cmts = array();
		$result = $this->db->query("SELECT cid, name, text, date FROM $this->cmt_table WHERE idx=$this->id");
		while ($data = $result->fetchRow()) {
			$cmt = new Comment($this->bid, $this->id);
			$cmt->cid = $data['cid'];
			$cmt->name = $data['name'];
			$cmt->text = $data['text'];
			$cmt->date = $data['date'];
			$cmts[] = $cmt;
		}
		return $cmts;
	}
	function postComment($comment) {
		$this->db->query("INSERT INTO $this->cmt_table (idx, name, text, passwd, date) VALUES($this->id, '$comment->name', '$comment->text', MD5('$comment->passwd'), UNIX_TIMESTAMP())");
		$this->db->query("UPDATE $this->table SET total_cmts=total_cmts+1 WHERE idx=$this->id");
	}
	function update() {
		$this->db->query("UPDATE $this->table SET name='$this->name', subject='$this->subject', text='$this->text', date=UNIX_TIMESTAMP() WHERE idx=$this->id");
	}
	function getURL($page = 1) {
		return "index.php?bid=$this->bid&amp;id=$this->id&amp;page=$page";
	}
	function getAttachments() {
		$list = array();
		$result = $this->db->query("SELECT fileid, filename FROM $this->attach_table WHERE bid='$this->bid' AND idx='$this->id'");
		while ($data = $result->fetchRow()) {
			$attach = new Attachment($this->bid, $this->id, $data['fileid']);
			$attach->filename = $data['filename'];
			$list[] = $attach;
		}
		return $list;
	}
	function addAttachment($attach) {
		$this->db->query("INSERT INTO $this->attach_table VALUES('$this->bid', $this->id, '', '$attach->filename')");
	}
	function deleteAttachment($attach) {
		$this->db->query("DELETE FROM $this->attach_table WHERE bid='$this->bid' AND idx=$this->id AND fileid=$attach->fileid");
	}
}

?>
