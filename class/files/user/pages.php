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
 * @version         $Id: user_pages.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class UserPages extends TDMCreateFile
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
	*  @param string $table
	*/
	public function write($module, $table) {    
		$this->setModule($module);
		$this->setTable($table);
	}
		
	/*
	*  @private function getUserPages
	*  @param string $moduleDirname
	*  @param string $language
	*/
	private function getUserPages($moduleDirname, $language)
	{  
		$table = $this->getTable();        		
		$tableName = $table->getVar('table_name');
		$tableFieldname = $table->getVar('table_fieldname');
		$stu_mod_name = strtoupper($moduleDirname);
        $stu_table_name = strtoupper($tableName);
        $stl_table_name = strtolower($tableName);
		$ret = <<<EOT
\ninclude_once 'header.php';
\$GLOBALS['xoopsOption']['template_main'] = '{$moduleDirname}_{$tableName}.tpl';	
include_once XOOPS_ROOT_PATH . '/header.php';
\$start = {$moduleDirname}_CleanVars( \$_REQUEST, 'start', 0);
\$limit = \${$moduleDirname}->getConfig('userpager');
// Define Stylesheet
\$xoTheme->addStylesheet( \$style );
// Get Handler
\${$stl_table_name}Handler =& \${$moduleDirname}->getHandler('{$stl_table_name}');
//
\$GLOBALS['xoopsTpl']->assign('{$moduleDirname}_upload_url', {$stu_mod_name}_UPLOAD_URL);
//
\$criteria = new CriteriaCompo();
\${$stl_table_name}_count = \${$stl_table_name}Handler->getCount(\$criteria);
\${$stl_table_name}_arr = \${$stl_table_name}Handler->getAll(\$criteria);
\$keywords = array();
if (\${$stl_table_name}_count > 0) {
	foreach (array_keys(\${$stl_table_name}_arr) as \$i) 
	{\n
EOT;
		// Fields
        $fields = $this->getTableFields($table->getVar('table_id'));		
		foreach(array_keys($fields) as $f) 
		{
			$fieldName = $fields[$f]->getVar('field_name');
			$rp_field_name = $fieldName;
			// Verify if table_fieldname is not empty
			if(!empty($tableFieldname)) {				
				if(strpos($fieldName, '_')) {       
					$str = strpos($fieldName, '_'); 
					if($str !== false){ 
						$rp_field_name = substr($fieldName, $str + 1, strlen($fieldName));
					} 		
				}
				$lp_field_name = substr($fieldName, 0, strpos($fieldName, '_'));
				$tname = $lp_field_name;
				$fieldElement = $fields[$f]->getVar('field_element');
				if ( $fields[$f]->getVar('field_main') == 1 ) {
					$fpmf = $fieldName; // fpmf = fields parameters main field
				}
				// Verify if this is a textarea or dhtmltextarea
				if (  $fieldElement == 2 || $fieldElement == 3 ) {
					$ret .= <<<EOT
		\${$tname}['{$rp_field_name}'] = strip_tags(\${$stl_table_name}_arr[\$i]->getVar('{$fieldName}'));\n
EOT;
				} else {
					$ret .= <<<EOT
		\${$tname}['{$rp_field_name}'] = \${$stl_table_name}_arr[\$i]->getVar('{$fieldName}');\n
EOT;
				}
			} else {
			    $tname = $tableName;
				$fieldElement = $fields[$f]->getVar('field_element');
				if ( $fields[$f]->getVar('field_main') == 1 ) {
					$fpmf = $fieldName; // fpmf = fields parameters main field
				}
				// Verify if this is a textarea or dhtmltextarea
				if (  $fieldElement == 2 || $fieldElement == 3 ) {
					$ret .= <<<EOT
		\${$tname}['{$rp_field_name}'] = strip_tags(\${$stl_table_name}_arr[\$i]->getVar('{$fieldName}'));\n
EOT;
				} else {
					$ret .= <<<EOT
		\${$tname}['{$rp_field_name}'] = \${$stl_table_name}_arr[\$i]->getVar('{$fieldName}');\n
EOT;
				}			
			}
		}
		$ret .= <<<EOT
		\$GLOBALS['xoopsTpl']->append('{$stl_table_name}', \${$tname});
		\$keywords[] = \${$stl_table_name}_arr[\$i]->getVar('{$fpmf}');
        unset(\${$tname});
    }
	// Display Navigation
    if (\${$stl_table_name}_count > \$limit) {
	    include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
        \$nav = new XoopsPageNav(\${$stl_table_name}_count, \$limit, \$start, 'start');
        \$GLOBALS['xoopsTpl']->assign('pagenav', \$nav->renderNav(4));
    }
}
// keywords
{$moduleDirname}_meta_keywords(xoops_getModuleOption('keywords', \$dirname) .', '. implode(', ', \$keywords));
unset(\$keywords);
// description
{$moduleDirname}_meta_description({$language}{$stu_table_name}_DESC);
//
\$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', {$stu_mod_name}_URL.'/{$stl_table_name}.php');
//
include_once 'footer.php';	
EOT;
		return $ret;
	}
	/*
	*  @public function render
	*  @param null
	*/
	public function renderFile($filename) {    
		$module = $this->getModule();
		$moduleDirname = $module->getVar('mod_dirname');				
		$language = $this->getLanguage($moduleDirname, 'MA');			
		$content = $this->getHeaderFilesComments($module, $filename);	
		$content .= $this->getUserPages($moduleDirname, $language);	
		//
		$this->tdmcfile->create($moduleDirname, '/', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}