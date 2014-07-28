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
 * @version         $Id: pages.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');
require_once 'objects.php';
class UserPages extends TDMCreateFile
{	
	/*
	* @var string
	*/
	private $userobjects = null;
	/*
	*  @public function constructor
	*  @param null
	*/
	public function __construct() { 
		parent::__construct();
		$this->tdmcfile = TDMCreateFile::getInstance();	
		$this->userobjects = UserObjects::getInstance();
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
		$stuModuleDirname = strtoupper($moduleDirname);
        $stuTableName = strtoupper($tableName);
        $stlTableName = strtolower($tableName);
		$ucfTableName = ucfirst($tableName);
		$ret = <<<EOT
\ninclude_once 'header.php';
\$GLOBALS['xoopsOption']['template_main'] = '{$moduleDirname}_{$tableName}.tpl';	
include_once XOOPS_ROOT_PATH . '/header.php';
\$start = {$moduleDirname}_CleanVars( \$_REQUEST, 'start', 0);
\$limit = \${$moduleDirname}->getConfig('userpager');
// Define Stylesheet
\$xoTheme->addStylesheet( \$style );
//
\$GLOBALS['xoopsTpl']->assign('{$moduleDirname}_upload_url', {$stuModuleDirname}_UPLOAD_URL);
//
\$criteria{$ucfTableName} = new CriteriaCompo();
\${$stlTableName}_count = \${$stlTableName}Handler->getCount(\$criteria{$ucfTableName});
\${$stlTableName}_arr = \${$stlTableName}Handler->getAll(\$criteria{$ucfTableName});
unset(\$criteria{$ucfTableName});
\$keywords = array();
if (\${$stlTableName}_count > 0) {
	foreach (array_keys(\${$stlTableName}_arr) as \$i) 
	{\n
EOT;
		// Fields
        $fields = $this->getTableFields($table->getVar('table_id'));		
		foreach(array_keys($fields) as $f) 
		{
			$fieldName = $fields[$f]->getVar('field_name');
			$fieldParent = $fields[$f]->getVar('field_parent');
			// Verify if table_fieldname is not empty
			$lpFieldName = !empty($tableFieldname) ? substr($fieldName, 0, strpos($fieldName, '_')) : $tableName;
			$rpFieldName = $this->tdmcfile->getRightString($fieldName);	
			if ( $fields[$f]->getVar('field_main') == 1 ) {
				$fpmf = $fieldName; // fpmf = fields parameters main field
			}
			$fieldElement = $fields[$f]->getVar('field_element');				
			if( ($fields[$f]->getVar('field_user') == 1) || ($table->getVar('table_autoincrement') == 1) ) {	
				switch($fieldElement) {
					case 3:
					case 4:
						$ret .= $this->userobjects->getTextAreaGetVar($lpFieldName, $rpFieldName, $tableName, $fieldName);
					break;
					case 8:
						$ret .= $this->userobjects->getSelectUserGetVar($lpFieldName, $rpFieldName, $tableName, $fieldName);
					break;	
					case 11:
						$ret .= $this->userobjects->getUploadImageGetVar($lpFieldName, $rpFieldName, $tableName, $fieldName);
					break;
					case 13:
						$ret .= $this->userobjects->getTextDateSelectGetVar($lpFieldName, $rpFieldName, $tableName, $fieldName);
					break;
					default:
						if( ($fieldParent == 1) && !$table->getVar('table_category') ) {
							if($fieldElement > 13) {					
								$fieldElements = $this->tdmcreate->getHandler('fieldelements')->get($fieldElement);
								$fieldElementTid = $fieldElements->getVar('fieldelement_tid');
								$fieldElementName = $fieldElements->getVar('fieldelement_name');
								$rpFieldElementName = strtolower(str_replace('Table : ', '', $fieldElementName));
							}
							//
							$fieldNameParent = $fieldName;
							//
							$criteriaFieldsTopic = new CriteriaCompo();
							$criteriaFieldsTopic->add(new Criteria('field_tid', $fieldElementTid));
							$fieldsTopic = $this->tdmcreate->getHandler('fields')->getObjects($criteriaFieldsTopic);
							unset($criteriaFieldsTopic);
							foreach(array_keys($fieldsTopic) as $ft) 
							{
								if( $fieldsTopic[$ft]->getVar('field_main') == 1 ) {
									$fieldNameTopic = $fieldsTopic[$ft]->getVar('field_name');
								}
							}
							$ret .= $this->userobjects->getTopicGetVar($lpFieldName, $rpFieldName, $tableName, $rpFieldElementName, $fieldNameParent, $fieldNameTopic);
						} else {
							$ret .= $this->userobjects->getSimpleGetVar($lpFieldName, $rpFieldName, $tableName, $fieldName);
						}						
					break;
				}				
			}			
		}
		$ret .= <<<EOT
		\$GLOBALS['xoopsTpl']->append('{$stlTableName}', \${$lpFieldName});
		\$keywords[] = \${$stlTableName}_arr[\$i]->getVar('{$fpmf}');
        unset(\${$lpFieldName});
    }
	// Display Navigation
    if (\${$stlTableName}_count > \$limit) {
	    include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
        \$nav = new XoopsPageNav(\${$stlTableName}_count, \$limit, \$start, 'start');
        \$GLOBALS['xoopsTpl']->assign('pagenav', \$nav->renderNav(4));
    }
}
// keywords
{$moduleDirname}_meta_keywords(\${$moduleDirname}->getConfig('keywords').', '. implode(', ', \$keywords));
unset(\$keywords);
// description
{$moduleDirname}_meta_description({$language}{$stuTableName}_DESC);
//
\$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', {$stuModuleDirname}_URL.'/{$stlTableName}.php');
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