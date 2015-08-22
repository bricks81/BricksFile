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

use JMS\Serializer\Exception\RuntimeException;

use Bricks\File\Directory;

class File extends \SplFileObject {

	
	/**
	 * @param string $file
	 * @param integer $mode
	 * @param integer $dmode
	 * @return \Bricks\File\File
	 */
	public static function touch($file,$mode=0644,$dmode=0750){
		if(!file_exists(dirname($file))){
			Directory::mkdir(dirname($file),$dmode);			
		}
		touch($file);
		chmod($file,$mode);
		return new self($file);		
	}
	
	/**
	 * @param string $source
	 * @param string $target
	 * @return \Bricks\File\File
	 */
	public static function staticCopy($source,$target){
		$file = new self($source);
		$file->copy($target);
		return new self($target);
	}
	
	/**
	 * @param string $target
	 * @param integer $mode
	 * @param integer $dmode
	 * @return \Bricks\File\File
	 */
	public function copy($target,$mode=0644,$dmode=0750){
		$source = $this->getPathname();
		if(!file_exists(dirname($target))){
			Directory::mkdir(dirname($target),$dmode);
		}
		copy($source,$target);
		return new self($target);
	}
	
	/**
	 * @param string|File $file
	 */
	public static function unlink($file){
		if($file instanceof File){
			$file = $file->getPathname();
		}
		unlink($file);			
	}
	
	/**
	 * Cleans a filename and replace special characters
	 * @param string $filename
	 * @param string $replacement
	 * @return string
	 */
	public static function cleanFilename($filename,$replacement='-'){
		$filename = str_replace("\0",'',$filename);
		$filename = preg_replace('#[^a-zA-Z0-9._-]+#b',$replacement,$filename);
		if(strlen($filename)>255){
			$ext = substr($filename,strrpos($filename,'.'));
			$name = substr($filename,0,255-strlen($ext));
			$filename = $name.$ext;
		}
		return $filename;
	}
	
	/**
	 * Adds or increment a prefixed integer in the path
	 * @param string $path
	 * @return string
	 */
	public static function incrementFilename($path){
		$i = 1;
		$dir = dirname($path);
		$filename = basename($path);
		if(preg_match('#^(\d+)-(.*)$#',basename($path),$matches)){
			$i = (int) $matches[1];
			$filename = $matches[2];
		}
		do {
			$target = rtrim($dir,'/').'/'.self::cleanFilename($i++.'-'.$filename);
		} while(file_exists($target));
		return $target;
	}
	
}