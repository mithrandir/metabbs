<?php
require 'core/common.php';
require 'core/route.php';

$route = Route::from_request_uri();

include "core/views/$route->view.php";
