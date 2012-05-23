<?php 
defined("STDOUT") or define("STDOUT", fopen("php://stdout", "w"));

function debug($str = "") {
	fwrite(STDOUT, $str . "\n");
}

if (!preg_match('/(.*)\.(js|css)/', $_SERVER['REQUEST_URI'])) {
	return false;
} else {
	debug('Sprocktize: ' . $_SERVER['REQUEST_URI']);
	include_once "sprocketize-demo.php";
}

?>