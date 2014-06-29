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
 * @version         $Id: include_search.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class LanguageMain extends TDMCreateFile
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
	*  @param mixed $table
	*  @param mixed $tables
	*  @param string $filename
	*/
	public function write($module, $table, $tables, $filename) {    
		$this->setModule($module);
		$this->setFileName($filename);
		$this->setTable($table);
		$this->setTables($tables);
	}
	/*
	*  @public function render
	*  @param null
	*/
	public function render() {    
		$module = $this->getModule();
		$tables = $this->getTables();
		$filename = $this->getFileName();
		$module_name = $module->getVar('mod_name');
		$module_dirname = $module->getVar('mod_dirname');
		$module_description = $module->getVar('mod_description');        
		$ucf_mod_name = ucfirst($module_name);
		$language = $this->getLanguage($module_dirname, 'MA');
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .= <<<EOT
// ---------------- Main ----------------
define('{$language}INDEX', "Home");
define('{$language}TITLE', "{$ucf_mod_name}");
define('{$language}DESC', "{$module_description}");
define('{$language}INDEX_DESC', "Welcome to the homepage of your new module!<br /> 
As you can see, you've created a page with a list of links at the top to navigate between the pages of your module. This description is only visible on the homepage of this module, the other pages you will see the content you created when you built this module with the module TDMCreate. In order to expand this module with other resources, just add the code you need to extend the functionality of the same. The files are grouped by type, from the header to the footer to see how divided the source code.");\n
EOT;
		foreach (array_keys($tables) as $i) 
		{
			$table_name = $tables[$i]->getVar('table_name');
			$table_fieldname = $tables[$i]->getVar('table_fieldname');			
			$lng_stu_table_name = $language.strtoupper($table_name);
			$ucf_table_name = UcFirstAndToLower($table_name);
			$content .= <<<EOT
// {$ucf_table_name}
define('{$lng_stu_table_name}', "{$ucf_table_name}");
define('{$lng_stu_table_name}_DESC', "{$ucf_table_name} description");
// Caption of {$ucf_table_name}\n
EOT;
			$fields = $this->getTableFields($tables[$i]->getVar('table_id'));
			foreach (array_keys($fields) as $f) 
			{	
				$field_name = $fields[$f]->getVar('field_name');                
				$lng_stu_fields = $language.strtoupper($field_name);
				$ucf_field_name = ucfirst(str_replace('_', ' ', $field_name));
				$content .= <<<EOT
define('{$lng_stu_fields}', "{$ucf_field_name}");\n
EOT;
			}	
		}
		$content .= <<<EOT
// Admin link
define('{$language}ADMIN', "Admin");
// ---------------- ----------------
EOT;
		$this->tdmcfile->create($module_dirname, 'language/'.$GLOBALS['xoopsConfig']['language'], $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}