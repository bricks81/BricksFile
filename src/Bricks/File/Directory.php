<?php

/**
 * @copyright 	(C) 2002-2009, 28-n-half.de (svu)
 * @author 		Sven Ullmann <sven-ullmann@28-n-half.de>
 * @category	My
 * @package		My_Directory
 */

namespace Bricks\File;

use Bricks\File\File;

/**
 * Class extending SPL class and adding diffrent directory operations
 */
class Directory extends \RecursiveDirectoryIterator {

	/**
	 * @param string $dir
	 * @param integer $mode
	 * @return \Bricks\File\Directory
	 */
	public static function mkdir($dir,$mode=0750){
		mkdir($dir,$mode,true);
		return new self($dir);
	}
	
	/**
	 * @param string $dir
	 */
	public static function rmdir($dir){
		if($dir instanceof Directory){
			$dir = $dir->getPathname();
		}
 		$dh = opendir($dir);
 		while(false!==($file=readdir($dh))){
 			if('.'==$file||'..'==$file){
 				continue;
 			}
 			if(is_dir($dir.'/'.$file)){
 				self::rmdir($dir.'/'.$file);
 			} else {
 				File::unlink($dir.'/'.$file);
 			}
 		}
 		closedir($dh);
 		rmdir($dir);
 	}
 	
 	/**
 	 * @param string $target
 	 * @param integer $mode
 	 * @param integer $fmode
 	 * @return \Bricks\File\Directory
 	 */
 	public function copy($target,$mode=0750,$fmode=0644){
 		if(!file_exists($target)){
 			mkdir($target,$mode,true);
 		}
 		$dir = $this->getPathname();
 		$dh = opendir($dir);
 		while(false!==($file=readdir($dh))){
 			if('.'==$file||'..'==$file){
 				continue;
 			}
 			if(is_dir($dir.'/'.$file)){
 				$_d = new self($dir.'/'.$file);
 				$_d->copy($target.'/'.$file);
 			} else {
 				copy($dir.'/'.$file,$target.'/'.$file);
 				chmod($dir.'/'.$file,$fmode); 				 				
 			}
 		}
 		closedir($dh);
 		return $this;
 	}
	
}