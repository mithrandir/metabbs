<?php
if (!file_exists('containers/metabbs/controllers/'.$_GET['controller'].'/'.$_GET['action'].'.php')) {
	exit;
}
//$return_url = url_for($_GET['controller'], $_GET['action']).$_GET['id'];
$return_url = url_for_metabbs($_GET['controller'], $_GET['action'], array('id'=>$_GET['id']));
?>
