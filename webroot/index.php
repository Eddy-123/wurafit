<?php 
	define('WEBROOT', dirname(__FILE__));
	define('ROOT', dirname(WEBROOT));
	define('DS', DIRECTORY_SEPARATOR);
	define('SRC', ROOT.DS.'src');
	define('BASE_URL', dirname(dirname($_SERVER['SCRIPT_NAME'])));	

	

	require SRC.DS.'includes.php';
	new Dispatcher();
	

?>