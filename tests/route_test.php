<?php
require "../core/route.php";

// remove_empty_elements
assert(array() == remove_empty_elements(array()));
assert(array('hello', 'world') == remove_empty_elements(array('hello', '', 'world')));

// query_string_for
assert('' == query_string_for(array()));
assert('?key=value' == query_string_for(array('key' => 'value')));
assert('?k1=v1&k2=v2' == query_string_for(array('k1' => 'v1', 'k2' => 'v2')));

// Route::from_uri
$r = Route::from_uri("/user/ditto");
assert('user/index' == $r->view);
assert('ditto' == $r->id);

$r = Route::from_uri("/account/login");
assert('account/login' == $r->view);
