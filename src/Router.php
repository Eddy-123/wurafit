<?php 
/**
 * 
 */
class Router
{
	static $routes = array();
	static $prefixes = array();

	static function prefix($url, $prefix){
		self::$prefixes[$url] = $prefix;
	}


	/**
	 * Permet de parser une url
	 * @param $url url à parser
	 * @return tableau contenant les paramètres	
	 */

	static function parse($url, $request){
		$url = trim($url, '/');
		if (empty($url)) {
			$url = Router::$routes[0]['url'];
		}else{			

			foreach (Router::$routes as $value) {			
				if (preg_match($value['catcher'], $url, $match)) {
					
					$request->controller = $value['controller'];
					$request->action = isset($match['action']) ? $match['action'] : $value['action'];
					$request->params = array();
					foreach ($value['params'] as $key => $value) {
						$request->params[$key] = $match[$key];
					}
					if (!empty($match['args'])) {
						$request->params += explode('/', trim($match['args'], '/'));
					}

					return $request;
				}
			
			}
		}

		$params = explode('/', $url);
		if (in_array($params[0], array_keys(self::$prefixes))) {
			$request->prefix = self::$prefixes[$params[0]];
			array_shift($params);
			
		}
		$request->controller = $params[0];
		$request->action = isset($params[1]) ? $params[1] : 'index';

		foreach (self::$prefixes as $key => $value) {
			if (strpos($request->action, $value.'_') === 0) {

				$request->prefix = $value;
				$request->action = str_replace($value.'_', '', $request->action);
				//debug($request);
			}
		}

		$request->params = array_slice($params, 2);
		return true;
	}

	/**
	 * Connect
	 */
	static function connect($redir, $url){
		$r = array();
		$r['params'] = array();
		$r['url'] = $url;
		$r['redir'] = $redir;


		$r['origin'] = str_replace(':action', '(?P<action>([a-z0-9]+))', $url);

		$r['origin'] = preg_replace('/([a-z0-9]+):([^\/]+)/', '${1}:(?P<${1}>${2})', $r['origin']);
		$r['origin'] = '/^'.str_replace('/', '\/', $r['origin']).'(?P<args>\/?.*)$/';

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
		$r['catcher'] = str_replace(':action', '(?P<action>([a-z0-9]+))', $r['catcher']);
		foreach ($r['params'] as $key => $value) {
			$r['catcher'] = str_replace(":$key", "(?P<$key>$value)", $r['catcher']);
		}

		$r['catcher'] = '/^'.str_replace('/', '\/', $r['catcher']).'$/';
			
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
				return BASE_URL.str_replace('//', '/', '/'.$value['redir']).$match['args'];
			}
		}
		foreach (self::$prefixes as $key => $value) {
			if (strpos($url, $value) === 0) {
				$url = str_replace($value, $key, $url);
			}
		}
		return str_replace('//', '/', BASE_URL.'/'.$url) ;
	}

	static function webroot($url){
		$url = trim($url);
		return BASE_URL.'/'.$url ;	
	}
}