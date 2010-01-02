<?php
if (strpos($_GET['url'], METABBS_BASE_URI) !== 0)
	die('insecure return URL');

$return_url = $_GET['url'];
?>
