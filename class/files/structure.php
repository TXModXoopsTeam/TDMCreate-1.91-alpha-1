<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * tdmcreate module
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         tdmcreate
 * @since           2.5.0
 * @author          Txmod Xoops http://www.txmodxoops.org
 * @version         $Id: structure.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');
xoops_load('XoopsFile');
class TDMCreateStructure
{
	/*
	* @var mixed
	*/
	private $xoopsFile = null;
	/*
	* @var string
	*/
	private $moduleName = null;
	/*
	* @var string
	*/  
	protected $folderName = null;
	/*
	* @var string
	*/
	private $fileName = null;
	/*
	* @var string
	*/ 
	private $path = null;
	/*
	* @var mixed
	*/
	//private $uploadPath = null;
	/*
	* @var string
	*/
	private $fromFile = null;
	/*
	* @var string
	*/
	private $toFile = null;
	/*
	*  @public function constructor class
	*  @param string $path
	*/
	public function __construct() {    
		$this->xoopsFile = XoopsFile::getInstance();
	} 	
	/*
	*  @static function &getInstance
	*  @param null
	*/
	public static function &getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
        return $instance;
    }
	/*
	*  @public function getPath
	*  @param string $path
	*/
	public function getPath($path) {		
		$this->path = $path;
	} 
	/*
	*  @public function getPath
	*  @param string $path
	*/
	/*public function getPath($path) {		
		$this->path = TDMC_PATH . DIRECTORY_SEPARATOR . $path;
	}*/
	/*
	*  @public function getUploadPath
	*  @param string $path
	*/
	/*public function getUploadPath($path) {		
		$this->uploadPath = TDMC_UPLOAD_PATH . DIRECTORY_SEPARATOR . $path;
	}*/
	/* 
	*  @public function isDir
	*  @param string $dname                                 
	*/
	public function isDir($dname)
	{		
		if(!is_dir($dname)) {
			mkdir($dname, 0755);
			chmod($dname, 0755);	       
		} else {
			chmod($dname, 0755);
		}
	}
	/* 
	*  @public function makeDir
	*  @param string $dir
	*/
	public function makeDir($dir)
	{   
		$this->isDir(strtolower(trim($dir)));
	}
	/* 
	*  @public function folderPath
	*  @param string $folderName  
    *  @param string $fileName	
	*/
	public function folderPath($folderName, $fileName = null)
	{		
		$this->folderName = $folderName;
		if( $fileName != null ) {
			$this->fileName = $fileName; 
			$ret = $this->path . DIRECTORY_SEPARATOR . $this->moduleName . DIRECTORY_SEPARATOR . $this->folderName . DIRECTORY_SEPARATOR . $this->fileName;
		} else {
			$ret = $this->path . DIRECTORY_SEPARATOR . $this->moduleName . DIRECTORY_SEPARATOR . $this->folderName;
		}
		return $ret; 	   
	}
	/* 
	*  @public function makeDirInModule
	*  @param string $folderName                                 
	*/
	public function makeDirInModule($folderName)
	{ 		   
		$fname = $this->folderPath($folderName); 	   
		$this->makeDir($fname);
	}
	/* 
	*  @public function makeDir & copy file
	*  @param string $folderName                                 
	*  @param string $toFile            
	*  @param string $file                           
	*/
	public function makeDirAndCopyFile($folderName, $fromFile, $toFile)
	{
		$dname = $this->folderPath($folderName); 	 
		$this->makeDir($dname);
		$this->copyFile($folderName, $fromFile, $toFile);
	}
	/* 
	*  @public function copy file
	*  @param string $foldername                                 
	*  @param string $fromFile
	*  @param string $toFile
	*/
	public function copyFile($folderName, $fromFile, $toFile)
	{	   
	    $this->fromFile = $fromFile;
	    $this->toFile = $toFile;
		$dname = $this->folderPath($folderName);
		$fname = $this->folderPath($folderName) . DIRECTORY_SEPARATOR . $this->toFile;
	    $this->setCopy($dname, $fname);
	}
	/* 
	*  @public function setCopy
	*  @param string $dname                                 
	*  @param string $fname            
	*/
	public function setCopy($dname, $fname)
	{	   
	    if(is_dir($dname)) {		   
		    chmod($dname, 0777);
	        copy($this->fromFile, $fname);
	    } else {
			$this->makeDir($dname);
	        copy($this->fromFile, $fname);
	    }
	}	
}