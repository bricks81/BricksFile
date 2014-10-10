<?php

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
