<?php
class Dispatcher {
	var $parts;
	var $routes;
	var $params;
	var $reserved_controllers = array('admin');

	function Dispatcher() { }

	function load($uri = null) {
		if (!$uri) return;

		apply_filters('BeforeDispatcherLoad', $this);

		$this->parts = explode('/', trim($uri, '/ '));
		$this->routes = array('container' => 'default', 'controller' =>  null, 'action' => null);
		$this->params = Dispatcher::get_params(null, false, array('_GET', '_POST'));

		if (in_array($this->parts[0], $this->reserved_controllers)) {
			$this->routes['container'] = $this->parts[0];
			array_shift($this->parts);
		}

		Dispatcher::legacy_path_filter($this->parts, $this->routes, $this->params);
		Dispatcher::board_path_filter($this->parts, $this->routes, $this->params);

		if (count($this->parts) > 0) {
			$this->routes['controller'] = $this->parts[0];
			$this->routes['action'] = 'index';
			if (count($this->parts) >= 2) {
				if (is_numeric($this->parts[1])) {
					// controller/id-number
					// controller/id-number/action
					$this->params['id'] = intval($this->parts[1]);
					$this->routes['action'] = (count($this->parts) == 3) ? $this->parts[2] : 'view';
				} else {
					if (count($this->parts) >= 3) {
						// controller/id-not-number/action
						$this->params['id'] = $this->parts[1];
						$this->routes['action'] = $this->parts[2];
					} else
						// controller/action
						$this->routes['action'] = $this->parts[1];
				}
			}
		}
	}

	function url_for($controller = null, $action = null, $params = array(), $container = 'default') {

		$urls = array();
		$routes = array(
			'container' => $container ,
			'controller' => $controller,
			'action' => $action
		);

		Dispatcher::default_url_filter($this->parts, $routes, $params);

		if (empty($routes['controller'])) {
			$routes['controller'] = $this->routes['controller'];
			$routes['action'] = empty($routes['action']) ? $this->routes['action'] : $routes['action'];
		} else {
			$action = empty($routes['action']) ? null : $routes['action'];
		}

		Dispatcher::legacy_url_filter($this->parts, $routes, $params);
		Dispatcher::board_url_filter($this->parts, $routes, $params);

		if (in_array($routes['action'], array('index','view')))
			$routes['action'] = null;

		if (isset($routes['container']) and $routes['container'] != 'default')
			$urls[0] = $routes['container'];
		$urls[1] = $routes['controller'];
		if (isset($params['id'])) {
			$urls[2] = urlencode($params['id']);
			unset($params['id']);
			if (isset($routes['action']) and !empty($routes['action']))
				$urls[3] = $routes['action'];
		} else {
			if (isset($routes['action']) and !empty($routes['action']))
				$urls[2] = $routes['action'];
		}

		return METABBS_BASE_PATH.implode('/',$urls). ($params ? query_string_for($params):'');
	}

	function legacy_path_filter(&$parts, &$routes, &$params) {
		if ($routes['container'] == 'default') {
			if ($parts[0] == 'board' and !is_numeric($parts[1])) {
				if (count($parts) == 2) {
					// board/{board_name} -> {board_name}
					$parts = array($parts[1]);
				} else if (count($parts) == 3) {
					// board/{action}/{board_name} -> {board_name}/{action}
					$parts = array($parts[2], $parts[1]);
				}
			}

			if ($parts[0] == 'post' and is_numeric($parts[1])) {
				$post = Post::find($parts[1]);
				$board = $post->get_board();
				$parts[0] = $board->name;
			}

			if ($parts[0] == 'user'/* and !is_numeric($parts[1])*/) {
				$user = User::find_by_user($parts[1]);
				if ($user->exists())
					$parts[1] = $user->get_id();
			}

			if ($parts[0] == 'attachment' and !is_numeric($parts[1])) {
				$params['fileurl'] = $parts[1];
				list($params['id']) = explode('_', $params['fileurl'], 2);
				$parts[1] = $params['id'];
			}
		}
	}

	function board_path_filter(&$parts, &$routes, &$params) {
		if ($routes['container'] == 'default') {	
			$board = Board::find_by_name($this->parts[0]);
			if ($board->exists()) {
				$this->params['board_name'] = $this->parts[0];
				$this->parts[0] = 'board';
			}
		}
	}

	function default_url_filter($parts, &$routes, &$params) {
		if ($routes['container'] == 'default') {
			if (!is_string($routes['controller'])) {
				if ($routes['controller']->model == 'post') {
					$params['id'] = $routes['controller']->id;
					$routes['controller'] = $routes['controller']->get_board();
					$params['board_name'] = $routes['controller']->name;
				} else if ($routes['controller']->model == 'board') {
					$params['board_name'] = $routes['controller']->name;
				} else if ($routes['controller']->model == 'attachment') {
					$params['id'] = $routes['controller']->get_id();
				} else {
					$params['id'] = $routes['controller']->id;
				}
				$routes['controller'] = $routes['controller']->model;
			}
		} else {
			if (!is_string($routes['controller'])) {
				if (isset($routes['controller']->model) && $routes['controller']->model == 'plugin') {
					$params['id'] = $routes['controller']->name;
					$routes['controller'] = $routes['controller']->model;
				} else {
					if (isset($routes['controller']))
						$params['id'] = $routes['controller']->id;
					$routes['controller'] = isset($routes['controller']->model) ? $routes['controller']->model : null;
				}
			}
		}
	}

	function legacy_url_filter($parts, &$routes, &$params) {
		if ($routes['container'] == 'default') {
			if ($routes['controller'] == 'user' and is_numeric($params['id'])) {
				$user = User::find($params['id']);
				if ($user->exists()) {
					$params['id'] = $user->is_openid_account() ? $user->id : $user->user;
				}
			}
		}
	}

	function board_url_filter($parts, &$routes, &$params) {
		if ($routes['container'] == 'default') {	
			if ($routes['controller'] == 'board' and isset($params['board_name'])) {
				$routes['controller'] = $params['board_name'];
				unset($params['board_name']);
			}
		}
	}

	function get_container_path() {
		return 'app/'.$this->routes['container'].'/'.$this->routes['container'].'.php';
	}
	function get_controller_path() {
		return 'app/'.$this->routes['container'].'/controllers/'.$this->routes['controller'].'.php';
	}
	function get_action_path() {
		return 'app/'.$this->routes['container'].'/controllers/'.$this->routes['controller'].'/'.$this->routes['action'].'.php';
	}
	function get_view_path() {
		return 'app/'.$this->routes['container'].'/views/'.$this->routes['controller'].'/'.$this->routes['action'].'.php';
	}

	function get_params($defaults = null, $overwrite = false, $super_globals = array('_GET', '_POST', '_COOKIE'))
	{
		$ret = array();

		foreach($super_globals as $sg)
			foreach($GLOBALS[$sg] as $k=>$v)
				$ret[$k] = $v;

		if($defaults)
			foreach($defaults as $k=>$v)
				if(!isset($ret[$k]))
					$ret[$k] = $v;

		if($overwrite)
			$_REQUEST = $ret;

		return $ret;
	}
}

if (!defined('METABBS_BASE_URI')) {
	global $config;
	if ($config->get('force_fancy_url', false) ||
			strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']) !== 0) {
		define('METABBS_BASE_URI', METABBS_BASE_PATH);
	} else {
		define('METABBS_BASE_URI', $_SERVER['SCRIPT_NAME'] . '/');
	}
}

function query_string_for($params) {
	$_params = array();

	foreach ($params as $key => $value) {
		$_params[] = "$key=".urlencode($value);
	}
	return '?' . implode('&', $_params);
}

function get_search_params() {
	$params = array();
	$keys = array();
	if (isset($_GET['category']) && $_GET['category'] !== '') {
		$keys[] = 'category';
	}
	if (isset($_GET['keyword']) && trim($_GET['keyword'])) {
		$keys[] = 'keyword';
		$keys[] = 'title';
		$keys[] = 'body';
		$keys[] = 'comment';
		$keys[] = 'author';
		$keys[] = 'tag';
	}
	if ($keys) $keys[] = 'page';

	apply_filters('GetSearchParams', $keys);
	foreach ($keys as $k) {
		if ($k == 'page')
			$params['page'] = get_requested_page();
		else if (isset($_GET[$k]) && $_GET[$k] !== '')
			$params[$k] = $_GET[$k];
	}
	return $params;
}

function url_for($controller = null, $action = null, $params = array()) {
	global $dispatcher;
	return $dispatcher->url_for($controller, $action, $params);
}

function full_url_for($controller = null, $action = null, $params = array()) {
	global $dispatcher;
	return METABBS_HOST_URL.$dispatcher->url_for($controller, $action, $params);
}

function url_with_referer_for($controller = null, $action = null, $params = array()) {
	global $dispatcher;
	$params['url'] = isset($_GET['url']) ? $_GET['url'] : $_SERVER['REQUEST_URI'];
	return $dispatcher->url_for($controller, $action, $params);
}

function full_url_with_referer_for($controller = null, $action = null, $params = array()) {
	global $dispatcher;
	$params['url'] = isset($_GET['url']) ? $_GET['url'] : $_SERVER['REQUEST_URI'];	
	return METABBS_HOST_URL.$dispatcher->url_for($controller, $action, $params);
}

function url_admin_for($controller = null, $action = null, $params = array()) {
	global $dispatcher;
	return $dispatcher->url_for($controller, $action, $params, 'admin');
}

function redirect_to($url) {
	header('Location: ' . $url);
	exit;
}

function redirect_back() {
	if (isset($_GET['url'])) {
		redirect_to(urldecode($_GET['url']));
	} else {
		redirect_to($_SERVER['HTTP_REFERER']);
	}
}
?>
