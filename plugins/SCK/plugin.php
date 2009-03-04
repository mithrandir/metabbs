<?php
class SCK extends Plugin {
	var $plugin_name = 'Site Construction Kit';
	var $description = '웹 사이트 구축 도구';
	var $version = 2;
	
	function on_update() {
	}

	function _create_menu_table() {
		$db = get_conn();
		$t = new Table('menu');
		$t->column('name', 'string', 30);
		$t->column('type', 'string', 30);
		$t->column('position', 'integer');
		$t->column('parent', 'integer');
		$t->column('body', 'text');
		$t->add_index('parent');
		$db->add_table($t);
	}
	
	function on_install() {
		global $config;

		$path = dirname(__FILE__);
		$fp = fopen('index.php', 'w');
		fwrite($fp, "<?php include '$path/files/index.php'; ?>");
		fclose($fp);

		$config->set('global_header', "$path/files/header.php");
		$config->set('global_footer', "$path/files/footer.php");
		$config->set('sck_site_name', 'Example Site');
		$config->write_to_file();

		$this->_create_menu_table();
	}

	function on_init() {
		ini_set("include_path", dirname(__FILE__) . PATH_SEPARATOR . ini_get("include_path"));
		require_once 'sck.php';
	}
}

register_plugin('SCK');
