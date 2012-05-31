<?php 
require_once "loader.php";

use \Speedy\Sprocket\Sprocket;

// get path from request
$filePath = preg_replace('#\?.*#', '', $_SERVER['REQUEST_URI']);

// prepare sprocket
$sprocket = new Sprocket($filePath, array(
	'baseUri'	=> '/php-sprockets', 
	'debugMode' => true,
	'assetFolder'	=> __DIR__
));

// change base folder based on extension
switch ($sprocket->fileExt) 
{
	case 'css':
		$sprocket->setContentType('text/css')->setBaseFolder('/css');
		break;
	
	default: case 'js':
		$sprocket->setBaseFolder('/js');
		break;
}

// tada!
$sprocket->render();
?>
