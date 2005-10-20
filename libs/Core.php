<?php

// $Header: /cvsroot/rubybbs/rubybbs/libs/Core.php,v 1.11 2005/02/03 12:31:16 ditto Exp $

define("RUBYBBS_VERSION", "0.3");

class Core {
	/**
	* 오류 메시지 출력 (static)
	* @param $msg 오류 메시지
	*/
	function Error($msg) {
		print "<p>$msg</p>";
		exit;
	}
	/**
	* 페이지 이동 (static)
	* @param $url 이동할 URL
	*/
	function Redirect($url) {
		if (!headers_sent()) {
			header("Location: $url");
		} else {
			$url = htmlspecialchars($url);
			print "<meta http-equiv=\"refresh\" content=\"0;url=$url\" />";
		}
		exit;
	}
}

@import_request_variables('gpc');

@include 'config.php';

?>
