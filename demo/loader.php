<?php 

function loadClass($class) {
	$classPath	= str_replace('\\', DIRECTORY_SEPARATOR, $class);
	$fullPath	= ".." . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . $classPath . '.php';
	
	debug("FULL_PATH: " . $fullPath);
	if (file_exists($fullPath)) {
		require_once $fullPath;
		return true;
	}
	
	return false;
}


spl_autoload_register('loadClass');

?>