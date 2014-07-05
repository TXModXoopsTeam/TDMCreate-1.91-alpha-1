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
 * @version         $Id: admin.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class LanguageAdmin extends TDMCreateFile
{	
	/*
	*  @public function constructor
	*  @param null
	*/
	public function __construct() { 
		parent::__construct();
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
	*  @param string $tables
	*  @param string $filename
	*/
	public function write($module, $tables, $filename) {    
		$this->setModule($module);
		$this->setTables($tables);
		$this->setFileName($filename);		
	}
    /*
	*  @public function getLanguageAdminIndex
	*  @param string $language
	*  @param string $tables
	*/
	public function getLanguageAdminIndex($language, $tables) 
	{    
		$ret = <<<EOT
// ---------------- Admin Index ----------------
define('{$language}STATISTICS', "Statistics");
// There are\n
EOT;
		foreach (array_keys($tables) as $t)
		{
			$tableName = $tables[$t]->getVar('table_name');
			$stu_table_name = strtoupper($tableName);
			$stl_table_name = strtolower($tableName);
			$ret .= <<<EOT
define('{$language}THEREARE_{$stu_table_name}', "There are <span class='bold'>%s</span> {$stl_table_name} in the database");\n
EOT;
		}		
		return $ret;
	}
	/*
	*  @public function getLanguageAdminPages
	*  @param string $language
	*  @param string $tables
	*/
	public function getLanguageAdminPages($language, $tables) 
	{ 		
		$ret = <<<EOT
// ---------------- Admin Files ----------------
// There aren't\n
EOT;
		foreach (array_keys($tables) as $t)
		{
			$tableName = $tables[$t]->getVar('table_name');			
			$stu_table_name = strtoupper($tableName);
			$stl_table_name = strtolower($tableName);
			$ret .= <<<EOT
define('{$language}THEREARENT_{$stu_table_name}', "There aren't {$stl_table_name}");\n
EOT;
		}
		$ret .= <<<EOT
// Save/Delete
define('{$language}FORMOK', "Successfully saved");
define('{$language}FORMDELOK', "Successfully deleted");
define('{$language}FORMSUREDEL', "Are you sure to delete: <b><span style='color : Red'>%s </span></b>");
define('{$language}FORMSURERENEW', "Are you sure to update: <b><span style='color : Red'>%s </span></b>");\n
EOT;
		$ret .= <<<EOT
// Buttons\n
EOT;
		foreach (array_keys($tables) as $t)
		{
			$tableName = $tables[$t]->getVar('table_name');
			$tableFieldname = $tables[$t]->getVar('table_fieldname');
			$stu_table_fieldname = strtoupper($tableFieldname);
            $ucf_table_fieldname = ucfirst($tableFieldname);			
			$ret .= <<<EOT
define('{$language}ADD_{$stu_table_fieldname}', "Add {$ucf_table_fieldname}");\n
EOT;
		}
		$ret .= <<<EOT
// Lists\n
EOT;
		foreach (array_keys($tables) as $t)
		{
			$tableName = $tables[$t]->getVar('table_name');
			$tableFieldname = $tables[$t]->getVar('table_fieldname');
			$stu_table_name = strtoupper($tableName);
            $ucf_table_name = ucfirst($tableName);			
			$ret .= <<<EOT
define('{$language}{$stu_table_name}_LIST', "List of {$ucf_table_name}");\n
EOT;
		}
		return $ret;
	}
    /*
	*  @public function getLanguageAdminClass
	*  @param string $language
	*  @param string $tables
	*/
	public function getLanguageAdminClass($language, $tables) 
	{    
		$ret = <<<EOT
// ---------------- Admin Classes ----------------\n
EOT;
		foreach (array_keys($tables) as $t)
		{
			$tableId = $tables[$t]->getVar('table_id');
			$tableName = $tables[$t]->getVar('table_name');
			$stu_table_name = strtoupper($tableName);
            $ucf_table_name = ucfirst($tableName);			
			$ret .= <<<EOT
// {$ucf_table_name} add/edit
define('{$language}{$stu_table_name}_ADD', "Add {$tableName}");
define('{$language}{$stu_table_name}_EDIT', "Edit {$tableName}");
// Elements of {$ucf_table_name}\n
EOT;
			$fields = $this->getTableFields($tableId);
			foreach(array_keys($fields) as $f) 
			{	
				$fieldName = $fields[$f]->getVar('field_name');
				$fieldElement = $fields[$f]->getVar('field_element');
				$stu_field_name = strtoupper($fieldName);
				$fieldNameDesc = ucfirst(str_replace('_', ' ', $fieldName));
				$ret .= <<<EOT
define('{$language}{$stu_field_name}', "{$fieldNameDesc}");\n
EOT;
				switch($fieldElement)
				{
					case 9:
						$ret .= <<<EOT
define('{$language}FORM_UPLOAD_IMAGE_LIST', "{$fieldNameDesc} in list");\n
EOT;
					break;
					case 10:
						$ret .= <<<EOT
define('{$language}FORM_UPLOAD_IMAGE', "{$fieldNameDesc} in upload");\n
EOT;
					break;
					case 11:
						$ret .= <<<EOT
define('{$language}FORM_UPLOAD_FILE', "{$fieldNameDesc} in upload");\n
EOT;
					break;
				}
			}
		}
		$ret .= <<<EOT
// General
define('{$language}FORMUPLOAD', "Upload file");
define('{$language}FORMIMAGE_PATH', "Files in %s ");
define('{$language}FORMACTION', "Action");
define('{$language}FORMEDIT', "Modification");
define('{$language}FORMDEL', "Clear");\n
EOT;
		$ret .= <<<EOT
// Permissions
define('{$language}PERMISSIONS_APPROVE', "Permissions to approve");
define('{$language}PERMISSIONS_SUBMIT', "Permissions to submit");
define('{$language}PERMISSIONS_VIEW', "Permissions to view");\n
EOT;
		return $ret;
	}
	/*
	*  @public function getLanguageAdminPermissions
	*  @param string $language
	*/
	public function getLanguageAdminPermissions($language) 
	{    
		$ret = <<<EOT
// ---------------- Admin Permissions ----------------
// Permissions
define('{$language}GLOBAL', "Permissions global");
define('{$language}GLOBAL_DESC', "Permissions global");
define('{$language}GLOBAL_4', "Permissions global");
define('{$language}GLOBAL_8', "Permissions global");
define('{$language}GLOBAL_16', "Permissions global");
define('{$language}APPROVE', "Permissions to approve");
define('{$language}APPROVE_DESC', "Permissions to approve");
define('{$language}SUBMIT', "Permissions to submit");
define('{$language}SUBMIT_DESC', "Permissions to submit");
define('{$language}VIEW', "Permissions to view");
define('{$language}VIEW_DESC', "Permissions to view");
define('{$language}NOPERMSSET', "No permission set");\n
EOT;
		return $ret;
	}
	/*
	*  @public function getLanguageAdminFoot
	*  @param null
	*/
	public function getLanguageAdminFoot($language) 
	{    
		$ret = <<<EOT
// ---------------- Admin Others ----------------
define('{$language}MAINTAINEDBY', " is maintained by ");
// ---------------- ----------------
EOT;
		return $ret;
	}
	/*
	*  @public function render
	*  @param null
	*/
	public function render() {    
		$module = $this->getModule();
		$tables = $this->getTables();        		
		$filename = $this->getFileName();
		$moduleDirname = $module->getVar('mod_dirname');		
		$language = $this->getLanguage($moduleDirname, 'AM');
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .= $this->getLanguageAdminIndex($language, $tables);
		$content .= $this->getLanguageAdminPages($language, $tables);
		$content .= $this->getLanguageAdminClass($language, $tables);
		$content .= $this->getLanguageAdminPermissions($language);
		$content .= $this->getLanguageAdminFoot($language);
		//
		$this->tdmcfile->create($moduleDirname, 'language/'.$GLOBALS['xoopsConfig']['language'], $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}