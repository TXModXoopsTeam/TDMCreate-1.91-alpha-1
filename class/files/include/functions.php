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
 * @version         $Id: 1.91 include_functions.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class IncludeFunctions extends TDMCreateFile
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
	*  @param string $filename
	*/
	public function write($module, $filename) {    
		$this->setModule($module);
		$this->setFileName($filename);
	}
	/*
	*  @public function getFunctionBlock
	*  @param string $module_name
	*/
	public function getFunctionBlock($module_name) {		
		$ret = <<<EOT
\n/***************Blocks***************/
function {$module_name}_block_addCatSelect(\$cats) {
	if(is_array(\$cats)) 
	{
		\$cat_sql = '('.current(\$cats);
		array_shift(\$cats);
		foreach(\$cats as \$cat) 
		{
			\$cat_sql .= ','.\$cat;
		}
		\$cat_sql .= ')';
	}
	return \$cat_sql;
}\n
EOT;
        return $ret;
	}
	
	/*
	*  @public function getFunctionCleanVars
	*  @param string $module_name
	*/
	public function getFunctionCleanVars($module_name) {		
		$ret = <<<EOT
\nfunction {$module_name}_CleanVars( &\$global, \$key, \$default = '', \$type = 'int' ) {
    switch ( \$type ) {
        case 'string':
            \$ret = ( isset( \$global[\$key] ) ) ? filter_var( \$global[\$key], FILTER_SANITIZE_MAGIC_QUOTES ) : \$default;
            break;
        case 'int': default:
            \$ret = ( isset( \$global[\$key] ) ) ? filter_var( \$global[\$key], FILTER_SANITIZE_NUMBER_INT ) : \$default;
            break;
    }
    if ( \$ret === false ) {
        return \$default;
    }
    return \$ret;
}\n
EOT;
        return $ret;
	}	
	
	/*
	*  @public function getFunctionMetaKeywords
	*  @param string $module_name
	*/
	public function getFunctionMetaKeywords($module_name) {		
		$ret = <<<EOT
\nfunction {$module_name}_meta_keywords(\$content)
{
	global \$xoopsTpl, \$xoTheme;
	\$myts =& MyTextSanitizer::getInstance();
	\$content= \$myts->undoHtmlSpecialChars(\$myts->displayTarea(\$content));
	if(isset(\$xoTheme) && is_object(\$xoTheme)) {
		\$xoTheme->addMeta( 'meta', 'keywords', strip_tags(\$content));
	} else {	// Compatibility for old Xoops versions
		\$xoopsTpl->assign('xoops_meta_keywords', strip_tags(\$content));
	}
}\n
EOT;
        return $ret;
	}
	
	/*
	*  @public function getFunctionDescription
	*  @param string $module_name
	*/
	public function getFunctionMetaDescription($module_name) {		
		$ret = <<<EOT
\nfunction {$module_name}_meta_description(\$content)
{
	global \$xoopsTpl, \$xoTheme;
	\$myts =& MyTextSanitizer::getInstance();
	\$content = \$myts->undoHtmlSpecialChars(\$myts->displayTarea(\$content));
	if(isset(\$xoTheme) && is_object(\$xoTheme)) {
		\$xoTheme->addMeta( 'meta', 'description', strip_tags(\$content));
	} else {	// Compatibility for old Xoops versions
		\$xoopsTpl->assign('xoops_meta_description', strip_tags(\$content));
	}
}
EOT;
        return $ret;
	}
	
	/*
	*  @public function render
	*  @param null
	*/
	public function render() {    
		$module = $this->getModule();
		$filename = $this->getFileName();
		$module_name = strtolower($module->getVar('mod_name'));
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .= $this->getFunctionBlock($module_name);
		$content .= $this->getFunctionCleanVars($module_name);
		$content .= $this->getFunctionMetaKeywords($module_name);
		$content .= $this->getFunctionMetaDescription($module_name);

		$this->tdmcfile->create($module_name, 'include', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}