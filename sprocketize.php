<?php
use \Speedy\Sprocket\Sprocket;

$filePath = preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']);
$sprocket = new Sprocket($filePath, array());
switch ($sprocket->fileExt) {
	case 'css':
		$sprocket->setContentType('text/css')->setBaseFolder('/css');
		break;
	default: case 'js':
		$sprocket->setBaseFolder('/js');
		break;
}
$sprocket->render();
