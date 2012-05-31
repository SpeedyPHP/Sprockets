<?php
/**
 * PHPSprocket - A PHP implementation of Sprocket
 *
 * @package Speedy/Sprocket
 * @subpackage Commands
 */
namespace Speedy\Sprocket\Commands;


use \Speedy\Sprocket\Command;

class Provide extends Command 
{
	/**
	 * Command Exec
	 */	
	function exec($param, $context) {
		preg_match('/\"([^\"]+)\"/', $param, $match);
		foreach(glob($context.'/'.$match[1].'/*') as $asset) {
			shell_exec('cp -r '.realpath($asset).' '.realpath($this->Sprocket->assetFolder));
		}
	}
}