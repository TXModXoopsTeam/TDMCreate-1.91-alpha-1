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
 * @version         $Id: formelements.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class TDMCreateFormElements extends TDMCreateFile
{	
	/*
	*  @public function constructor
	*  @param null
	*/
	public function __construct() {    
		parent::__construct();
		$this->tdmcreate = TDMCreate::getInstance();
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
	*  @public function initForm
	*  @param string $module
	*  @param string $table
	*/
	public function initForm($module, $table) {    
		$this->setModule($module);
		$this->setTable($table);
	}
	/*
	*  @private function getXoopsFormText
	*  @param string $language
	*  @param string $fieldName
	*  @param string $required
	*/
	private function getXoopsFormText($language, $fieldName, $required = 'false') {    
		
		$ret = <<<EOT
		// Form Text {$fieldName}
		\$form->addElement( new XoopsFormText({$language}, '{$fieldName}', 50, 255, \$this->getVar('{$fieldName}')){$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormText
	*  @param string $language
	*  @param string $fieldName
	*  @param string $required
	*/
	private function getXoopsFormTextArea($language, $fieldName, $required = 'false') {    
		$ret = <<<EOT
		// Form Text Area
		\$form->addElement( new XoopsFormTextArea({$language}, '{$fieldName}', \$this->getVar('{$fieldName}'), 4, 47){$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormDhtmlTextArea
	*  @param string $language
	*  @param string $moduleDirname
	*  @param string $fieldName
	*  @param string $required
	*/
	private function getXoopsFormDhtmlTextArea($language, $moduleDirname, $fieldName, $required = 'false') {    
		$ret = <<<EOT
		// Form Dhtml Text Area
		\$editor_configs = array();
		\$editor_configs['name'] = '{$fieldName}';
		\$editor_configs['value'] = \$this->getVar('{$fieldName}', 'e');
		\$editor_configs['rows'] = 5;
		\$editor_configs['cols'] = 40;
		\$editor_configs['width'] = '100%';
		\$editor_configs['height'] = '400px';
		\$editor_configs['editor'] = \$this->{$moduleDirname}->getConfig('{$moduleDirname}_editor');			
		\$form->addElement( new XoopsFormEditor({$language}, '{$fieldName}', \$editor_configs){$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormCheckBox
	*  @param string $language
	*  @param string $fieldName
	*  @param string $required
	*/
	private function getXoopsFormCheckBox($language, $fieldName, $required = 'false') {    
		$ret = <<<EOT
		// Form Check Box
		\${$fieldName} = \$this->isNew() ? 0 : \$this->getVar('{$fieldName}');
		\$check_{$fieldName} = new XoopsFormCheckBox({$language}, '{$fieldName}', \${$fieldName});
		\$check_{$fieldName}->addOption(1, " ");
		\$form->addElement( \$check_{$fieldName}{$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormHidden
	*  @param string $fieldName
	*/
	private function getXoopsFormHidden($fieldName) {    
		$ret = <<<EOT
		// Form Hidden
		\$form->addElement( new XoopsFormHidden('{$fieldName}', \$this->getVar('{$fieldName}')) );\n
EOT;
		return $ret;
	}	
	/*
	*  @private function getXoopsFormImageList
	*  @param string $language
	*  @param string $moduleDirname
	*  @param string $tableName
	*  @param string $fieldName
	*  @param string $required
	*/
	private function getXoopsFormImageList($language, $moduleDirname, $tableName, $fieldName, $required = 'false') {		
		$stuTableName = strtoupper($tableName);
		$stuFieldName = strtoupper($fieldName);
		$ret = <<<EOT
		// Form image file
		\$get_{$fieldName} = \$this->getVar('{$fieldName}');
		\${$fieldName} = \$get_{$fieldName} ? \$get_{$fieldName} : 'blank.gif';
		\$iconsdir = '/Frameworks/moduleclasses/icons/32';
		\$uploads_dir = '/uploads/'.\$GLOBALS['xoopsModule']->dirname().'/images/{$tableName}';
        \$iconsdirectory = is_dir(XOOPS_ROOT_PATH . \$iconsdir) ? \$iconsdir : \$uploads_dir;		
        //		
		\$imgtray1 = new XoopsFormElementTray({$language}{$stuFieldName},'<br />');		
		\$imgpath = is_dir(XOOPS_ROOT_PATH . \$iconsdir) ? sprintf({$language}FORMIMAGE_PATH, ".{\$iconsdir}/") : sprintf({$language}FORMIMAGE_PATH, \$uploads_dir);
		//\$imgpath1 = sprintf({$language}FORMIMAGE_PATH, ".{\$iconsdirectory}/");
		\$imageselect1 = new XoopsFormSelect(\$imgpath, '{$fieldName}', \${$fieldName}, 10);
		\$image_array1 = XoopsLists::getImgListAsArray( XOOPS_ROOT_PATH . \$iconsdirectory );
		foreach( \$image_array1 as \$image1 ) {
			\$imageselect1->addOption("{\$image1}", \$image1);
		}
		\$imageselect1->setExtra( "onchange='showImgSelected(\"image1\", \"{$fieldName}\", \"".\$iconsdirectory."\", \"\", \"".XOOPS_URL."\")'" );
		\$imgtray1->addElement(\$imageselect1, false);
		\$imgtray1->addElement( new XoopsFormLabel( '', "<br /><img src='".XOOPS_URL."/".\$iconsdirectory."/".\${$fieldName}."' name='image1' id='image1' alt='' />" ) );		
		// Form File
		\$fileseltray = new XoopsFormElementTray('','<br />');
		\$fileseltray->addElement(new XoopsFormFile({$language}FORM_UPLOAD_IMAGE_LIST_{$stuTableName} , 'attachedfile', \$this->{$moduleDirname}->getConfig('maxsize')));
		\$fileseltray->addElement(new XoopsFormLabel(''));
		\$imgtray1->addElement(\$fileseltray);
		\$form->addElement( \$imgtray1{$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormUploadImage
	*  @param string $language
	*  @param string $moduleDirname
	*  @param string $tableName
	*  @param string $required
	*/
	private function getXoopsFormUploadImage($language, $moduleDirname, $tableName, $required = 'false') {		
		$stuTableName = strtoupper($tableName);
		$ret = <<<EOT
		// Form Upload Image
		\$formImage = new XoopsFormFile({$language}FORM_UPLOAD_IMAGE_{$stuTableName} , 'attachedfile', \$this->{$moduleDirname}->getConfig('maxsize'));
		\$form->addElement( \$formImage{$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormUploadFile
	*  @param string $language
	*  @param string $moduleDirname
	*  @param string $tableName
	*  @param string $fieldName
	*  @param string $required
	*/
	private function getXoopsFormUploadFile($language, $moduleDirname, $tableName, $fieldName, $required = 'false') {    
		$stuTableName = strtoupper($tableName);
		$ret = <<<EOT
		// Form file
		\$form->addElement( new XoopsFormFile({$language}FORM_UPLOAD_FILE_{$stuTableName}, '{$fieldName}', \$this->{$moduleDirname}->getConfig('maxsize')){$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormColorPicker
	*  @param string $language
	*  @param string $fieldName
	*  @param string $required
	*/
	private function getXoopsFormColorPicker($language, $moduleDirname, $fieldName, $required = 'false') {    
		$ret = <<<EOT
		// Form Color Picker
		\$form->addElement( new XoopsFormColorPicker({$language}, '{$fieldName}', \$this->{$moduleDirname}->getConfig('maxsize')){$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormSelect
	*  @param string $language
	*  @param string $tableName
	*  @param string $fieldName
	*  @param string $required
	*/
	private function getXoopsFormSelect($language, $tableName, $fieldName, $required = 'false') {    
		$ret = <<<EOT
		// Form Select
		\${$fieldName}_select = new XoopsFormSelect({$language}, '{$fieldName}', \$this->getVar('{$fieldName}'));
		\${$fieldName}_select->addOption('Empty'); 
		\${$fieldName}_select->addOptionArray(\${$tableName}Handler->getList()); 
		\$form->addElement( \${$fieldName}_select{$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormSelectUser
	*  @param string $language
	*  @param string $fieldName
	*  @param string $required
	*/
	private function getXoopsFormSelectUser($language, $fieldName, $required = 'false') {    
		$ret = <<<EOT
		// Form Select User
		\$form->addElement( new XoopsFormSelectUser({$language}, '{$fieldName}', false, \$this->getVar('{$fieldName}'), 1, false){$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormRadioYN
	*  @param string $language
	*  @param string $fieldName
	*  @param string $required
	*/
	private function getXoopsFormRadioYN($language, $fieldName, $required = 'false') {    
		$ret = <<<EOT
		// Form Radio Yes/No
		${$fieldName} = \$this->isNew() ? 0 : \$this->getVar('{$fieldName}');
		\$form->addElement( new XoopsFormRadioYN({$language}, '{$fieldName}', ${$fieldName}){$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormTextDateSelect
	*  @param string $language
	*  @param string $fieldName
	*  @param string $required
	*/
	private function getXoopsFormTextDateSelect($language, $moduleDirname, $fieldName, $required = 'false') {    
		$ret = <<<EOT
		// Form Text Date Select
		\$form->addElement( new XoopsFormTextDateSelect({$language}, '{$fieldName}', '', \$this->getVar('{$fieldName}')){$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormTable
	*  @param string $language
	*  @param string $moduleDirname
	*  @param string $tableName
	*  @param string $fields
	*  @param string $required
	*/
	private function getXoopsFormTable($language, $moduleDirname, $tableName, $fields, $required = 'false') 
	{    
	    $fieldName = '';
		$ucf_table_name = ucfirst($tableName);
		foreach(array_keys($fields) as $f) 
		{			
			if(($fields[$f]->getVar('field_parent') == 1)) {
				$fieldName = $fields[$f]->getVar('field_name');
			}						
		}
		$ret = <<<EOT
		// Form Topic {$ucf_table_name}
		\${$tableName}Handler =& \$this->{$moduleDirname}->getHandler('{$tableName}');				
		\${$fieldName}_select = new XoopsFormSelect({$language}, '{$fieldName}', \$this->getVar('{$fieldName}'));
		\${$fieldName}_select->addOptionArray(\${$tableName}Handler->getList());
		\$form->addElement( \${$fieldName}_select{$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormTopic
	*  @param string $language
	*  @param string $moduleDirname
	*  @param string $tableName
	*  @param string $fields
	*  @param string $required
	*/
	private function getXoopsFormTopic($language, $moduleDirname, $table, $fields, $required = 'false') 
	{    
		$tableName = $table->getVar('table_name');
		$ucf_table_name = ucfirst($tableName);
		foreach(array_keys($fields) as $f) 
		{	
			$fieldName = $fields[$f]->getVar('field_name');			
			if(($f == 0) && ($table->getVar('table_autoincrement') == 1)) {
				$field_id = $fieldName;
			}
			if($fields[$f]->getVar('field_parent') == 1) {
				$field_pid = $fieldName;
			}
			if($fields[$f]->getVar('field_main') == 1) {
				$field_main = $fieldName;
			}			
		}
		$ret = <<<EOT
		// Form Topic {$ucf_table_name}
		include_once(XOOPS_ROOT_PATH . '/class/tree.php');				
		\${$tableName}Handler = \$this->{$moduleDirname}->getHandler('{$tableName}');
		\$criteria = new CriteriaCompo();
		\${$tableName} = \${$tableName}Handler->getObjects( \$criteria );
		if(\${$tableName}) {
			\${$tableName}_tree = new XoopsObjectTree( \${$tableName}, '{$field_id}', '{$field_pid}' );
			\${$field_pid} = \${$tableName}_tree->makeSelBox( '{$field_pid}', '{$field_main}', '--', \$this->getVar('{$field_pid}', 'e' ), true );
			\$form->addElement( new XoopsFormLabel ( {$language}, \${$field_pid} ){$required} );
		}\n
EOT;
		return $ret;
	}
	/*
	*  @public function renderElements
	*  @param null
	*/
	public function renderElements() { 
		$module = $this->getModule();
		$table = $this->getTable();
		$moduleDirname = $module->getVar('mod_dirname');		
		$tableName = $table->getVar('table_name');		
		$language_funct = $this->getLanguage($moduleDirname, 'AM');
		//$language_table = $language_funct . strtoupper($tableName);
		$ret = '';
		$fields = $this->getTableFields($table->getVar('table_id'));
		foreach(array_keys($fields) as $f)		
		{	
			$fieldName = $fields[$f]->getVar('field_name');
			$fieldElement = $fields[$f]->getVar('field_element');
            $fieldInForm = $fields[$f]->getVar('field_inform');			
			$language = $language_funct . strtoupper($fieldName);
			$required = ( $fields[$f]->getVar('field_required') == 1 ) ? ', true' : '';
			//			
			if($fieldInForm == 1) {				
				// Switch elements
				switch($fieldElement)
				{
					case 1:
						$ret .= $this->getXoopsFormText($language, $fieldName, $required);
					break;
					case 2:
						$ret .= $this->getXoopsFormTextArea($language, $fieldName, $required);
					break;
					case 3:
						$ret .= $this->getXoopsFormDhtmlTextArea($language, $moduleDirname, $fieldName, $required);
					break;
					case 4:
						$ret .= $this->getXoopsFormCheckBox($language, $fieldName, $required);
					break;
					case 5:
						$ret .= $this->getXoopsFormRadioYN($language, $fieldName, $required);
					break;
					case 6:
						$ret .= $this->getXoopsFormSelect($language, $tableName, $fieldName, $required);
					break;
					case 7:
						$ret .= $this->getXoopsFormSelectUser($language, $fieldName, $required);
					break;
					case 8:
						$ret .= $this->getXoopsFormColorPicker($language, $moduleDirname, $fieldName, $required);
					break;
					case 9:
						$ret .= $this->getXoopsFormImageList($language_funct, $moduleDirname, $tableName, $fieldName, $required);
					break;
					case 10:
						$ret .= $this->getXoopsFormUploadImage($language_funct, $moduleDirname, $tableName, $required);
					break;
					case 11:
						$ret .= $this->getXoopsFormUploadFile($language, $moduleDirname, $tableName, $fieldName, $required);
					break;
					case 12:
						$ret .= $this->getXoopsFormTextDateSelect($language, $moduleDirname, $fieldName, $required);
					break;
					default:
						// If we want to hide XoopsFormHidden() or field id
						if(($f == 0) && ($table->getVar('table_autoincrement') == 1)) { 
							$ret .= $this->getXoopsFormHidden($fieldName);	
						}				
					break;
				}
				if ($fieldElement > 12) {
					if($table->getVar('table_category') == 1) {
						$ret .= $this->getXoopsFormTopic($language, $moduleDirname, $table, $fields, $required);
					} else {
						$ret .= $this->getXoopsFormTable($language, $moduleDirname, $tableName, $fields, $required);
					}
				}				
			}
		}
		return $ret;
	}
}