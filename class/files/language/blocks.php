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
 * @version         $Id: blocks.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class LanguageBlocks extends TDMCreateFile
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
	*  @param mixed $tables
	*  @param string $filename
	*/
	public function write($module, $tables, $filename) {    
		$this->setModule($module);
		$this->setFileName($filename);
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
		$language = $this->getLanguage($module_name, 'MB');
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .= <<<EOT
// Main
define('{$language}DISPLAY', "How Many Tables to Display");
define('{$language}TITLELENGTH', "Title Length");
define('{$language}CATTODISPLAY', "Categories to Display");
define('{$language}ALLCAT', "All Categories");\n
EOT;
		foreach (array_keys($tables) as $t) 
		{
			$table_name = $tables[$t]->getVar('table_name');
			//$table_fieldname = $tables[$t]->getVar('table_fieldname');			
			//$language1 = $language.strtoupper($table_fieldname);	
			$ucf_table_name = ucfirst($table_name);
			$content .= <<<EOT
// {$ucf_table_name}\n
EOT;
			$fields = $this->getTableFields($tables[$t]->getVar('table_id'));
			foreach (array_keys($fields) as $f) 
			{	
				$field_name = $fields[$f]->getVar('field_name');               				
				$lng_fields = $language.strtoupper($field_name);
				$ucf_table_field = ucfirst($table_name.' '.str_replace('_', ' ', $field_name));
				$content .= <<<EOT
define('{$lng_fields}', "{$ucf_table_field}");\n
EOT;
			}	
		}
		$this->tdmcfile->create($module_name, 'language/'.$GLOBALS['xoopsConfig']['language'], $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}