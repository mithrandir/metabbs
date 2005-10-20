<?php

require_once 'libs/Core.php';
require_once 'libs/BBS.php';
require_once 'libs/Template.php';

if (!isset($bid)) Core::Error('No bid');
if (!isset($page)) $page = 1;

$bbs = new BBS($bid);
$tpl = new Template($bbs->cfg['style']);

$tpl->assign('page', $page);
if (!isset($id)) {
	$factor = $bbs->cfg['factor'];
	$list = $bbs->getList(($page - 1) * $factor, $factor);
	$total = $bbs->getTotal();
	$total_pages = ceil($total / $factor);
	$start = $page - ($page % $page_factor) + 1;
	if (($end = $start + $page_factor - 1) > $total_pages)
		$end = $total_pages;
	
	$tpl->assign(array(
		'list' => $list,
		'total' => $total,
		'total_pages' => $total_pages,
		'prev' => $page - 1,
		'next' => $page + 1,
		'pages' => range($start, $end),
	));
	$tpl->display('list.tpl');
} else {
	$article = $bbs->getArticle($id);
	$tpl->assign('article', $article);
	$tpl->assign('comments', $article->getComments());
	if ($bbs->cfg['use_attachment']) $tpl->assign('attachments', $article->getAttachments());
	if (isset($cache_name)) $tpl->assign('cache_name', $cache_name);
	$tpl->display('read.tpl');
}

?>
