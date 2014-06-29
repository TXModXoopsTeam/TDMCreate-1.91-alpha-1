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
 * @version         $Id: include_comments.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class IncludeComments extends TDMCreateFile
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
	public function write($module, $table) {    
		$this->setModule($module);
		$this->setTable($table);
	}	
	/*
	*  @public function getCommentsIncludes
	*  @param string $module
	*  @param string $filename
	*/
	public function renderCommentsIncludes($module, $filename) 
	{		
		$module_dirname = $module->getVar('mod_dirname');
		$content = $this->getHeaderFilesComments($module, $filename.'.php');
		$content .= <<<EOT
include_once '../../mainfile.php';
include_once XOOPS_ROOT_PATH.'/include/{$filename}.php';
EOT;
		$this->tdmcfile->create($module_dirname, 'include', $filename.'.php', $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();	
	}
	/*
	*  @public function getCommentsNew
	*  @param string $module
	*  @param string $filename
	*/
	public function renderCommentsNew($module, $filename) 
	{ 			
		$table = $this->getTable();
		$module_dirname = strtolower($module->getVar('mod_dirname'));
		$table_name = $table->getVar('table_name');
		$table_fieldname = $table->getVar('table_fieldname');
		$fpmf = null;
		$fields = $this->getTableFields($table->getVar('table_id'));
		foreach(array_keys($fields) as $f) 
		{
			if($fields[$f]->getVar('field_main') == 1) {
				$fpmf = $fields[$f]->getVar('field_name');
			}			
		}
		$content = $this->getHeaderFilesComments($module, $filename.'.php');
		$content .= <<<EOT
include '../../mainfile.php';
include_once XOOPS_ROOT_PATH.'/modules/{$module_dirname}/class/{$table_name}.php';
\$com_itemid = isset(\$_REQUEST['com_itemid']) ? intval(\$_REQUEST['com_itemid']) : 0;
if (\$com_itemid > 0) {
	\${$table_name}Handler =& xoops_getModuleHandler('{$table_name}', '{$module_dirname}');
	\${$table_name} = \${$table_name}handler->get(\$com_itemid);
	\$com_replytitle = \${$table_name}->getVar('{$fpmf}');
	include XOOPS_ROOT_PATH.'/include/{$filename}.php';
}
EOT;
		$this->tdmcfile->create($module_dirname, 'include', $filename.'.php', $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
	/*
	*  @public function render
	*  @param null
	*/
	/*public function render() {    
		$module = $this->getModule();
		$table = $this->getTable();
		$filename = $this->getFileName();
		$module_dirname = $module->getVar('mod_dirname');
				
		$content = $this->getHeaderFilesComments($module, $filename);
		switch($filename) {
			case 'comment_edit.php':
				$content .= $this->getCommentsIncludes('comment_edit');
				$this->tdmcfile->create($module_dirname, 'include', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
				return $this->tdmcfile->renderFile();
			break;
			case 'comment_delete.php':
				$content .= $this->getCommentsIncludes('comment_delete');
				$this->tdmcfile->create($module_dirname, 'include', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
				return $this->tdmcfile->renderFile();
			break;
			case 'comment_post.php':
				$content .= $this->getCommentsIncludes('comment_post');
				$this->tdmcfile->create($module_dirname, 'include', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
				return $this->tdmcfile->renderFile();
			break;
			case 'comment_reply.php':
				$content .= $this->getCommentsIncludes('comment_reply');
				$this->tdmcfile->create($module_dirname, 'include', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
				return $this->tdmcfile->renderFile();
			break;
			case 'comment_new.php':
				$content .= $this->getCommentsNew($module_dirname, 'comment_new');
				$this->tdmcfile->create($module_dirname, 'include', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
				return $this->tdmcfile->renderFile();				
			break;
		}		
	}*/
}