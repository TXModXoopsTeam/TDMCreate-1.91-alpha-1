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
 * @version         $Id: include_notifications.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class IncludeNotifications extends TDMCreateFile
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
	*  @param string $filename
	*/
	public function write($module, $table, $filename) {    
		$this->setModule($module);
		$this->setFileName($filename);
		$this->setTable($table);
	}
	/*
	*  @static function getNotificationsFunction
	*  @param string $module_dirname
	*/
	public function getNotificationsFunction($module_dirname)
    {
        $table = $this->getTable();
		$table_name = $table->getVar('table_name');
		$table_fieldname = $table->getVar('table_fieldname');
		$fpif = null; $fpmf = null;
		$fields = $this->getTableFields($table->getVar('table_id'));
		foreach(array_keys($fields) as $i) {
			$field_name = $fields[$i]->getVar('field_name');
			if(($i == 1) && ($table->getVar('table_autoincrement') == 1)) {
				$fpif = $field_name;
			}
			if($fields[$i]->getVar('field_main') == 1) {
				$fpmf = $field_name;
			}			
		}

		$ret = <<<EOT
\n// comment callback functions
function {$module_dirname}_notify_iteminfo(\$category, \$item_id)
{
	global \$xoopsModule, \$xoopsModuleConfig, \$xoopsConfig;

	if (empty(\$xoopsModule) || \$xoopsModule->getVar('dirname') != '{$module_dirname}')
	{
		\$module_handler =& xoops_gethandler('module');
		\$module =& \$module_handler->getByDirname('{$module_dirname}');
		\$config_handler =& xoops_gethandler('config');
		\$config =& \$config_handler->getConfigsByCat(0, \$module->getVar('mid'));
	} else {
		\$module =& \$xoopsModule;
		\$config =& \$xoopsModuleConfig;
	}

	xoops_loadLanguage('main', '{$module_dirname}');

	if (\$category=='global')
	{
		\$item['name'] = '';
		\$item['url'] = '';
		return \$item;
	}

	global \$xoopsDB;
	if (\$category=='category')
	{
		// Assume we have a valid category id
		\$sql = 'SELECT {$fpmf} FROM ' . \$xoopsDB->prefix('mod_{$module_dirname}_{$table_name}') . ' WHERE {$field_name} = '. \$item_id;
		\$result = \$xoopsDB->query(\$sql); // TODO: error check
		\$result_array = \$xoopsDB->fetchArray(\$result);
		\$item['name'] = \$result_array['{$fpmf}'];
		\$item['url'] = XOOPS_URL . '/modules/' . \$module->getVar('dirname') . '/{$table_name}.php?{$field_name}=' . \$item_id;
		return \$item;
	}

	if (\$category=='{$table_fieldname}')
	{
		// Assume we have a valid link id
		\$sql = 'SELECT {$field_name}, {$fpmf} FROM '.\$xoopsDB->prefix('mod_{$module_dirname}_{$table_name}') . ' WHERE {$fpif} = ' . \$item_id;
		\$result = \$xoopsDB->query(\$sql); // TODO: error check
		\$result_array = \$xoopsDB->fetchArray(\$result);
		\$item['name'] = \$result_array['title'];
		\$item['url'] = XOOPS_URL . '/modules/' . \$module->getVar('dirname') . '/{$table_name}.php?{$field_name}=' . \$result_array['{$field_name}'] . '&amp;{$fpif}=' . \$item_id;
		return \$item;
	}
}
EOT;
        return $ret;
    }
	
	/*
	*  @public function render
	*  @param null
	*/
	public function render() {    
		$module = $this->getModule();
		$filename = $this->getFileName();
		$module_dirname = $module->getVar('mod_dirname');        		
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .= $this->getNotificationsFunction($module_dirname);
		//
		$this->tdmcfile->create($module_dirname, 'include', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}