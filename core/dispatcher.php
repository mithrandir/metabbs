<?php

// Usage :
// /free 
// => $routes = array('container'=>'metabbs', 'controller'=>'board', 'action'=>'index') ,$params => array('board_name'=>'free') 
// /free/new
// => $routes = array('container'=>'metabbs', 'controller'=>'board', 'action'=>'new') ,$params => array('board_name'=>'free') 
// /free/1
// => $routes = array('container'=>'metabbs', 'controller'=>'board', 'action'=>'view') ,$params => array('board_name'=>'free', id=> '1') 
// /free/1/edit
// => $routes = array('container'=>'metabbs', 'controller'=>'board', 'action'=>'edit') ,$params => array('board_name'=>'free', id=> '1') 
// /users => /metabbs/users/index
// /users/new => /metabbs/users/new
// /users/1 => /metabbs/users/1/view
// /users/1/edit => /metabbs/users/1/edit
// /admin/users => /admin/users/index
// /admin/users/new => /admin/users/new
// /admin/users/1 => /admin/users/1/view
// /admin/users/1/edit => /admin/users/1/edit

class Dispatcher {
	var $routes;
	var $params;
	var $parts;
	var $part_count = 0;

	function Dispatcher($uri = null) {
		if(empty($uri)) $uri = rtrim($_SERVER['PATH_INFO'], '/');
		$this->params = get_params(null, false, array('_GET', '_POST'));
		$this->routes = array('container'=>null, 'controller'=> null, 'action'=>null);
		$this->parts = explode('/',$uri, 5);

		$this->parts[0] = $uri;
		// part중에 공백이 있으면 뺀다.
		$this->part_count = count($this->parts) - 1;

		Dispatcher::left_route_map();
	}

	// path => route
	function left_route_map() {
		// reserverd container
		if (preg_match('/^\/(admin)/', $this->parts[0], $match)) {
			// default container		
			$this->routes['container'] = $match[1];
			if (isset($this->parts[2])) {
				// custom route mappings

				// default route mappings
				$this->routes['controller'] = isset($this->parts[2]) && !empty($this->parts[2]) ? $this->parts[2]:'index';
				if (isset($this->parts[3]) && is_numeric($this->parts[3])) {
					$this->params['id'] = $this->parts[3];
					$this->routes['action'] = isset($this->parts[4]) && !empty($this->parts[4]) ? $this->parts[4]:'view';
				} else {
					$this->routes['action'] = isset($this->parts[3]) && !empty($this->parts[3]) ? $this->parts[3]:'index';
				}
			} else {
				$this->routes['controller'] = 'index';
			}

		} else {
			// default container		
			$this->routes['container'] = 'metabbs';
			if (isset($this->parts[1])) {
				// custom route mappings
				$board = Board::find_by_name($this->parts[1]);
				if ($board->exists()) {
					$this->params['board_name'] = $this->parts[1];
					$this->parts[1] = isset($this->parts[2]) && is_numeric($this->parts[2]) ? 'post':'board'; 
				}

				// default route mappings
				$this->routes['controller'] = isset($this->parts[1]) && !empty($this->parts[1]) ? $this->parts[1]:'index';
				if (isset($this->parts[2]) && is_numeric($this->parts[2])) {
					$this->params['id'] = $this->parts[2];
					$this->routes['action'] = isset($this->parts[3]) && !empty($this->parts[3]) ? $this->parts[3]:'view';
				} else {
					$this->routes['action'] = isset($this->parts[2]) && !empty($this->parts[2]) ? $this->parts[2]:'index';
				}
			} else {
				$this->routes['controller'] = 'index';
			}
		}
	}
	// route => path
	function right_route_map() {
		$routes = array();

		// board container
		if ($this->routes['container'] == 'metabbs') {
			// custom route mappings
			if (isset($this->params['board_name']) 
				&& ($this->routes['controller'] == 'board' || $this->routes['controller'] == 'post')) {
				array_push($routes, $this->params['board_name']);
				if (isset($this->params['id']) && !empty($this->params['id']))
					array_push($routes, $this->params['id']);
				if (!empty($this->routes['action']) && !in_array($this->routes['action'],array('index', 'view')))
					array_push($routes, $this->routes['action']);
			}
			return $routes;
		}

		// default route mappings
		if (!empty($this->routes['container'])) {
			// reserverd container
			if (in_array($this->routes['container'], array('admin')))
				array_push($routes, $this->routes['container']);

			if (!empty($this->routes['controller'])) {
				array_push($routes, $this->routes['controller']);
				if (isset($this->params['id']) && !empty($this->params['id']))
					array_push($routes, $this->params['id']);
				if (!empty($this->routes['action']))
					array_push($routes, $this->routes['action']);
			}
		}

		return $routes;
	}

	function url_for($routes = array(), $params = array()){
		$url = METABBS_BASE_URI;

		if(isset($routes['container']))
			$this->routes['container'] = $routes['container'];
		if(isset($routes['controller']))
			$this->routes['controller'] = $routes['controller'];
		if(isset($routes['action']))
			$this->routes['action'] = $routes['action'];
		if(isset($params['id']))
			$this->params['id'] = $params['id'];

		return METABBS_BASE_URI . implode('/', $this->right_route_map()) . ($params ? $this->query_string_for($params):'');
	}

	function url_with_referer_for($routes = array(), $params = array()) {

	}

	function get_routes() {
		return $this->routes;
	}

	function get_params() {
		return $this->params;
	}

	function query_string_for($params) {
		$_params = array();

		foreach ($params as $key => $value) {
			if(!in_array($key, array('id', 'board_name')))
				$_params[] = "$key=$value";
		}
		return $_params ? '?' . implode('&', $_params) : '';
	}
}

/* DEBUG CODE

$dispatcher = new Dispatcher('/admin/free/new');
var_dump($dispatcher->parts);
var_dump($dispatcher->part_count);
var_dump($dispatcher->routes);
var_dump($dispatcher->params);
var_dump($dispatcher->url_for());*/
?>
