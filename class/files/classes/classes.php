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
	*  @public function getInitVar
	*  @param string $field_name
	*  @param string $type
	*/
	public function getInitVar($field_name, $type = 'INT') {    
		$ret = <<<EOT
		\$this->initVar('{$field_name}', XOBJ_DTYPE_{$type});\n
EOT;
		return $ret;
	}
	/*
	*  @public function getInitVars
	*  @param array $fields
	*/
	public function getInitVars($fields) {    
		$ret = '';
		// Creation of the initVar functions list
		foreach (array_keys($fields) as $f) 
		{
			$field_name = $fields[$f]->getVar('field_name');
			$field_type = $fields[$f]->getVar('field_type');
			switch($field_type) {
				case 'INT': 
				case 'TINYINT': 
				case 'MEDIUMINT': 
				case 'SMALLINT':
					$ret .= $this->getInitVar($field_name, 'INT');
				break;
				case 'CHAR': 
				case 'VARCHAR': 				
					$ret .= $this->getInitVar($field_name, 'TXTBOX');
				break;
				case 'TEXT': 
				case 'TINYTEXT': 
				case 'MEDIUMTEXT': 
				case 'LONGTEXT':
					$ret .= $this->getInitVar($field_name, 'TXTAREA');
				break;				
				case 'FLOAT': 				
					$ret .= $this->getInitVar($field_name, 'FLOAT');
				break;
				case 'DECIMAL': 
				case 'DOUBLE': 				
					$ret .= $this->getInitVar($field_name, 'DECIMAL');
				break;
				case 'ENUM': 				
					$ret .= $this->getInitVar($field_name, 'ENUM');
				break;
				case 'EMAIL': 				
					$ret .= $this->getInitVar($field_name, 'EMAIL');
				break;
				case 'URL': 				
					$ret .= $this->getInitVar($field_name, 'URL');
				break;  
				case 'DATE': 
				case 'DATETIME': 
				case 'TIMESTAMP': 
				case 'TIME':
				case 'YEAR':
					$ret .= $this->getInitVar($field_name, 'LTIME');
				break;
			}
		}
		return $ret;
	}
	/*
	*  @public function getHeadClass
	*  @param string $module_name
	*  @param string $table_name
	*  @param array $fields
	*/
	public function getHeadClass($module_name, $table_name, $fields) {    
		$ucf_module_name = ucfirst($module_name);
		$ucf_table_name = ucfirst($table_name);		
		$ret = <<<EOT
defined('XOOPS_ROOT_PATH') or die("Restricted access");
/*
 * Class Object {$ucf_module_name}{$ucf_table_name}
 */
class {$ucf_module_name}{$ucf_table_name} extends XoopsObject
{ 
	/*
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
		\$this->XoopsObject();
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
	*  @public function getHeadFunctionForm
	*  @param string $module
	*  @param string $table
	*/
	public function getHeadFunctionForm($module, $table) 
	{    
		$module_name = strtolower($module->getVar('mod_name'));
		$language = $this->getLanguage($module_name, 'AM');		
		$stu_table_name = strtoupper($table->getVar('table_name'));
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
	
		\$title = \$this->isNew() ? sprintf({$language}{$stu_table_name}_ADD) : sprintf({$language}{$stu_table_name}_EDIT);

		xoops_load('XoopsFormLoader');
		\$form = new XoopsThemeForm(\$title, 'form', \$action, 'post', true);
		\$form->setExtra('enctype="multipart/form-data"');\n		
{$this->formelements->renderElements()}\n
EOT;
		return $ret;
	}
	/*
	*  @public function getPermissionsInFunctionForm
	*  @param string $module_name
	*  @param string $fpif
	*/
	public function getPermissionsInFunctionForm($module_name, $fpif) {    
		$perm_approve = $this->getLanguage($module_name, 'AM', 'PERMISSIONS_APPROVE');
		$perm_submit = $this->getLanguage($module_name, 'AM', 'PERMISSIONS_SUBMIT');
		$perm_view = $this->getLanguage($module_name, 'AM', 'PERMISSIONS_VIEW');
		$ret = <<<EOT
		// Permissions
		\$member_handler = & xoops_gethandler ( 'member' );
		\$group_list = &\$member_handler->getGroupList();
		\$gperm_handler = &xoops_gethandler ( 'groupperm' );
		\$full_list = array_keys ( \$group_list );
		global \$xoopsModule;
		if ( !\$this->isNew() ) {
			\$groups_ids_approve = \$gperm_handler->getGroupIds ( '{$module_name}_approve', \$this->getVar ( '{$fpif}' ), \$xoopsModule->getVar ( 'mid' ) );
			\$groups_ids_submit = \$gperm_handler->getGroupIds ( '{$module_name}_submit', \$this->getVar ( '{$fpif}' ), \$xoopsModule->getVar ( 'mid' ) );
			\$groups_ids_view = \$gperm_handler->getGroupIds ( '{$module_name}_view', \$this->getVar ( '{$fpif}' ), \$xoopsModule->getVar ( 'mid' ) );
			\$groups_ids_approve = array_values ( \$groups_ids_approve );
			\$groups_can_approve_checkbox = new XoopsFormCheckBox ( {$perm_approve}, 'groups_approve[]', \$groups_ids_approve );
			\$groups_ids_submit = array_values ( \$groups_ids_submit );
			\$groups_can_submit_checkbox = new XoopsFormCheckBox ( {$perm_submit}, 'groups_submit[]', \$groups_ids_submit );	
			\$groups_ids_view = array_values ( \$groups_ids_view );
			\$groups_can_view_checkbox = new XoopsFormCheckBox ( {$perm_view}, 'groups_view[]', \$groups_ids_view );			
		} else {
			\$groups_can_approve_checkbox = new XoopsFormCheckBox ( {$perm_approve}, 'groups_approve[]', \$full_list );
			\$groups_can_submit_checkbox = new XoopsFormCheckBox ( {$perm_submit}, 'groups_submit[]', \$full_list );		
			\$groups_can_view_checkbox = new XoopsFormCheckBox ( {$perm_view}, 'groups_view[]', \$full_list );
		}
		
		// For approve
		\$groups_can_approve_checkbox->addOptionArray ( \$group_list );
		\$form->addElement ( \$groups_can_approve_checkbox );
		// For submit
		\$groups_can_submit_checkbox->addOptionArray ( \$group_list );
		\$form->addElement ( \$groups_can_submit_checkbox );		
		// For view
		\$groups_can_view_checkbox->addOptionArray ( \$group_list );
		\$form->addElement ( \$groups_can_view_checkbox );\n\n
EOT;
		return $ret;
	}
	/*
	*  @public function getFootFunctionForm
	*  @param null
	*/
	public function getFootFunctionForm() {    
		$ret = <<<EOT
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
	*  @param string $module_name
	*  @param string $table_name
	*  @param string $fpif
	*  @param string $fpmf
	*/
	public function getClassHandler($module_name, $table_name, $fpif, $fpmf) {		
		$ucf_module_name = ucfirst($module_name);
        $ucf_table_name = ucfirst($table_name);
        $ucf_mod_table_handler = $ucf_module_name . $ucf_table_name;		
		$ret = <<<EOT
/*
 * Class Object Handler {$ucf_module_name}{$ucf_table_name}
 */
class {$ucf_mod_table_handler}Handler extends XoopsPersistableObjectHandler 
{
	/*
	 * Constructor
	 *
	 * @param string \$db
	 */
	public function __construct(&\$db) 
	{
		parent::__construct(\$db, '{$module_name}_{$table_name}', '{$module_name}{$table_name}', '{$fpif}', '{$fpmf}');
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
		$table_nbfields = $table->getVar('table_nbfields');
		$table_name = $table->getVar('table_name');
		$module_name = strtolower($module->getVar('mod_name'));		
		$fields = $this->getTableFields($table->getVar('table_id'));
		foreach(array_keys($fields) as $f) 
		{	
			$field_name = $fields[$f]->getVar('field_name');
			if(($f == 0) && ($table->getVar('table_autoincrement') == 1)) {
				$fpif = $field_name;
			}
			if($fields[$f]->getVar('field_main') == 1) {
				$fpmf = $field_name;
			}			
		}				
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .= $this->getHeadClass($module_name, $table_name, $fields);
		$content .= $this->getHeadFunctionForm($module, $table);
		if ($table->getVar('table_permissions') == 1) {
			$content .= $this->getPermissionsInFunctionForm($module_name, $fpif);
		}
		$content .= $this->getFootFunctionForm();
		$content .= $this->getClassHandler($module_name, $table_name, $fpif, $fpmf);
		
		$this->tdmcfile->create($module_name, 'class', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}