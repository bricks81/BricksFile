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

use Bricks\File\Directory;

interface FileInterface extends \SplFileObject {

	
	/**
	 * @param string $file
	 * @param integer $mode
	 * @param integer $dmode
	 * @return \Bricks\File\File
	 */
	public static function touch($file,$mode=0644,$dmode=0750);
	
	/**
	 * @param string $source
	 * @param string $target
	 * @return \Bricks\File\File
	 */
	public static function staticCopy($source,$target);
	
	/**
	 * @param string $target
	 * @param integer $mode
	 * @param integer $dmode
	 * @return \Bricks\File\File
	 */
	public function copy($target,$mode=0644,$dmode=0750);
	
	/**
	 * @param string|File $file
	 */
	public static function unlink($file);
	
	/**
	 * Cleans a filename and replace special characters
	 * @param string $filename
	 * @param string $replacement
	 * @return string
	 */
	public static function cleanFilename($filename,$replacement='-');
	
	/**
	 * Adds or increment a prefixed integer in the path
	 * @param string $path
	 * @return string
	 */
	public static function incrementFilename($path);
	
}