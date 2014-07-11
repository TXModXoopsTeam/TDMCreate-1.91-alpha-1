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
 * @version         $Id: class_files.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');
require_once 'formelements.php';
class ClassFiles extends TDMCreateFormElements
{	
	/*
	* @var string
	*/
	private $formelements = null;	
	
	/*
	*  @public function constructor
	*  @param null
	*/
	public function __construct() {
		parent::__construct();
		$this->tdmcfile = TDMCreateFile::getInstance();
		$this->formelements = TDMCreateFormElements::getInstance();	
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
	*  @param string $table
	*  @param mixed $tables
	*/
	public function write($module, $table, $tables) {    
		$this->setModule($module);
		$this->setTable($table);
		$this->setTables($tables);
	}
	/*
	*  @private function getInitVar
	*  @param string $fieldName
	*  @param string $type
	*/
	private function getInitVar($fieldName, $type = 'INT') {    
		$ret = <<<EOT
		\$this->initVar('{$fieldName}', XOBJ_DTYPE_{$type});\n
EOT;
		return $ret;
	}
	/*
	*  @private function getInitVars
	*  @param array $fields
	*/
	private function getInitVars($fields) {    
		$ret = '';
		// Creation of the initVar functions list
		foreach (array_keys($fields) as $f) 
		{
			$fieldName = $fields[$f]->getVar('field_name');
			$fieldType = $fields[$f]->getVar('field_type');
			switch($fieldType) {
				case 'INT': 
				case 'TINYINT': 
				case 'MEDIUMINT': 
				case 'SMALLINT':
					$ret .= $this->getInitVar($fieldName, 'INT');
				break;
				case 'CHAR': 
				case 'VARCHAR': 				
					$ret .= $this->getInitVar($fieldName, 'TXTBOX');
				break;
				case 'TEXT': 
				case 'TINYTEXT': 
				case 'MEDIUMTEXT': 
				case 'LONGTEXT':
					$ret .= $this->getInitVar($fieldName, 'TXTAREA');
				break;				
				case 'FLOAT': 				
					$ret .= $this->getInitVar($fieldName, 'FLOAT');
				break;
				case 'DECIMAL': 
				case 'DOUBLE': 				
					$ret .= $this->getInitVar($fieldName, 'DECIMAL');
				break;
				case 'ENUM': 				
					$ret .= $this->getInitVar($fieldName, 'ENUM');
				break;
				case 'EMAIL': 				
					$ret .= $this->getInitVar($fieldName, 'EMAIL');
				break;
				case 'URL': 				
					$ret .= $this->getInitVar($fieldName, 'URL');
				break;  
				case 'DATE': 
				case 'DATETIME': 
				case 'TIMESTAMP': 
				case 'TIME':
				case 'YEAR':
					$ret .= $this->getInitVar($fieldName, 'LTIME');
				break;
			}
		}
		return $ret;
	}
	/*
	*  @private function getHeadClass
	*  @param string $moduleDirname
	*  @param string $tableName
	*  @param array $fields
	*/
	private function getHeadClass($moduleDirname, $tableName, $fields) {    
		$ucfModuleDirname = ucfirst($moduleDirname);
		$ucfTableName = ucfirst($tableName);	
		$ret = <<<EOT
defined('XOOPS_ROOT_PATH') or die("Restricted access");
/*
 * Class Object {$ucfModuleDirname}{$ucfTableName}
 */
class {$ucfModuleDirname}{$ucfTableName} extends XoopsObject
{ 
	/*
	* @var mixed
	*/
	private \${$moduleDirname} = null;
	/*
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
		\$this->{$moduleDirname} = {$ucfModuleDirname}Helper::getInstance();
{$this->getInitVars($fields)}\t}
	/*
	*  @static function &getInstance
	*  @param null
	*/
	public static function &getInstance()
    {
        static \$instance = false;
        if (!\$instance) {
            \$instance = new self();
        }
        return \$instance;
    }\n
EOT;
		return $ret;
	}
	
	/*
	*  @private function getHeadFunctionForm
	*  @param string $module
	*  @param string $table
	*/
	private function getHeadFunctionForm($module, $table) 
	{    
		$moduleDirname = $module->getVar('mod_dirname');
		$tableName = $table->getVar('table_name');
		$ucfTableName = ucfirst($tableName);
		$stuTableName = strtoupper($tableName);
		$language = $this->getLanguage($moduleDirname, 'AM');		
		$this->formelements->initForm($module, $table);
		$ret = <<<EOT
	/*
	 * Get form
	 *
	 * @param mixed \$action
	 */
	public function getForm(\$action = false)
	{	
		if (\$action === false) {
			\$action = \$_SERVER['REQUEST_URI'];
		}
		// Title
		\$title = \$this->isNew() ? sprintf({$language}{$stuTableName}_ADD) : sprintf({$language}{$stuTableName}_EDIT);
		// Get Theme Form
		xoops_load('XoopsFormLoader');
		\$form = new XoopsThemeForm(\$title, 'form', \$action, 'post', true);
		\$form->setExtra('enctype="multipart/form-data"');
		// {$ucfTableName} handler
		\${$tableName}Handler =& \$this->{$moduleDirname}->getHandler('{$tableName}');
{$this->formelements->renderElements()}
EOT;
		return $ret;
	}
	/*
	*  @private function getPermissionsInFunctionForm
	*  @param string $moduleDirname
	*  @param string $fpif
	*/
	private function getPermissionsInFunctionForm($moduleDirname, $fpif) {    
		$permissionApprove = $this->getLanguage($moduleDirname, 'AM', 'PERMISSIONS_APPROVE');
		$permissionSubmit = $this->getLanguage($moduleDirname, 'AM', 'PERMISSIONS_SUBMIT');
		$permissionView = $this->getLanguage($moduleDirname, 'AM', 'PERMISSIONS_VIEW');
		$ret = <<<EOT
		// Permissions
		\$member_handler = & xoops_gethandler ( 'member' );
		\$group_list = &\$member_handler->getGroupList();
		\$gperm_handler = &xoops_gethandler ( 'groupperm' );
		\$full_list = array_keys ( \$group_list );
		global \$xoopsModule;
		if ( !\$this->isNew() ) {
			\$groups_ids_approve = \$gperm_handler->getGroupIds ( '{$moduleDirname}_approve', \$this->getVar ( '{$fpif}' ), \$xoopsModule->getVar ( 'mid' ) );
			\$groups_ids_submit = \$gperm_handler->getGroupIds ( '{$moduleDirname}_submit', \$this->getVar ( '{$fpif}' ), \$xoopsModule->getVar ( 'mid' ) );
			\$groups_ids_view = \$gperm_handler->getGroupIds ( '{$moduleDirname}_view', \$this->getVar ( '{$fpif}' ), \$xoopsModule->getVar ( 'mid' ) );
			\$groups_ids_approve = array_values ( \$groups_ids_approve );
			\$groups_can_approve_checkbox = new XoopsFormCheckBox ( {$permissionApprove}, 'groups_approve[]', \$groups_ids_approve );
			\$groups_ids_submit = array_values ( \$groups_ids_submit );
			\$groups_can_submit_checkbox = new XoopsFormCheckBox ( {$permissionSubmit}, 'groups_submit[]', \$groups_ids_submit );	
			\$groups_ids_view = array_values ( \$groups_ids_view );
			\$groups_can_view_checkbox = new XoopsFormCheckBox ( {$permissionView}, 'groups_view[]', \$groups_ids_view );			
		} else {
			\$groups_can_approve_checkbox = new XoopsFormCheckBox ( {$permissionApprove}, 'groups_approve[]', \$full_list );
			\$groups_can_submit_checkbox = new XoopsFormCheckBox ( {$permissionSubmit}, 'groups_submit[]', \$full_list );		
			\$groups_can_view_checkbox = new XoopsFormCheckBox ( {$permissionView}, 'groups_view[]', \$full_list );
		}		
		// For approve
		\$groups_can_approve_checkbox->addOptionArray ( \$group_list );
		\$form->addElement ( \$groups_can_approve_checkbox );
		// For submit
		\$groups_can_submit_checkbox->addOptionArray ( \$group_list );
		\$form->addElement ( \$groups_can_submit_checkbox );		
		// For view
		\$groups_can_view_checkbox->addOptionArray ( \$group_list );
		\$form->addElement ( \$groups_can_view_checkbox );\n
EOT;
		return $ret;
	}
	/*
	*  @public function getFootFunctionForm
	*  @param null
	*/
	private function getFootFunctionForm() {    
		$ret = <<<EOT
		// Send
		\$form->addElement(new XoopsFormHidden('op', 'save'));
		\$form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
		return \$form;
	}
}\n\n
EOT;
		return $ret;
	}
	/*
	*  @public function getClassHandler
	*  @param string $moduleDirname
	*  @param string $tableName
	*  @param string $fpif
	*  @param string $fpmf
	*/
	private function getClassHandler($moduleDirname, $tableName, $fpif, $fpmf) {		
		$ucfModuleDirname = ucfirst($moduleDirname);
        $ucfTableName = ucfirst($tableName);
        $ucfModuleTable = $ucfModuleDirname . $ucfTableName;		
		$ret = <<<EOT
/*
 * Class Object Handler {$ucfModuleDirname}{$ucfTableName}
 */
class {$ucfModuleTable}Handler extends XoopsPersistableObjectHandler 
{
	/*
	 * Constructor
	 *
	 * @param string \$db
	 */
	public function __construct(&\$db) 
	{
		parent::__construct(\$db, '{$moduleDirname}_{$tableName}', '{$moduleDirname}{$tableName}', '{$fpif}', '{$fpmf}');
	}
}
EOT;
		return $ret;
	}
	/*
	*  @public function renderFile
	*  @param string $filename
	*/
	public function renderFile($filename) {    
		$module = $this->getModule();
		$table = $this->getTable();
		$tableName = $table->getVar('table_name');
		$moduleDirname = $module->getVar('mod_dirname');		
		$fields = $this->getTableFields($table->getVar('table_id'));
		foreach(array_keys($fields) as $f) 
		{	
			$fieldName = $fields[$f]->getVar('field_name');
			if(($f == 0) && ($table->getVar('table_autoincrement') == 1)) {
				$fpif = $fieldName;
			}
			if($fields[$f]->getVar('field_main') == 1) {
				$fpmf = $fieldName;
			}			
		}				
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .= $this->getHeadClass($moduleDirname, $tableName, $fields);
		$content .= $this->getHeadFunctionForm($module, $table);
		if ($table->getVar('table_permissions') == 1) {
			$content .= $this->getPermissionsInFunctionForm($moduleDirname, $fpif);
		}
		$content .= $this->getFootFunctionForm();
		$content .= $this->getClassHandler($moduleDirname, $tableName, $fpif, $fpmf);
		
		$this->tdmcfile->create($moduleDirname, 'class', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}