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
 * @version         $Id: comment_functions.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class IncludeCommentFunctions extends TDMCreateFile
{		
	/*
	*  @public function constructor
	*  @param null
	*/
	public function __construct() {    
		$this->tdmcfile = TDMCreateFile::getInstance();
		$this->tdmcreate = TDMCreate::getInstance();
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
	*  @param mixed $table
	*/
	public function write($module, $table, $filename) {    
		$this->setModule($module);
		$this->setTable($table);
		$this->setFileName($filename);
	}	
	/*
	*  @public function renderFile
	*  @param null
	*/
	public function renderFile() 
	{ 			
		$module = $this->getModule();
		$table = $this->getTable();
		$module_dirname = strtolower($module->getVar('mod_dirname'));
		$table_name = $table->getVar('table_name');
		$ucf_module_dirname = ucfirst($module_dirname);
		$ucf_table_name = ucfirst($table_name);
		$filename = $this->getFileName();
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .= <<<EOT
defined('XOOPS_ROOT_PATH') or die('Restricted access');
function {$module_dirname}_com_update(\$itemId, \$itemNumb) {
	\$itemId = intval(\$itemId);
	\$itemNumb = intval(\$itemNumb);
	\$article = new {$ucf_module_dirname}{$ucf_table_name}(\$itemId);
	if (!\$article->updateComments(\$itemNumb)) {
		return false;
	}
	return true;
}

function {$module_dirname}_com_approve(&\$comment){
	// notification mail here
}
EOT;
		$this->tdmcfile->create($module_dirname, 'include', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}	
}