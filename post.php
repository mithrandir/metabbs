<?php

require_once 'libs/Core.php';
require_once 'libs/BBS.php';
require_once 'libs/Template.php';

if (!isset($bid)) Core::Error('No bid');
if (!isset($page)) $page = 1;

$bbs = new BBS($bid);
$article = isset($id) ? $bbs->getArticle($id) : new Article($bid);

function _upload($bbs, $article, $upload) {
	$upload_count = count($upload['name']);
	for ($i = 0; $i < $upload_count && $bbs->cfg['use_attachment']; $i++) {
		$name = $upload['name'][$i];
		$tmpname = $upload['tmp_name'][$i];
		if ($name && $tmpname) {
			$attach = new Attachment($bbs->bid, $article->id);
			$attach->filename = $name;
			move_uploaded_file($tmpname, 'uploads/'.$attach->getHash());
			$article->addAttachment($attach);
		}
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($name && $subject && $passwd && $text) {
		setcookie('cache_name', $name);
		$article->name = $name;
		$article->subject = $subject;
		$article->text = $text;
		if (isset($id)) {
			if (md5($passwd) == $article->passwd) {
				foreach ($delete as $del) {
					$attach = new Attachment($bid, $article->id, $del);
					unlink('uploads/'.$attach->getHash());
					$article->deleteAttachment($attach);
				}
				_upload($bbs, $article, $upload);
				$article->update();
				Core::Redirect("index.php?bid=$bid&id=$id");
			}
		} else {
			$article->passwd = $passwd;
			$article->id = $bbs->postArticle($article);
			$upload_count = count($upload['name']);
			_upload($bbs, $article, $upload);
			Core::Redirect("index.php?bid=$bid");
		}
	}
}

$tpl = new Template($bbs->cfg['style']);
$tpl->assign('page', $page);
if (isset($id)) $tpl->assign('id', $id);
if (isset($cache_name)) $article->name = $cache_name;
$tpl->assign('article', $article);
$tpl->display('post.tpl');

?>
