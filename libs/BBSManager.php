<?php

// $Header: /cvsroot/rubybbs/rubybbs/libs/BBSManager.php,v 1.5 2005/02/04 12:37:11 ditto Exp $

class BBSManager {
	var $db;
	function BBSManager() {
		$this->table = PREFIX.'config';
		$this->db = _get_conn();
	}
	function getList() {
		$list = array();
		$result = $this->db->query("SELECT bid FROM $this->table");
		while ($info = $result->fetchRow()) {
			$list[] = new BBS($info['bid']);
		}
		return $list;
	}
	function isExists($bid) {
		return ($this->db->getOne("SELECT COUNT(*) FROM $this->table WHERE bid='$bid'") == 1);
	}
	function create($bid) {
		$query = "CREATE TABLE ".PREFIX."bbs_$bid (`idx` int(10) unsigned NOT NULL auto_increment,`sort_id` int(11) NOT NULL default '0',`name` varchar(32) NOT NULL default '',`subject` varchar(255) NOT NULL default '',`text` longtext NOT NULL,`passwd` varchar(32) NOT NULL default '',`date` int(11) NOT NULL default '0',`total_cmts` int(10) unsigned NOT NULL default '0',PRIMARY KEY  (`idx`),KEY `sort_id` (`sort_id`))";
		$query2 = "CREATE TABLE ".PREFIX."cmt_$bid (`idx` int(10) unsigned NOT NULL default '0',`cid` int(10) unsigned NOT NULL auto_increment,`name` varchar(32) NOT NULL default '',`text` text NOT NULL,`passwd` varchar(32) NOT NULL default '',`date` int(10) unsigned NOT NULL default '0',PRIMARY KEY  (`cid`),KEY `id` (`idx`))";
		$this->db->query("INSERT INTO $this->table (bid) VALUES('$bid')");
		$this->db->query($query);
		$this->db->query($query2);
		$bbs = new BBS($bid);
		return $bbs;
	}
	function drop($bid) {
		$this->db->query("DELETE FROM $this->table WHERE bid='$bid'");
		$this->db->query("DROP TABLE ".PREFIX."bbs_$bid");
		$this->db->query("DROP TABLE ".PREFIX."cmt_$bid");
	}
	function getTemplateList() {
		$list = array();
		$dp = opendir('templates');
		while ($dir = readdir($dp)) {
			if ($dir[0] != '.' && $dir[0] != '_' && $dir != 'CVS') {
				$list[] = $dir;
			}
		}
		return $list;
	}
	function changePassword($new_passwd) {
		@include "config.php";
		$fp = @fopen("config.php", "r");
		if ($fp) {
			$s = "";
			while (!feof($fp)) {
				$s .= fread($fp, 1024);
			}
			fclose($fp);
		}
		$s = preg_replace('/\$admin_passwd\s=\s["\']'.$admin_passwd.'["\'];/i', "\$admin_passwd = '$new_passwd';", $s);
		$fp = fopen("config.php", "w");
		fwrite($fp, $s);
		fclose($fp);
	}
}

$bm = new BBSManager();

?>
