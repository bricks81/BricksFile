<?php

/**
 * Bricks Framework & Bricks CMS
 * http://bricks-cms.org
 *
 * The MIT License (MIT)
 * Copyright (c) 2015 bricks-cms.org
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
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