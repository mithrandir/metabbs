<?php

require_once 'libs/Core.php';
require_once 'libs/BBS.php';

if (!isset($bid)) Core::Error('No bid');
if (!isset($id)) Core::Error('No article ID');
if (!isset($page)) $page = 1;

$bbs = new BBS($bid);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$article = $bbs->getArticle($id);
	$comment = new Comment($bid, $id);
	if ($name && $text && $passwd) {
		setcookie('cache_name', $name);
		$comment->name = $name;
		$comment->text = $text;
		$comment->passwd = $passwd;
		$article->postComment($comment);
		Core::Redirect("index.php?bid=$bid&id=$id&page=$page");
	}
}

?>

