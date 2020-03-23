<?php 
/**
 * 
 */
class Router
{
	static $routes = array();


	/**
	 * Permet de parser une url
	 * @param $url url à parser
	 * @return tableau contenant les paramètres	
	 */

	static function parse($url, $request){
		$url = trim($url, '/');

		foreach (Router::$routes as $value) {			
			if (preg_match($value['catcher'], $url, $match)) {
				$request->controller = $value['controller'];
				$request->action = $value['action'];
				$request->params = array();
				foreach ($value['params'] as $key => $value) {
					$request->params[$key] = $match[$key];
				}
				return $request;
			}
		
		}

		$params = explode('/', $url);
		$request->controller = $params[0];
		$request->action = isset($params[1]) ? $params[1] : 'index';
		$request->params = array_slice($params, 2);
		return true;
	}

	/**
	 * Connect
	 */
	static function connect($redir, $url){
		$r = array();
		$r['params'] = array();

		$r['redir'] = $redir;
		$r['origin'] = preg_replace('/([a-z0-9]+):([^\/]+)/', '${1}:(?P<${1}>${2})', $url);
		$r['origin'] = '/'.str_replace('/', '\/', $r['origin']).'/';

		$params = explode('/', $url);
		foreach ($params as $key => $value) {
			if (strpos($value, ':')) {
				$p = explode(':', $value);
				$r['params'][$p[0]] = $p[1];
			}else{
				if ($key == 0) {
					$r['controller'] = $value;
				}elseif ($key == 1) {
					$r['action'] = $value;
				}
			}
		}

		$r['catcher'] = $redir;
		foreach ($r['params'] as $key => $value) {
			$r['catcher'] = str_replace(":$key", "(?P<$key>$value)", $r['catcher']);
		}

		$r['catcher'] = '/'.str_replace('/', '\/', $r['catcher']).'/';

		self::$routes[] = $r;
		
	}

	/**
	 * 
	 */
	static function url($url){
		foreach (self::$routes as $value) {
			if (preg_match($value['origin'], $url, $match)) {
				foreach ($match as $k => $w) {
					if (!is_numeric($k)) {
						$value['redir'] = str_replace(":$k", $w, $value['redir']);
					}
				}
				return $value['redir'];
			}
		}
		return $url;
	}
}