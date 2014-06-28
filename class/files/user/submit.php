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
 * @version         $Id: user_submit.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class UserSubmit extends TDMCreateFile
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
	*  @param mixed $table
	*  @param string $filename
	*/
	public function write($module, $table, $filename) {    
		$this->setModule($module);
		$this->setTable($table);
		$this->setFileName($filename);
	}
	/*
	*  @public function getUserSubmitHeader
	*  @param null
	*/
	public function getUserSubmitHeader()
    {			
		$ret = <<<EOT
include_once 'header.php';
\$op = downloads_CleanVars(\$_REQUEST, 'op', 'form', 'string');
// Template
\$xoopsOption['template_main'] = 'user_submit.tpl';
include_once XOOPS_ROOT_PATH.'/header.php';
\$xoTheme->addStylesheet( XOOPS_URL . '/modules/' . \$xoopsModule->getVar('dirname', 'n') . '/css/style.css', null );
//On recupere la valeur de l'argument op dans l'URL$
// redirection if not permissions
if (\$perm_submit == false) {
    redirect_header('index.php', 2, _NOPERM);
    exit();
}

//
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
	public function getUserSubmitForm($table_name, $language) {  
		$ret = <<<EOT
    case 'form': 
    default:  
		// Description
        \$xoTheme->addMeta( 'meta', 'description', strip_tags({$language}SUBMIT));

        // Create
        \${$table_name}Obj =& \${$table_name}Handler->create();
        \$form = \${$table_name}Obj->getForm();
        \$xoopsTpl->assign('form', \$form->render());\n
EOT;
		return $ret;
	}
	
	/*
	*  @public function getUserSubmitSave
	*  @param string $module_name
	*  @param string $table_name
	*/
	public function getUserSubmitSave($module_name, $table_id, $table_name) 
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
EOT;
		$fields = $this->getTableFields($table_id);
		foreach (array_keys($fields) as $f) 
		{
			$field_name = $fields[$f]->getVar('field_name');
			$field_element = $fields[$f]->getVar('field_element');
			if(($field_element == 4) || ($field_element == 5)) {
				$ret .= $this->adminobjects->getCheckBoxOrRadioYN($table_name, $field_name);
			} elseif($field_element == 9) {
				$ret .= $this->adminobjects->getUploadImage($module_name, $table_name, $field_name);
			} elseif($field_element == 10) {
				$ret .= $this->adminobjects->getUploadFile($module_name, $table_name, $field_name);
			} elseif($field_element == 11) {
				$ret .= $this->adminobjects->getTextDateSelect($table_name, $field_name);
			} else {
				$ret .= $this->adminobjects->getSimpleSetVar($table_name, $field_name);
			}
		}

		$ret .= <<<EOT
		
		if (\${$table_name}Handler->insert(\${$table_name}Obj)) {
			redirect_header('index.php', 2, {$language}FORMOK);
        }

        echo \${$table_name}Obj->getHtmlErrors();
        \$form =& \${$table_name}Obj->getForm();
		\$form->display();
	break;\n
EOT;
		return $ret;
	}
	
	/*
	*  @public function getUserSubmitFooter
	*  @param null
	*/
	public function getUserSubmitFooter()
    {
        $ret = <<<EOT
include_once 'footer.php';	
EOT;
		return $ret;
    }
	
	/*
	*  @public function render
	*  @param null
	*/
	public function render() {    
		$module = $this->getModule();
		$table = $this->getTable();        		
		$filename = $this->getFileName();
		$module_name = $module->getVar('mod_name');
		$table_id = $table->getVar('table_id');
		$table_name = $table->getVar('table_name');
		$language = $this->getLanguage($module_name, 'MA');			
		$content = $this->getHeaderFilesComments($module, $filename);	
		$content .= $this->getUserSubmitHeader();
		$content .= $this->getUserSubmitForm($table_name, $language);
		$content .= $this->getUserSubmitSave($module_name, $table_id, $table_name);
		$content .= $this->getUserSubmitFooter();
		$this->tdmcfile->create($module_name, '/', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}