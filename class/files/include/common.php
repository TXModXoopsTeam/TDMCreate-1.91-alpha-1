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
 * @version         $Id: include_common.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class IncludeCommon extends TDMCreateFile
{	
	/*
	*  @public function constructor
	*  @param null
	*/
	public function __construct() {    
		$this->tdmcfile = TDMCreateFile::getInstance();
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
	*  @public function write
	*  @param string $module
	*  @param string $filename
	*/
	public function write($module, $filename) {    
		$this->setModule($module);
		$this->setFileName($filename);
	}	
	/*
	*  @public function getCommonCode
	*  @param object $module
	*/
	public function getCommonCode($module) { 
        $module_name = $module->getVar('mod_name');	
		$stu_mn = strtoupper($module_name); 
		$stl_mn = strtolower($module_name);	
		$mod_a_w_name = $module->getVar('mod_author_website_name');
		$mod_a_w_url = $module->getVar('mod_author_website_url');
		$awn = str_replace(" ", "", strtolower($mod_a_w_name));
		
		$ret = <<<EOT
defined('XOOPS_ROOT_PATH') or die('Restricted access');
if (!defined('{$stu_mn}_MODULE_PATH')) {
	define('{$stu_mn}_DIRNAME', '{$stl_mn}');
	define('{$stu_mn}_PATH', XOOPS_ROOT_PATH.'/modules/'.{$stu_mn}_DIRNAME);
	define('{$stu_mn}_URL', XOOPS_URL.'/modules/'.{$stu_mn}_DIRNAME);	
	define('{$stu_mn}_UPLOAD_PATH', XOOPS_UPLOAD_PATH.'/'.{$stu_mn}_DIRNAME);
	define('{$stu_mn}_UPLOAD_URL', XOOPS_UPLOAD_URL.'/'.{$stu_mn}_DIRNAME);
	define('{$stu_mn}_IMAGE_PATH', {$stu_mn}_PATH.'/images');
	define('{$stu_mn}_IMAGE_URL', {$stu_mn}_URL.'/images/');
	define('{$stu_mn}_ADMIN', {$stu_mn}_URL . '/admin/index.php');
	\$local_logo = {$stu_mn}_IMAGE_URL . '/{$awn}_logo.png';
	if(is_dir({$stu_mn}_IMAGE_PATH) && file_exists(\$local_logo)) {
		\$logo = \$local_logo;
	} else {
		\$sysPathIcon32 = \$GLOBALS['xoopsModule']->getInfo('icons32');
		\$logo = \$sysPathIcon32.'/xoopsmicrobutton.gif';
	}
	define('{$stu_mn}_AUTHOR_LOGOIMG', \$logo);
}
// module information
\$copyright = "<a href='{$mod_a_w_url}' title='{$mod_a_w_name}' target='_blank'>
                     <img src='".{$stu_mn}_AUTHOR_LOGOIMG."' alt='{$mod_a_w_name}' /></a>";
					 
include_once XOOPS_ROOT_PATH.'/class/xoopsrequest.php';
include_once {$stu_mn}_PATH.'/class/helper.php';
EOT;
		return $ret;
	}
	/*
	*  @public function render
	*  @param null
	*/
	public function render() {    
		$module = $this->getModule();
		$module_name = $module->getVar('mod_name');
		$filename = $this->getFileName();		
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .= $this->getCommonCode($module);
		$this->tdmcfile->create($module_name, 'include', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}