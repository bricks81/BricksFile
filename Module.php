<?php
/**
 * Bricks Framework & Bricks CMS
 * http://bricks-cms.org
 *
 * @link https://github.com/bricks81/BricksFile
 * @license http://www.gnu.org/licenses/ (GPLv3)
 */
namespace BricksFile;

class Module {
	
	public function getAutoloaderConfig(){
		return array(
			'Zend\Loader\ClassMapAutoloader' => array(
	            __DIR__ . '/autoload_classmap.php',
	        ),
		);
	}
	
}
