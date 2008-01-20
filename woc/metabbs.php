<?php
require_once "lib/config.php";
$GLOBALS['config'] = new Config('metabbs.conf.php');

require_once "lib/model.php";
require_once "lib/query.php";
require_once "lib/backends/".$config->get('backend')."/backend.php";
$GLOBALS['__db'] = get_conn();
set_table_prefix($config->get('prefix', 'meta_'));

require_once "lib/i18n.php";
import_default_language();

require_once "lib/controller.php";
require_once "lib/request.php";
require_once "lib/response.php";

$request = new Request;
$response = new Response;

include "app/controllers/$request->controller.php";
$controller = Controller::construct($request->controller);
$controller->process($request, $response);
