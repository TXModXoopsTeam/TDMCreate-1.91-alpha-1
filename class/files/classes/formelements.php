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
	*  @param string $field_name
	*  @param string $required
	*/
	private function getXoopsFormText($language, $field_name, $required = 'false') {    
		$ret = <<<EOT
		\$form->addElement( new XoopsFormText({$language}, '{$field_name}', 50, 255, \$this->getVar('{$field_name}')){$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormText
	*  @param string $language
	*  @param string $field_name
	*  @param string $required
	*/
	private function getXoopsFormTextArea($language, $field_name, $required = 'false') {    
		$ret = <<<EOT
		\$form->addElement( new XoopsFormTextArea({$language}, '{$field_name}', \$this->getVar('{$field_name}'), 4, 47){$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormDhtmlTextArea
	*  @param string $language
	*  @param string $module_dirname
	*  @param string $field_name
	*  @param string $required
	*/
	private function getXoopsFormDhtmlTextArea($language, $module_dirname, $field_name, $required = 'false') {    
		$ret = <<<EOT
		\$editor_configs = array();
		\$editor_configs['name'] = '{$field_name}';
		\$editor_configs['value'] = \$this->getVar('{$field_name}', 'e');
		\$editor_configs['rows'] = 5;
		\$editor_configs['cols'] = 40;
		\$editor_configs['width'] = '100%';
		\$editor_configs['height'] = '400px';
		\$editor_configs['editor'] = \$this->{$module_dirname}->getConfig('{$module_dirname}_editor');			
		\$form->addElement( new XoopsFormEditor({$language}, '{$field_name}', \$editor_configs){$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormCheckBox
	*  @param string $language
	*  @param string $field_name
	*  @param string $required
	*/
	private function getXoopsFormCheckBox($language, $field_name, $required = 'false') {    
		$ret = <<<EOT
		\${$field_name} = \$this->isNew() ? 0 : \$this->getVar('{$field_name}');
		\$check_{$field_name} = new XoopsFormCheckBox({$language}, '{$field_name}', \${$field_name});
		\$check_{$field_name}->addOption(1, " ");
		\$form->addElement( \$check_{$field_name}{$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormHidden
	*  @param string $field_name
	*/
	private function getXoopsFormHidden($field_name) {    
		$ret = <<<EOT
		\$form->addElement( new XoopsFormHidden('{$field_name}', \$this->getVar('{$field_name}')) );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormUploadFile
	*  @param string $language
	*  @param string $field_name
	*  @param string $required
	*/
	private function getXoopsFormUploadFile($language, $module_dirname, $field_name, $required = 'false') {    
		$ret = <<<EOT
		\$form->addElement( new XoopsFormFile({$language}, '{$field_name}', \$this->{$module_dirname}->getConfig('maxsize')){$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormUploadImage
	*  @param string $language
	*  @param string $table_name
	*  @param string $field_name
	*  @param string $required
	*/
	private function getXoopsFormUploadImage($language, $module_dirname, $table_name, $field_name, $required = 'false') {		
		$stu_field_name = strtoupper($field_name);
		$ret = <<<EOT
		//\$form->addElement(new XoopsFormImage({$language}, '{$field_name}', \$this->{$module_dirname}->getConfig('maxsize')){$required});
		\$get_{$field_name} = \$this->getVar('{$field_name}');
		\${$field_name} = \$get_{$field_name} ? \$get_{$field_name} : 'blank.gif';
		\$iconsdir = '/Frameworks/moduleclasses/icons/32';
		\$uploads_dir = '/uploads/'.\$GLOBALS['xoopsModule']->dirname().'/images/{$table_name}';
        if(is_dir(XOOPS_ROOT_PATH . \$iconsdir)){
		    \$iconsdirectory = \$iconsdir;
		}else{
		    \$iconsdirectory = \$uploads_dir;
		}
        //		
		\$imgtray1 = new XoopsFormElementTray({$language}{$stu_field_name},'<br />');
		if(is_dir(XOOPS_ROOT_PATH . \$iconsdir)) {
		    \$imgpath = sprintf({$language}FORMIMAGE_PATH, ".{\$iconsdir}/");
		}else{
		    \$imgpath = sprintf({$language}FORMIMAGE_PATH, \$uploads_dir);
		}
		\$imgpath1 = sprintf({$language}FORMIMAGE_PATH, ".{\$iconsdirectory}/");
		\$imageselect1 = new XoopsFormSelect(\$imgpath1, '{$field_name}', \${$field_name}, 10);
		\$image_array1 = XoopsLists::getImgListAsArray( XOOPS_ROOT_PATH . \$iconsdirectory );
		foreach( \$image_array1 as \$image1 ) {
			\$imageselect1->addOption("{\$image1}", \$image1);
		}
		\$imageselect1->setExtra( "onchange='showImgSelected(\"image1\", \"{$field_name}\", \"".\$iconsdirectory."\", \"\", \"".XOOPS_URL."\")'" );
		\$imgtray1->addElement(\$imageselect1, false);
		\$imgtray1->addElement( new XoopsFormLabel( '', "<br /><img src='".XOOPS_URL."/".\$iconsdirectory."/".\${$field_name}."' name='image1' id='image1' alt='' />" ) );		
		\$fileseltray1 = new XoopsFormElementTray('','<br />');
		\$fileseltray1->addElement(new XoopsFormFile({$language}FORMUPLOAD , 'attachedfile', \$this->{$module_dirname}->getConfig('maxsize')));
		\$fileseltray1->addElement(new XoopsFormLabel(''));
		\$imgtray1->addElement(\$fileseltray1);
		\$form->addElement( \$imgtray1{$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormColorPicker
	*  @param string $language
	*  @param string $field_name
	*  @param string $required
	*/
	private function getXoopsFormColorPicker($language, $module_dirname, $field_name, $required = 'false') {    
		$ret = <<<EOT
		\$form->addElement( new XoopsFormColorPicker({$language}, '{$field_name}', \$this->{$module_dirname}->getConfig('maxsize')){$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormSelect
	*  @param string $language
	*  @param string $table_name
	*  @param string $field_name
	*  @param string $required
	*/
	private function getXoopsFormSelect($language, $table_name, $field_name, $required = 'false') {    
		$ret = <<<EOT
		\${$field_name}_select = new XoopsFormSelect({$language}, '{$field_name}', \$this->getVar('{$field_name}'));
		\${$field_name}_select->addOptionArray({$table_name}Handler->getList()); 
		\$form->addElement( \${$field_name}_select{$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormSelectUser
	*  @param string $language
	*  @param string $field_name
	*  @param string $required
	*/
	private function getXoopsFormSelectUser($language, $field_name, $required = 'false') {    
		$ret = <<<EOT
		\$form->addElement( new XoopsFormSelectUser({$language}, '{$field_name}', false, \$this->getVar('{$field_name}'), 1, false){$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormRadioYN
	*  @param string $language
	*  @param string $field_name
	*  @param string $required
	*/
	private function getXoopsFormRadioYN($language, $field_name, $required = 'false') {    
		$ret = <<<EOT
		${$field_name} = \$this->isNew() ? 0 : \$this->getVar('{$field_name}');
		\$form->addElement( new XoopsFormRadioYN({$language}, '{$field_name}', ${$field_name}){$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormTextDateSelect
	*  @param string $language
	*  @param string $field_name
	*  @param string $required
	*/
	private function getXoopsFormTextDateSelect($language, $module_dirname, $field_name, $required = 'false') {    
		$ret = <<<EOT
		\$form->addElement( new XoopsFormTextDateSelect({$language}, '{$field_name}', '', \$this->getVar('{$field_name}')){$required} );\n
EOT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormTable
	*  @param string $language
	*  @param string $module_dirname
	*  @param string $table_name
	*  @param string $fields
	*  @param string $required
	*/
	private function getXoopsFormTable($language, $module_dirname, $table_name, $fields, $required = 'false') 
	{    
	    $field_name = '';
		foreach(array_keys($fields) as $f) 
		{			
			if(($fields[$f]->getVar('field_parent') == 1)) {
				$field_name = $fields[$f]->getVar('field_name');
			}						
		}
		$ret = <<<XFT
		\${$table_name}Handler =& \$this->{$module_dirname}->getHandler('{$table_name}');				
		\${$field_name}_select = new XoopsFormSelect({$language}, '{$field_name}', \$this->getVar('{$field_name}'));
		\${$field_name}_select->addOptionArray(\${$field_name}Handler->getList());
		\$form->addElement( \${$field_name}_select{$required} );\n
XFT;
		return $ret;
	}
	/*
	*  @private function getXoopsFormTopic
	*  @param string $language
	*  @param string $module_dirname
	*  @param string $table_name
	*  @param string $fields
	*  @param string $required
	*/
	private function getXoopsFormTopic($language, $module_dirname, $table_name, $fields, $required = 'false') 
	{    
		foreach(array_keys($fields) as $f) 
		{	
			$field_name = $fields[$f]->getVar('field_name');			
			if($fields[$f]->getVar('field_id') == 1) {
				$field_id = $field_name;
			}
			if($fields[$f]->getVar('field_parent') == 1) {
				$field_pid = $field_name;
			}
			if($fields[$f]->getVar('field_main') == 1) {
				$field_main = $field_name;
			}			
		}
		$ret = <<<XFT
		include_once(XOOPS_ROOT_PATH . '/class/tree.php');				
		\${$table_name}Handler = \$this->{$module_dirname}->getHandler('{$table_name}');
		\$criteria = new CriteriaCompo();
		\${$table_name} = \${$table_name}Handler->getObjects( \$criteria );
		if(\${$table_name}) {
			\${$table_name}_tree = new XoopsObjectTree( \${$table_name}, '{$field_id}', '{$field_pid}' );
			\${$field_pid} = \${$table_name}_tree->makeSelBox( '{$field_pid}', '{$field_main}','--', \$this->getVar('{$field_pid}', 'e' ), true );
			\$form->addElement( new XoopsFormLabel ( {$language}, \${$field_pid} ){$required} );
		}\n		
XFT;
		return $ret;
	}
	/*
	*  @public function renderElements
	*  @param null
	*/
	public function renderElements() { 
		$module = $this->getModule();
		$table = $this->getTable();
		$module_dirname = $module->getVar('mod_dirname');		
		$table_name = $table->getVar('table_name');		
		$language_funct = $this->getLanguage($module_dirname, 'AM');
		$language_table = $language_funct . strtoupper($table_name);
		$ret = '';
		$fields = $this->getTableFields($table->getVar('table_id'));
		foreach(array_keys($fields) as $f)		
		{	
			$field_name = $fields[$f]->getVar('field_name');
			$field_element = $fields[$f]->getVar('field_element');
            $field_inform = $fields[$f]->getVar('field_inform');			
			$language = $language_funct . strtoupper($field_name);
			$required = ( $fields[$f]->getVar('field_required') == 1 ) ? ', true' : '';
			//			
			if($field_inform == 1) { 
				// If we want to hide XoopsFormHidden() or field id
				//if(($f > 0) && ($table->getVar('table_autoincrement') == 1)) { 
					// Switch elements
					switch($field_element)
					{
						case 1:
							$ret .= $this->getXoopsFormText($language, $field_name, $required);
						break;
						case 2:
							$ret .= $this->getXoopsFormTextArea($language, $field_name, $required);
						break;
						case 3:
							$ret .= $this->getXoopsFormDhtmlTextArea($language, $module_dirname, $field_name, $required);
						break;
						case 4:
							$ret .= $this->getXoopsFormCheckBox($language, $field_name, $required);
						break;
						case 5:
							$ret .= $this->getXoopsFormRadioYN($language, $field_name, $required);
						break;
						case 6:
							$ret .= $this->getXoopsFormSelect($language, $table_name, $field_name, $required);
						break;
						case 7:
							$ret .= $this->getXoopsFormSelectUser($language, $field_name, $required);
						break;
						case 8:
							$ret .= $this->getXoopsFormColorPicker($language, $module_dirname, $field_name, $required);
						break;
						case 9:
							$ret .= $this->getXoopsFormUploadImage($language_funct, $module_dirname, $table_name, $field_name, $required);
						break;
						case 10:
							$ret .= $this->getXoopsFormUploadFile($language, $module_dirname, $field_name, $required);
						break;
						case 11:
							$ret .= $this->getXoopsFormTextDateSelect($language, $module_dirname, $field_name, $required);
						break;
						default:
							$ret .= $this->getXoopsFormHidden($field_name);					
						break;
					}
					if ($field_element > 11) {
						if($table->getVar('table_category') == 1) {
							$ret .= $this->getXoopsFormTopic($language, $module_dirname, $table_name, $fields, $required);
						} else {
							$ret .= $this->getXoopsFormTable($language, $module_dirname, $table_name, $fields, $required);
						}
					}
				//}
			}
		}
		return $ret;
	}
}