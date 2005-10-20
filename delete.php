<?php

require_once 'libs/Core.php';
require_once 'libs/BBS.php';
require_once 'libs/Template.php';

if (!isset($bid)) Core::Error('No bid');
if (!isset($id)) Core::Error('No article ID');
if (!isset($page)) $page = 1;

$bbs = new BBS($bid);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($passwd)) {
	$article = $bbs->getArticle($id);
	if (md5($passwd) == $article->passwd) {
		$uploads = $article->getAttachments();
		foreach ($uploads as $upload) {
			unlink('uploads/'.$upload->getHash());
		}
		$bbs->deleteArticle($article);
		Core::Redirect("index.php?bid=$bid");
	}
}

$tpl = new Template($bbs->cfg['style']);
$tpl->assign('page', $page);
$tpl->assign('id', $id);
$tpl->display('delete.tpl');

?>

