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
	private $xoopsfile = null;
	/*
	* @var string
	*/
	private $module_name = null;
	/*
	* @var string
	*/  
	protected $folder_name = null;
	/*
	* @var string
	*/
	private $file_name = null;
	/*
	* @var string
	*/ 
	private $path = null;
	/*
	* @var string
	*/
	private $from_file = null;
	/*
	* @var string
	*/
	private $to_file = null;
	/*
	*  @public function constructor class
	*  @param string $path
	*/
	public function __construct() {    
		$this->xoopsfile = XoopsFile::getInstance();
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
	*  @param string $folder_name  
    *  @param string $file_name	
	*/
	public function folderPath($folder_name, $file_name = null)
	{		
		$this->folder_name = $folder_name;
		if( $file_name != null ) {
			$this->file_name = $file_name; 
			$ret = $this->path . DIRECTORY_SEPARATOR . $this->module_name . DIRECTORY_SEPARATOR . $this->folder_name . DIRECTORY_SEPARATOR . $this->file_name;
		} else {
			$ret = $this->path . DIRECTORY_SEPARATOR . $this->module_name . DIRECTORY_SEPARATOR . $this->folder_name;
		}
		return $ret; 	   
	}
	/* 
	*  @public function makeDirInModule
	*  @param string $folder_name                                 
	*/
	public function makeDirInModule($folder_name)
	{ 		   
		$fname = $this->folderPath($folder_name); 	   
		$this->makeDir($fname);
	}
	/* 
	*  @public function makeDir & copy file
	*  @param string $folder_name                                 
	*  @param string $to_file            
	*  @param string $file                           
	*/
	public function makeDirAndCopyFile($folder_name, $from_file, $to_file)
	{
		$dname = $this->folderPath($folder_name); 	 
		$this->makeDir($dname);
		$this->copyFile($folder_name, $from_file, $to_file);
	}
	/* 
	*  @public function copy file
	*  @param string $foldername                                 
	*  @param string $from_file
	*  @param string $to_file
	*/
	public function copyFile($folder_name, $from_file, $to_file)
	{	   
	    $this->from_file = $from_file;
	    $this->to_file = $to_file;
		$dname = $this->folderPath($folder_name);
		$fname = $this->folderPath($folder_name) . DIRECTORY_SEPARATOR . $this->to_file;
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
	        copy($this->from_file, $fname);
	    } else {
			$this->makeDir($dname);
	        copy($this->from_file, $fname);
	    }
	}	
}