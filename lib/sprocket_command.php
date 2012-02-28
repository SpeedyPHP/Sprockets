<?php
/**
 * PHPSprocket - A PHP implementation of Sprocket
 *
 * @package sprocket
 * @subpackage libs
 */

/**
 * SprocketCommand Class
 * 
 * @author Kjell Bublitz
 */
class SprocketCommand {

	/**
	 * Sprocket Object
	 * @var object
	 */
	var $Sprocket;
	
	/**
	 * Command Constructor
	 */
	function __construct(&$sprocket) {
		$this->Sprocket = $sprocket;
	}
	
	/**
	 * Return filename
	 */
	function getFileName($context, $param) {
		return basename($context.'/'.$param.'.'.$this->Sprocket->fileExt);
	}
	
	/**
	 * Return filecontext
	 */
	function getFileContext($context, $param) {
		return dirname($context.'/'.$param.'.'.$this->Sprocket->fileExt);
	}

	/**
	 * Return array of files
	 */
	function getFileNamesFromDir($context, $param) {
		$dh = opendir($context.'/'.$param);
		$files = array();
		while (($file = readdir($dh)) !== false) {
			if ($file !== '.' && $file !== '..') {
				if (is_dir($context.'/'.$param.'/'.$file)) {
					$files = array_merge($files, $this->getFileNamesFromDir($context, $param.'/'.$file));
				} else {
					$files[] = array(
						'fileName' => $file,
						'fileContext' => $param
					);
				}
			}
		}
		return $files;
	}
}