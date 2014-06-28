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
 * @version         $Id: admin_index.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class AdminIndex extends TDMCreateFile
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
	*  @param mixed $tables
	*  @param string $filename
	*/
	public function write($module, $tables, $filename) {    
		$this->setModule($module);
		$this->setTables($tables);
		$this->setFileName($filename);		
	}
	/*
	*  @public function render
	*  @param null
	*/
	public function render() {    
		$module = $this->getModule();
		$tables = $this->getTables();
		$filename = $this->getFileName();        
		$module_name = strtolower($module->getVar('mod_name'));
		$language = $this->getLanguage($module_name, 'AM');
		$language_thereare = $this->getLanguage($module_name, 'AM', 'THEREARE_');
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .= <<<EOT
include_once 'header.php';\n
EOT;
		foreach (array_keys($tables) as $i)
		{
			$table_name = $tables[$i]->getVar('table_name');
			$content .= <<<EOT
//count "{$table_name}"
\$count_{$table_name} = \${$table_name}Handler->getCount();\n
EOT;
		}
		$content .= <<<EOT
// Template Index
\$template_main = '{$module_name}_index.tpl';
// InfoBox Statistics
\$adminMenu->addInfoBox({$language}STATISTICS);
// InfoBox\n
EOT;
		foreach (array_keys($tables) as $i)
		{
			$table_name = $tables[$i]->getVar('table_name');
			$ta_stutable_name = $language_thereare.strtoupper($table_name);
			$content .= <<<EOT
\$adminMenu->addInfoBoxLine({$language}STATISTICS, '<label>'.{$ta_stutable_name}.'</label>', \$count_{$table_name});\n
EOT;
		}
		$content .= <<<EOT
// Render Index
echo \$adminMenu->addNavigation('index.php');
echo \$adminMenu->renderIndex();
include_once 'footer.php';
EOT;
		$this->tdmcfile->create($module_name, 'admin', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}