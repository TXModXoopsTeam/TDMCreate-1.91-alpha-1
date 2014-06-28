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
 * @version         $Id: blocks_pages.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class BlocksFiles extends TDMCreateFile
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
	*/
	public function write($module, $table) {    
		$this->setModule($module);
		$this->setTable($table);
	}
	/*
	*  @public function getBlocksShow
	*  @param null
	*/
	public function getBlocksShow($module_name, $table_name, $table_fieldname, $table_category, $fields, $fpif) {		
		$stu_module_name = strtoupper($module_name);
		$stl_module_name = strtolower($module_name);
		$ret = <<<EOT
include_once XOOPS_ROOT_PATH.'/modules/{$stl_module_name}/include/common.php';
include_once XOOPS_ROOT_PATH.'/modules/{$stl_module_name}/include/functions.php';	
function b_{$stl_module_name}_{$table_name}_show(\$options) 
{
	include_once XOOPS_ROOT_PATH.'/modules/{$stl_module_name}/class/{$table_name}.php';
	\$myts =& MyTextSanitizer::getInstance();
    \$GLOBALS['xoopsTpl']->assign('{$stl_module_name}_upload_url', {$stu_module_name}_UPLOAD_URL);
	\${$table_fieldname} = array();
	\$type_block = \$options[0];
	\$nb_{$table_name} = \$options[1];
	\$lenght_title = \$options[2];

	\${$table_name}Handler =& xoops_getModuleHandler('{$table_name}', '{$module_name}');
	\$criteria = new CriteriaCompo();
	array_shift(\$options);
	array_shift(\$options);
	array_shift(\$options);\n
EOT;
		if ( $table_category == 1 ) {
			$ret .= <<<EOT
	if (!(count(\$options) == 1 && \$options[0] == 0)) {
		\$criteria->add(new Criteria('{$table_fieldname}_category', {$module_name}_block_addCatSelect(\$options), 'IN'));
	}\n
EOT;
		}			
		$ret .= <<<EOT
	if (\$type_block) 
	{
		\$criteria->add(new Criteria('{$fpif}', 0, '!='));
		\$criteria->setSort('{$fpif}');
		\$criteria->setOrder('ASC');
	}

	\$criteria->setLimit(\$nb_{$table_name});
	\${$table_name}_arr = \${$table_name}Handler->getAll(\$criteria);
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
				$tname = $table_fieldname;
				$ret .= <<<EOT
		\${$tname}['{$rp_field_name}'] = \${$table_name}_arr[\$i]->getVar('{$field_name}');\n
EOT;
		    } else {
				$tname = $table_name;
				$ret .= <<<EOT
		\${$tname}['{$rp_field_name}'] = \${$table_name}_arr[\$i]->getVar('{$field_name}');\n
EOT;
			}
		}
		$ret .= <<<EOT
	}
	return \${$table_fieldname};
}\n\n
EOT;
		return $ret;
	}
	/*
	*  @public function getBlocksEdit
	*  @param string $module_name
	*  @param string $table_name
	*  @param string $fpif
	*  @param string $fpmf
	*  @param string $language
	*/
	public function getBlocksEdit($module_name, $table_name, $fpif, $fpmf, $language) {    
		$stu_module_name = strtoupper($module_name);
		$stl_module_name = strtolower($module_name);
		$ret = <<<EOT
function b_{$stl_module_name}_{$table_name}_edit(\$options) 
{	
    include_once XOOPS_ROOT_PATH.'/modules/{$stl_module_name}/class/{$table_name}.php';		
	\${$table_name}Handler =& xoops_getModuleHandler('{$table_name}', '{$module_name}');
	\$GLOBALS['xoopsTpl']->assign('{$stl_module_name}_upload_url', {$stu_module_name}_UPLOAD_URL);	
	\$form = {$language}DISPLAY;
	\$form .= "<input type='hidden' name='options[0]' value='".\$options[0]."' />";
	\$form .= "<input name='options[1]' size='5' maxlength='255' value='".\$options[1]."' type='text' />&nbsp;<br />";
	\$form .= {$language}TITLELENGTH." : <input name='options[2]' size='5' maxlength='255' value='".\$options[2]."' type='text' /><br /><br />";	
	array_shift(\$options);
	array_shift(\$options);
	array_shift(\$options);
	\$criteria = new CriteriaCompo();
	\$criteria->add(new Criteria('{$fpif}', 0, '!='));
	\$criteria->setSort('{$fpif}');
	\$criteria->setOrder('ASC');
	\${$table_name}_arr = \${$table_name}Handler->getAll(\$criteria);
	unset(\$criteria);
	\$form .= {$language}CATTODISPLAY."<br /><select name='options[]' multiple='multiple' size='5'>";
	\$form .= "<option value='0' " . (array_search(0, \$options) === false ? "" : "selected='selected'") . ">" .{$language}ALLCAT . "</option>";
	foreach (array_keys(\${$table_name}_arr) as \$i) {
		\${$fpif} = \${$table_name}_arr[\$i]->getVar('{$fpif}');
		\$form .= "<option value='" . \${$fpif} . "' " . (array_search(\${$fpif}, \$options) === false ? "" : "selected='selected'") . ">".\${$table_name}_arr[\$i]->getVar('{$fpmf}')."</option>";
	}
	\$form .= "</select>";
	return \$form;
}	
EOT;
		return $ret;
	}		
	/*
	*  @public function renderFile
	*  @param null
	*/
	public function renderFile($filename)
	{  		
		$module = $this->getModule();		
		$table = $this->getTable();
		$module_name = strtolower($module->getVar('mod_name'));
		$table_name = $table->getVar('table_name');
		$table_fieldname = $table->getVar('table_fieldname');
		$table_category = $table->getVar('table_category');
		$language = $this->getLanguage($module_name, 'MB');
		$fields = $this->getTableFields($table->getVar('table_id'));
		foreach(array_keys($fields) as $f) 
		{
			if($f == 0) {
				$fpif = $fields[$f]->getVar('field_name');
			}
			if($fields[$f]->getVar('field_main') == 1) {
				$fpmf = $fields[$f]->getVar('field_name');
			}
		}		
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .= $this->getBlocksShow($module_name, $table_name, $table_fieldname, $table_category, $fields, $fpif);
		$content .= $this->getBlocksEdit($module_name, $table_name, $fpif, $fpmf, $language);
		//
		$this->tdmcfile->create($module_name, 'blocks', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}