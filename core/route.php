<?php
function remove_empty_elements($array) {
	return array_values(array_filter($array, create_function('$elem', 'return !empty($elem);')));
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
		if ($this->container) {
			$parts = array($this->container);
			if ($this->id)
				$parts[] = $this->id;

			list(, $action) = explode('/', $this->view, 2);
			if ($action != 'index')
				$parts[] = $this->view;
		} else {
			$parts = array($this->view);
		}

		return implode('/', $parts) . query_string_for($this->params);
	}

	/*static*/ function from_uri($uri) {
		$r = new Route;
		$r->params = $_GET + $_POST;

		$parts = remove_empty_elements(explode('/', substr($uri, 1)));
		$count = count($parts);

		if ($parts[0] == 'user') {
			$r->view = 'user/index';
			$r->id = $parts[1];
			return $r;
		} else if ($parts[0] == 'account') {
			$r->view = 'account/' . $parts[1];
			return $r;
		}

		// Possible URI patterns:
		// {container}
		// {container}/{view}
		// {container}/{id}
		// {container}/{id}/{view}

		$r->container = $parts[0];
		$r->view = 'container/index';
		if ($count >= 2)
			if (is_numeric($parts[1])) {
				$r->id = $parts[1];
				$r->view = 'entry/' . ($count >= 3 ? $parts[2] : 'index');
			} else {
				$r->view = 'container/' . $parts[1];
			}

		return $r;
	}

	/*static*/ function from_request_uri() {
		return Route::from_uri(rtrim($_SERVER['PATH_INFO'], '/'));
	}
}
