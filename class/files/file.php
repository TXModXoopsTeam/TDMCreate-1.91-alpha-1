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
 * @version         $Id: file.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

require_once 'tablefields.php';
xoops_load('XoopsFile');
class TDMCreateFile extends TDMCreateTableFields
{	
	/*
	* @var string
	*/
	private $xoopsfile = null;
    
    /**
     * "filename" attribute of the files
     *
     * @var mixed
     */
    private $filename = null;

    /**
     * "path" attribute of the files
     *
     * @var string
     */
    private $path = null;
	
	/**
     * "upload_path" attribute of the files
     *
     * @var string
     */
    private $upload_path = null;

    /**
     * "folder_name" attribute of the files
     *
     * @var string
     */
    private $folder_name = null;		
		
	/*
	* @var string
	*/
	private $content = null;
	
	/*
	* @var mixed
	*/
	private $created = false;
	
	/*
	* @var mixed
	*/
	private $notcreated = false;
	
	/*
	* @var string
	*/
	private $mode = null;
	
	/*
	* @var string
	*/
	protected $tdmcfile = null;		
	
	/*
	*  @public function constructor
	*  @param null
	*/
	public function __construct() {    
		$this->xoopsfile = XoopsFile::getHandler();
		$this->tdmcreate = TDMCreate::getInstance();
	}
	
	/*
	*  @public static function &getInstance
	*  @param null
	*/
	public static function &getInstance() {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
        return $instance;
    }
	
	/*
	*  @public function create
	*  @param string $module_dirname
	*  @param string $subdir
	*  @param string $filename
	*  @param string $content
	*  @param mixed $created
	*  @param mixed $notcreated
	*  @param string $mode
	*/
	public function create($module_dirname, $subdir = null, $filename, $content = '', $created = false, $notcreated = false, $mode = 'w+') 
	{  		
		$this->setFileName($filename);
		$this->created = $created;
		$this->notcreated = $notcreated;		
		$this->setMode($mode);
		$this->setModulePath($module_dirname);
		if(!empty($content) && is_string($content)) {
			$this->setContent($content);
		}	
        if(isset($subdir) && is_string($subdir)) {
			$this->setSubDir($subdir);
		}		
	}
	
	/*
	*  @private function setPath
	*  @param string $folder_name
	*/
	private function setPath($folder_name) {
        $this->path = TDMC_PATH . DIRECTORY_SEPARATOR . $folder_name;
    }
	
	/*
	*  @private function getPath
	*  @param null
	*/
	private function getPath() {
        return $this->path;
    }	
		
	/*
	*  @private function setModulePath
	*  @param string $module_dirname
	*/
	private function setModulePath($module_dirname) {
        $this->upload_path = TDMC_UPLOAD_REPOSITORY_PATH . DIRECTORY_SEPARATOR . $module_dirname;
    }
	
	/*
	*  @private function getModulePath
	*  @param null
	*/
    private function getModulePath() {
        return $this->upload_path;
    }
	
	/*
	*  @private function setSubDir
	*  @param string $subdir
	*/
	private function setSubDir($subdir) {
        $this->subdir = $subdir;
    }
	
	/*
	*  @private function getSubDir
	*  @param null
	*/
	private function getSubDir() {
        return $this->subdir;
    }	
	
	/**
     * public function setFileName
     * @param mixed $file_name
     */
    public function setFileName($filename) {
        $this->filename = $filename;
    }
	
	/*
	*  @public function getFileName
	*  @param null
	*/
    public function getFileName() {
        return $this->filename;
    }
	
	/*
	*  @private function setContent
	*  @param string $content
	*/
	private function setContent($content) {
        $this->content = $content;
    }
	
	/*
	*  @private function setContent
	*  @param null
	*/
	private function getContent() {
        return $this->content;
    }
	
	/*
	*  @private function getFolderName
	*  @param null
	*/
	private function getFolderName() {
        $path = $this->getUploadPath();
		if(strrpos($path, '\\'))  
		{       
			$str = strrpos($path, '\\'); 
			if($str !== false){ 
				return substr($path, $str + 1, strlen($path));
			} else {
				return substr($path, $str, strlen($path));
			} 			
		}
		//return 'root module';		
    }

    /* 
	*  @public function getUploadPath
	*  @param null
	*/
    private function getUploadPath() {		
		if ($this->getSubDir() != null) {
			$ret = $this->getModulePath() . DIRECTORY_SEPARATOR . $this->getSubDir();
		} else {
            $ret = $this->getModulePath();
        } 
        return $ret;
    }
    	
	/*
	*  @private function getCreated
	*  @param null
	*/
	private function getCreated() {
        return $this->created;
    }
	
	/*
	*  @private function getNotCreated
	*  @param null
	*/
	private function getNotCreated() {
        return $this->notcreated;
    }
	
	/*
	*  @private function setMode
	*  @param string $mode
	*/
	private function setMode($mode) {
        $this->mode = $mode;
    }
	
	/*
	*  @private function getMode
	*  @param null
	*/
	private function getMode() {
        return $this->mode;
    }
	
	/*
	*  @public function getLanguage
	*  @param string $module_dirname
	*  @param string $prefix
	*  @param string $postfix
	*/
	public function getLanguage($module_dirname, $prefix = '', $postfix = '') {  
        $lang = '_' . $prefix . '_' . strtoupper($module_dirname);
		if(!empty($postfix) || $postfix != '_') {	
			$ret = $lang . '_' . $postfix;
		} elseif($postfix == '_') {
			$ret = $lang . '_';
		} else {
			$ret = $lang;
		}		
		return $ret;
	}
	
	/*
	*  @public function getHeaderFilesComments
	*  @param string $module
	*  @param string $filename
	*/
	public function getHeaderFilesComments($module, $filename) 
	{				
		$name = $module->getVar('mod_name');
		$dirname = $module->getVar('mod_dirname');
		$version = $module->getVar('mod_version');
		$since = $module->getVar('mod_since');
		$min_xoops = $module->getVar('mod_min_xoops');
		$author = $module->getVar('mod_author');
		$credits = $module->getVar('mod_credits');
		$author_mail = $module->getVar('mod_author_mail');
		$author_website_url = $module->getVar('mod_author_website_url');
		$license = $module->getVar('mod_license');  
		$subversion = $module->getVar('mod_subversion');
		$date = date('D Y/m/d G:i:s');		
		$ret = <<<EOT
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
 * {$name} module for xoops
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         {$license}
 * @package         {$dirname}
 * @since           {$since}
 * @min_xoops       {$min_xoops}
 * @author          {$author} - Email:<{$author_mail}> - Website:<{$author_website_url}>
 * @version         \$Id: {$version} {$filename} {$subversion} {$date}Z {$credits} \$
 */\n
EOT;
		return $ret;
	}
	
	/*
	*  @public function renderFile
	*  @param null
	*/	
	public function renderFile() {		
		$filename = $this->getFileName();
		$path = $this->getUploadPath() . DIRECTORY_SEPARATOR . $filename;		
		$created = $this->getCreated();
		$notcreated = $this->getNotCreated();
		$folder_name = $this->getFolderName();
		$mode = $this->getMode();
		$ret = '';		
		if(!$this->xoopsfile->__construct($path, true)) {
			// Force to create file if not exist
			if($this->xoopsfile->open($mode, true)) {				
				if($this->xoopsfile->writable($path)) {				
					// Integration of the content in the file
					if (!$this->xoopsfile->write($this->getContent(), $mode, true)) {
						$ret .= sprintf($notcreated, $filename, $folder_name);
						$GLOBALS['xoopsTpl']->assign('created', false);
						exit();					
					}					
					// Created
					$ret .= sprintf($created, $filename, $folder_name);
					$GLOBALS['xoopsTpl']->assign('created', true);
					$this->xoopsfile->close();								
				} else {
					$ret .= sprintf($notcreated, $filename, $folder_name);
					$GLOBALS['xoopsTpl']->assign('created', false);
				}				
			} else {
				$ret .= sprintf($notcreated, $filename, $folder_name);
				$GLOBALS['xoopsTpl']->assign('created', false);
			}						
		} 
		return $ret;
	}
}