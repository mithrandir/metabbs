<?php
require 'core/common.php';
require 'core/route.php';

$route = Route::from_request_uri();
$container = Container::find_by_name($route->container);

$controller = $container->get_controller();
$controller->process($route->view);
