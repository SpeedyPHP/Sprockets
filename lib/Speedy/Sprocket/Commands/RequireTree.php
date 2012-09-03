<?php
/**
 * PHPSprocket - A PHP implementation of Sprocket
 *
 * @package Speedy/Sprocket
 * @subpackage Commands
 */
namespace Speedy\Sprocket\Commands;


use \Speedy\Sprocket\Command;

class RequireTree extends Command
{
	/**
	 * Command Exec
	 * @return string Parse file
	 */
	function exec($param, $context) 
	{
		$source = '';

		// parse require params
		if (preg_match('/\"([^\"]+)\" ([^\n]+)|\"([^\"]+)\"/', $param, $match)) // "param"
		{
			if (count($match) == 3) {
				$paramArg = $match[1];
				$optionArg = $match[2];
			}
			if (count($match) == 4) {
				$paramArg = $match[3];
			}

			$fileNames = $this->getFileNamesFromDir($context, $paramArg);
			foreach ($fileNames as $file) {

				$extension = pathinfo($file['fileName'], PATHINFO_EXTENSION);
				if ($extension == 'handlebars') {
					$name = str_replace('.'.$extension, '', $file['fileContext'].'/'.$file['fileName']);
					$name = str_replace('./', '', $name);
					$_source = $this->Sprocket->parseFile($file['fileName'], $context.'/'.$file['fileContext']);
					$_source = "Ember.TEMPLATES['".$name."'] = Ember.Handlebars.compile('".str_replace(array("\r\n", "\r", "\n", "\t", "  "), '', $_source)."');\n";
					$source .= $_source;
				} else {
					$_source = $this->Sprocket->parseFile($file['fileName'], $context.'/'.$file['fileContext']);

					// apply file options
					if (!empty($_source) && isset($optionArg)) {
						$fileOptions = array_map('trim', explode(',', $optionArg));
						foreach ($fileOptions as $option) {
							$optionMethod = 'option'.ucfirst($option);
							$_source = $this->{$optionMethod}($_source, $file['fileContext'], $file['fileName']);
						}
					}
					$source .= $_source;
				}
			}
		}
		
		return $source;
	}

	/**
	 * Apply minification if possible
	 * 
	 * @param string $source
	 * @return string
	 */
	function optionMinify($source, $context = null, $filename = null) 
	{
		if ($this->Sprocket->fileExt == 'css') {
			if (!class_exists('cssmin')) {
				require_once(realpath(dirname(__FILE__).'/../third-party/'.MINIFY_CSS));
			}
			$source = cssmin::minify($source, "preserve-urls");	
		}
		
		if ($this->Sprocket->fileExt == 'js') {
			if (!class_exists('JSMin')) {
				require_once(realpath(dirname(__FILE__).'/../third-party/'.MINIFY_JS));
			}
			$source = JSMin::minify($source);	
		}

		return $source;
	}

}