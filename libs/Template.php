<?php

require_once 'libs/smarty/Smarty.class.php';

class Template extends Smarty {
	function Template($style) {
		global $bid, $bbs;

		$this->template_dir = "templates/$style";
		$this->compile_dir = $this->template_dir . '/_compile';

		$pre = array(
			'bid' => $bid,
			'rubybbs_version' => RUBYBBS_VERSION,
			'tpl_dir' => $this->template_dir
		);
		$this->assign($pre);
		if (isset($bbs)) {
			$this->assign('cfg', $bbs->cfg);
		}
	}
}

?>