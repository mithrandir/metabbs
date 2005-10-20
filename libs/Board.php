<?php

require_once 'libs/MySQL.php';
require_once 'libs/Article.php';
require_once 'libs/BoardManager.php';

class Board {
	var $bid, $db;
	function Board($bid) {
		$this->bid = $bid;
		$this->table = PREFIX.'boards';
		$this->posts_table = PREFIX.'posts';
		$this->db = _get_conn();
	}
	function readSetting() {
		return $this->db->getRow("SELECT * FROM $this->table WHERE bid='$this->bid'");
	}
	function saveSetting() {
		$q = '';
		foreach ($this->cfg as $k=>$v) {
			$q .= "$k='$v',";
		}
		$q = substr($q, 0, strlen($q)-1);
		$this->db->query("UPDATE ".PREFIX."config SET $q WHERE bid='$this->bid'");
	}
	function getPosts($start, $factor) {
		$list = array();
		$result = $this->db->query('SELECT idx as id, sort_id, name, subject, date, total_cmts FROM '.$this->table.' ORDER BY sort_id LIMIT '.$start.','.$factor);
		while ($data = $result->fetchRow()) {
			$article = new Article($this->bid);
			$article->id = $data['id'];
			$article->name = $data['name'];
			$article->subject = $data['subject'];
			$article->date = $data['date'];
			$article->total_cmts = $data['total_cmts'];
			$list[] = $article;
		}
		return $list;
	}
	function getArticle($id) {
		$data = $this->db->getRow('SELECT idx as id, sort_id, name, subject, date, passwd, text, total_cmts FROM '.$this->table.' WHERE idx='.$id);
		$article = new Article($this->bid);
		foreach ($data as $k=>$v) {
			$article->$k = $v;
		}
		return $article;
	}
	function postArticle($article) {
		$next_sid = $this->db->getOne('SELECT MIN(sort_id) FROM '.$this->table) - 1;
		$query = "INSERT INTO $this->table (sort_id, name, subject, text, passwd, date, total_cmts) VALUES($next_sid, '$article->name', '$article->subject', '$article->text', MD5('$article->passwd'), UNIX_TIMESTAMP(), 0)";
		$this->db->query($query);
		return $this->db->getInsertId();
	}
	function deleteArticle($article) {
		$this->db->query("DELETE FROM $this->table WHERE idx=$article->id");
		$this->db->query("DELETE FROM ".PREFIX."cmt_$this->bid WHERE idx=$article->id");
		$this->db->query("DELETE FROM ".PREFIX."attachment WHERE bid=$this->bid AND idx=$article->id");
	}
	function getTotal() {
		return $this->db->getOne('SELECT COUNT(*) FROM '.$this->table);
	}
}

?>
