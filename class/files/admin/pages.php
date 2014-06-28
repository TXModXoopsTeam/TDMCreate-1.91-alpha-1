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
 * @version         $Id: admin_pages.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');
require_once 'objects.php';
class AdminPages extends TDMCreateFile
{
	/*
	* @var string
	*/
	private $adminobjects = null;		
	/*
	*  @public function constructor
	*  @param null
	*/
	public function __construct() {  
		parent::__construct();
		$this->adminobjects = AdminObjects::getInstance();
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
	*  @param string $table
	*/
	public function write($module, $table) {    
		$this->setModule($module);
		$this->setTable($table);
	}
	/*
	*  @public function getAdminPagesHeader
	*  @param string $mod_name
	*  @param string $table_name
	*/
	public function getAdminPagesHeader($mod_name, $table_name) {  
		
		$ret = <<<EOT
\ninclude_once 'header.php';
//It recovered the value of argument op in URL$
\$op = {$mod_name}_CleanVars(\$_REQUEST, 'op', 'list', 'string');
// Navigation
echo \$adminMenu->addNavigation('{$table_name}.php');
switch (\$op) 
{\n
EOT;
		return $ret;
	}
	
	/*
	*  @public function getAdminPagesList
	*  @param string $table_name
	*  @param string $language
	*/
	public function getAdminPagesList($module_name, $table_name, $table_fieldname, $language, $fields, $fpif, $fpmf) {  
		$stu_mod_name = strtoupper($module_name);
        $stl_mod_name = strtolower($module_name);
		$stu_table_name = strtoupper($table_name);
		$stu_table_fieldname = strtoupper($table_fieldname);
		$ret = <<<EOT
    case 'list': 
    default:  
		\$limit = xoops_getModuleOption('adminpager');
		\$start = {$module_name}_CleanVars(\$_REQUEST, 'start', 0);
		\$adminMenu->addItemButton({$language}ADD_{$stu_table_fieldname}, '{$table_name}.php?op=new', 'add');
		\$template_main = '{$stl_mod_name}_{$table_name}.tpl';
		echo \$adminMenu->renderButton();
		\$criteria = new CriteriaCompo();
		\$criteria->setSort('{$fpif} ASC, {$fpmf}');
		\$criteria->setOrder('ASC');
		\${$table_name}_rows = \${$table_name}Handler->getCount(\$criteria);
		\${$table_name}_arr = \${$table_name}Handler->getAll(\$criteria);
		unset(\$criteria);
		\$GLOBALS['xoopsTpl']->assign('{$stl_mod_name}_url', {$stu_mod_name}_URL);
		\$GLOBALS['xoopsTpl']->assign('{$stl_mod_name}_upload_url', {$stu_mod_name}_UPLOAD_URL);
		// Table view
		if (\${$table_name}_rows > 0) 
		{						
			foreach (array_keys(\${$table_name}_arr) as \$i)
			{\n
EOT;
		foreach(array_keys($fields) as $f) 
		{
			$field_name = $fields[$f]->getVar('field_name');
			$rp_field_name = $field_name;
			// Verify if table_fieldname is not empty
			if(!empty($table_fieldname)) {
				if(strpos($field_name, '_')) {       
					$str = strpos($field_name, '_'); 
					if($str !== false){ 
						$rp_field_name = substr($field_name, $str + 1, strlen($field_name));
					} 		
				}
				$lp_field_name = substr($field_name, 0, strpos($field_name, '_'));
				$ret .= <<<EOT
				\${$lp_field_name}['{$rp_field_name}'] = \${$table_name}_arr[\$i]->getVar('{$field_name}');\n
EOT;
			} else {
				$lp_field_name = $table_name;
				$ret .= <<<EOT
				\${$lp_field_name}['{$rp_field_name}'] = \${$table_name}_arr[\$i]->getVar('{$field_name}');\n
EOT;
			}
		}
			$ret .= <<<EOT
				\$GLOBALS['xoopsTpl']->append('{$table_name}_list', \${$lp_field_name});
                unset(\${$lp_field_name});
			}\n
EOT;
			$ret .= <<<EOT
			if ( \${$table_name}_rows > \$limit ) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				\$pagenav = new XoopsPageNav(\${$table_name}_rows, \$limit, \$start, 'start', 'op=list&limit=' . \$limit);
				\$GLOBALS['xoopsTpl']->assign('pagenav', \$pagenav->renderNav(4));
			}
        } else {
			\$GLOBALS['xoopsTpl']->assign('error', {$language}THEREARENT_{$stu_table_name});
		}	
    break;\n
EOT;
		return $ret;
	}
	
	/*
	*  @public function getAdminPagesNew
	*  @param string $table_name	
	*  @param string $language
	*/
	public function getAdminPagesNew($module_name, $table_name, $language) {  
		$stl_mod_name = strtolower($module_name);
		$stu_table_name = strtoupper($table_name);
		$ret = <<<EOT
	case 'new':		
		\$template_main = '{$stl_mod_name}_{$table_name}.tpl';
        \$adminMenu->addItemButton({$language}{$stu_table_name}_LIST, '{$table_name}.php', 'list');
        echo \$adminMenu->renderButton();		
		// Get Form
        \${$table_name}Obj =& \${$table_name}Handler->create();
        \$form = \${$table_name}Obj->getForm();
		\$form->display();
    break;\n
EOT;
		return $ret;
	}
	
	/*
	*  @public function getAdminPagesSave
	*  @param string $table_name	
	*  @param string $language
	*/
	public function getAdminPagesSave($module_name, $table_name, $language, $fields, $fpif, $fpmf) 
	{  				
		$ret = <<<EOT
	case 'save':
		if ( !\$GLOBALS['xoopsSecurity']->check() ) {
           redirect_header('{$table_name}.php', 3, implode(',', \$GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset(\$_REQUEST['{$fpif}'])) {
           \${$table_name}Obj =& \${$table_name}Handler->get(\$_REQUEST['{$fpif}']);
        } else {
           \${$table_name}Obj =& \${$table_name}Handler->create();
        }
		// Set Vars\n
EOT;
		foreach (array_keys($fields) as $f) 
		{
			$field_name = $fields[$f]->getVar('field_name');
			$field_element = $fields[$f]->getVar('field_element');
			if($f > 0) { // If we want to hide field id
				switch($field_element) {
					case 4:
					case 5:
						$ret .= $this->adminobjects->getCheckBoxOrRadioYN($table_name, $field_name);
					break;
					case 9:
						$ret .= $this->adminobjects->getUploadImage($module_name, $table_name, $field_name);
					break;
					case 10:
						$ret .= $this->adminobjects->getUploadFile($module_name, $table_name, $field_name);
					break;
					case 11:
						$ret .= $this->adminobjects->getTextDateSelect($table_name, $field_name);
					break;
					default:
						$ret .= $this->adminobjects->getSimpleSetVar($table_name, $field_name);
					break;
				}
			}
		}

		$ret .= <<<EOT
		// Insert Data
		if (\${$table_name}Handler->insert(\${$table_name}Obj)) {
           redirect_header('{$table_name}.php?op=list', 2, {$language}FORMOK);
        }
		// Get Form
        echo \${$table_name}Obj->getHtmlErrors();
        \$form =& \${$table_name}Obj->getForm();
		\$form->display();
	break;\n
EOT;
		return $ret;
	}
	
	/*
	*  @public function getAdminPagesEdit
	*  @param string $table_name	
	*  @param string $language
	*/
	public function getAdminPagesEdit($module_name, $table_name, $language, $fpif) {  
		$stl_mod_name = strtolower($module_name);
		$stu_table_name = strtoupper($table_name);
		$ret = <<<EOT
	case 'edit':	    
		\$template_main = '{$stl_mod_name}_{$table_name}.tpl';
        \$adminMenu->addItemButton({$language}ADD_{$stu_table_name}, '{$table_name}.php?op=new', 'add');
		\$adminMenu->addItemButton({$language}{$stu_table_name}_LIST, '{$table_name}.php', 'list');
        echo \$adminMenu->renderButton();		
		// Get Form
		\${$table_name}Obj = \${$table_name}Handler->get(\$_REQUEST['{$fpif}']);
		\$form = \${$table_name}Obj->getForm();
		\$form->display();
	break;\n
EOT;
		return $ret;
	}
	
	/*
	*  @public function getAdminPagesDelete
	*  @param string $table_name	
	*  @param string $language
	*/
	public function getAdminPagesDelete($table_name, $language, $fpif, $fpmf) {  
		
		$ret = <<<EOT
	case 'delete':
		\${$table_name}Obj =& \${$table_name}Handler->get(\$_REQUEST['{$fpif}']);
		if (isset(\$_REQUEST['ok']) && \$_REQUEST['ok'] == 1) {
			if ( !\$GLOBALS['xoopsSecurity']->check() ) {
				redirect_header('{$table_name}.php', 3, implode(', ', \$GLOBALS['xoopsSecurity']->getErrors()));
			}
			if (\${$table_name}Handler->delete(\${$table_name}Obj)) {
				redirect_header('{$table_name}.php', 3, {$language}FORMDELOK);
			} else {
				echo \${$table_name}Obj->getHtmlErrors();
			}
		} else {
			xoops_confirm(array('ok' => 1, '{$fpif}' => \$_REQUEST['{$fpif}'], 'op' => 'delete'), \$_SERVER['REQUEST_URI'], sprintf({$language}FORMSUREDEL, \${$table_name}Obj->getVar('{$fpmf}')));
		}
	break;\n
EOT;
		return $ret;
	}
	
	/*
	*  @public function getAdminPagesFooter
	*  @param null
	*/
	public function getAdminPagesFooter() { 		
		$ret = <<<EOT
}
include_once 'footer.php';
EOT;
		return $ret;
	}
	
	/*
	*  @public function render
	*  @param null
	*/
	public function renderFile($filename) 
	{    
        $module = $this->getModule();
		$table = $this->getTable();
		$module_name = $module->getVar('mod_name');      
		$table_name = $table->getVar('table_name');	
		$table_fieldname = $table->getVar('table_fieldname');	
		$language = $this->getLanguage($module_name, 'AM');
		$fields = $this->getTableFields($table->getVar('table_id'));
		foreach(array_keys($fields) as $f) 
		{
			$field_name = $fields[$f]->getVar('field_name');
			if($f == 0) {
				$fpif = $field_name;
			}
			if($fields[$f]->getVar('field_main') == 1) {
				$fpmf = $field_name;
			}
		}		
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .=	$this->getAdminPagesHeader($module_name, $table_name);
		$content .=	$this->getAdminPagesList($module_name, $table_name, $table_fieldname, $language, $fields, $fpif, $fpmf);
		$content .=	$this->getAdminPagesNew($module_name, $table_name, $language);		
		$content .=	$this->getAdminPagesSave($module_name, $table_name, $language, $fields, $fpif, $fpmf);
		$content .=	$this->getAdminPagesEdit($module_name, $table_name, $language, $fpif);
		$content .=	$this->getAdminPagesDelete($table_name, $language, $fpif, $fpmf);
		$content .= $this->getAdminPagesFooter();
		//
		$this->tdmcfile->create($module_name, 'admin', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}