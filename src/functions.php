<?php 
function debug($var){
	if (Conf::$debug > 0) {
		$backtrace = debug_backtrace();
		echo '<p>&nbsp;</p><p><a href="#"><strong>'.$backtrace[0]['file'].'</strong> l.'.$backtrace[0]['line'].'</a></p>'; 
		echo "<ol>";
		foreach ($backtrace as $key => $value) {
			if ($key > 0 && $key < 10) {
				echo '<li><strong>'.$value['file'].'</strong> l.'.$value['line'].'</li>'; 
			}
		}
		echo "</ol>";
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	}
}

function truncate($text, $limit){
	$tab = explode(' ', $text, ($limit+1));
	while(count($tab) > $limit){ 
		array_pop($tab); 
	}	
	return implode(' ', $tab);
}

?>