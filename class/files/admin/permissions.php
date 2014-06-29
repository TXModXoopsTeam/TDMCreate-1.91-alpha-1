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
 * @version         $Id: admin_permissions.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class AdminPermissions extends TDMCreateFile
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
		$this->setTables($tables);
		$this->setFileName($filename);
	}
	/*
	*  @private function getPermissionsCodeHeader
	*  @param string $module_dirname
	*  @param string $language
	*/
	private function getPermissionsCodeHeader($module_dirname, $language) 
	{        
		$ret = <<<PRM
\ninclude_once 'header.php';
include_once XOOPS_ROOT_PATH.'/class/xoopsform/grouppermform.php';
if( !empty(\$_POST['submit']) ) 
{
	redirect_header( XOOPS_URL.'/modules/'.\$xoopsModule->dirname().'/admin/permissions.php', 1, _MP_GPERMUPDATED );
}
// Check admin have access to this page
/*\$group = \$xoopsUser->getGroups ();
\$groups = xoops_getModuleOption ( 'admin_groups', \$thisDirname );
if (count ( array_intersect ( \$group, \$groups ) ) <= 0) {
	redirect_header ( 'index.php', 3, _NOPERM );
}*/
\$template_main = '{$module_dirname}_admin_permissions.tpl';
echo \$adminMenu->addNavigation('permissions.php');

\$permission = {$module_dirname}_CleanVars(\$_REQUEST, 'permission', 1, 'int');
\$selected = array('', '', '', '');
\$selected[\$permission-1] = ' selected';
xoops_load('XoopsFormLoader');
\$permTableForm = new XoopsSimpleForm('', 'fselperm', 'permissions.php', 'get'); 
\$formSelect = new XoopsFormSelect('', 'permission', \$permission);
\$formSelect->setExtra('onchange="document.forms.fselperm.submit()"');
\$formSelect->addOption(\$selected[0], {$language}GLOBAL);
\$formSelect->addOption(\$selected[1], {$language}APPROVE);
\$formSelect->addOption(\$selected[2], {$language}SUBMIT);
\$formSelect->addOption(\$selected[3], {$language}VIEW);
\$permTableForm->addElement(\$formSelect);	
\$permTableForm->display();\n\n
PRM;
		return $ret;
	}
	
	/*
	*  @private function getPermissionsCodeSwitch
	*  @param string $module_dirname
	*  @param string $language
	*/
	private function getPermissionsCodeSwitch($module_dirname, $language) 
	{        
		$ret = <<<PRM
\$module_id = \$xoopsModule->getVar('mid');
switch(\$permission)
{
	case 1:
        \$formTitle = {$language}GLOBAL;
        \$permName = '{$module_dirname}_ac';
        \$permDesc = {$language}GLOBAL_DESC;
        \$globalPerms = array(	'4' => {$language}GLOBAL_4,
								'8' => {$language}GLOBAL_8,
								'16' => {$language}GLOBAL_16 );
		break;
	case 2:
		\$formTitle = {$language}APPROVE;
		\$permName = '{$module_dirname}_access';
		\$permDesc = {$language}APPROVE_DESC;
		break;
	case 3:
		\$formTitle = {$language}SUBMIT;
		\$permName = '{$module_dirname}_submit';
		\$permDesc = {$language}SUBMIT_DESC;
		break;
	case 4:
		\$formTitle = {$language}VIEW;
		\$permName = '{$module_dirname}_view';
		\$permDesc = {$language}VIEW_DESC;
		break;
}\n
PRM;
		return $ret;
	}
	
	/*
	*  @private function getPermissionsCodeBody
	*  @param string $module_dirname
	*  @param string $table_name
	*  @param string $language
	*/
	private function getPermissionsCodeBody($module_dirname, $language) 
	{    
		$tables = $this->getTables();
		foreach(array_keys($tables) as $t) 
		{
			$table_id = $tables[$t]->getVar('table_id');
			if($tables[$t]->getVar('table_permissions') == 1) {
				$table_name = $tables[$t]->getVar('table_name');
			}			
		}
		$fields = $this->getTableFields($table_id);		
		foreach(array_keys($fields) as $f)
		{
			if($f == 0) {
				$fpif = $fields[$f]->getVar('field_name');
			}
			if($fields[$f]->getVar('field_main') == 1) {
				$fpmf = $fields[$f]->getVar('field_name');
			}
		}
		$ret = <<<PRM
\$permform = new XoopsGroupPermForm(\$formTitle, \$module_id, \$permName, \$permDesc, 'admin/permissions.php');
if (\$permission == 1) {
    foreach (\$globalPerms as \$perm_id => \$perm_name) {
        \$permform->addItem(\$perm_id, \$perm_name);		
    }
	echo \$permform->render();
	echo '<br /><br />';
} else {
    \$criteria = new CriteriaCompo();
	\$criteria->setSort('{$fpmf}');
	\$criteria->setOrder('ASC');
	\${$table_name}_count = \${$table_name}Handler->getCount(\$criteria);
	\${$table_name}_arr = \${$table_name}Handler->getObjects(\$criteria);
	unset(\$criteria);
    foreach (array_keys(\${$table_name}_arr) as \$i) {		
		\$permform->addItem(\${$table_name}_arr[\$i]->getVar('{$fpif}'), \${$table_name}_arr[\$i]->getVar('{$fpmf}'));		
	} 
	// Check if {$table_name} exist before rendering the form and redirect, if there aren't {$table_name}   
	if (\${$table_name}_count > 0) {		
		echo \$permform->render();
		echo '<br /><br />';
	} else {
		redirect_header ( '{$table_name}.php?op=new', 3, {$language}NOPERMSSET );
		exit ();
	}\n     
PRM;
		return $ret;
	}
	
	/*
	*  @private function getPermissionsCodeFooter
	*  @param null
	*/
	private function getPermissionsCodeFooter() {         
		$ret = <<<PRM
}
unset(\$permform);
include_once 'footer.php';
PRM;
		return $ret;
	}
	
	/*
	*  @public function render
	*  @param null
	*/
	public function render() {    
        $module = $this->getModule();
		$filename = $this->getFileName();
		$module_dirname = strtolower($module->getVar('mod_dirname'));	
		$language = $this->getLanguage($module_dirname, 'AM');
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .= $this->getPermissionsCodeHeader($module_dirname, $language);
		$content .= $this->getPermissionsCodeSwitch($module_dirname, $language);
		$content .= $this->getPermissionsCodeBody($module_dirname, $language);
		$content .= $this->getPermissionsCodeFooter();
		//
		$this->tdmcfile->create($module_dirname, 'admin', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}