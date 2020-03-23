<?php 

	$debut = microtime(true);

	define('WEBROOT', dirname(__FILE__));
	define('ROOT', dirname(WEBROOT));
	define('DS', DIRECTORY_SEPARATOR);
	define('SRC', ROOT.DS.'src');
	define('BASE_URL', dirname(dirname($_SERVER['SCRIPT_NAME'])));	

	

	require SRC.DS.'includes.php';
	new Dispatcher();
	
?>
	<div style="position: fixed; bottom: 0; background: #CCC; color: #000; line-height: 30px; height: 30px; left: 0; right: 0; padding-left: 10px;">
		<?= "Page générée en ".round(microtime(true) - $debut, 5)." secondes"; ?>
	</div>

?>