<?php
function remove_empty_elements($array) {
	return array_filter($array, create_function('$elem', 'return !empty($elem);'));
}

function url_for($route) {
	return METABBS_BASE_URI . $route->to_uri();
}

function query_string_for($params) {
	if (!$params) return "";

	$_params = array();
	foreach ($params as $key => $value) {
		$_params[] = "$key=$value";
	}
	return '?' . implode('&', $_params);
}

class Route {
	var $container;
	var $view;
	var $id;
	var $params = array();

	function to_uri() {
		$parts = array($this->container);
		if ($this->id)
			$parts[] = $this->id;
		if ($this->view != 'index' ||
				($this->view == 'view' && !$this->id))
			$parts[] = $this->view;

		return implode('/', $parts) . query_string_for($this->params);
	}

	/*static*/ function from_uri($uri) {
		$r = new Route;
		$r->params = $_GET + $_POST;

		$parts = remove_empty_elements(explode('/', substr($uri, 1)));
		$count = count($parts);

		// Possible URI patterns:
		// {container}
		// {container}/{view}
		// {container}/{id}
		// {container}/{id}/{view}

		$r->container = $parts[0];
		$r->view = 'index';
		if ($count >= 2)
			if (is_numeric($parts[1])) {
				$r->id = $parts[1];
				$r->view = $count >= 3 ? $parts[2] : 'view';
			} else {
				$r->view = $parts[1];
			}

		return $r;
	}

	/*static*/ function from_request_uri() {
		return Route::from_uri(rtrim($_SERVER['PATH_INFO'], '/'));
	}
}
