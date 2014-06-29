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
 * @version         $Id: include_search.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class IncludeSearch extends TDMCreateFile
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
	*  @param string $filename
	*/
	public function write($module, $table, $filename) {    
		$this->setModule($module);
		$this->setFileName($filename);
		$this->setTable($table);
	}
	/*
	*  @static function getSearchField
	*  @param string $fpsf
    *  @param string $options
	*/
	public function getSearchField($fpsf, $options)
	{
		// fpsf = fields parameters search field
		$sql = '';
		if(isset($fpsf)) {
			$nb_fpsf = count($fpsf);
			$sql .= '(';
			for($i = 0; $i < $nb_fpsf; $i++)
			{
				if ( $i != $nb_fpsf - 1 ) {
					$sql .= ''.$fpsf[$i].' LIKE %$queryarray['.$options.']% OR ';
				} else {
					$sql .= ''.$fpsf[$i].' LIKE %$queryarray[0]%';
				}
			}
			$sql .= ')';
		}
		return $sql;
	}	
	/*
	*  @static function getSearchFunction
	*  @param string $fpsf
	*/
	public function getSearchFunction($module_dirname)
	{
		$table = $this->getTable(); 
		$table_name = $table->getVar('table_name');
		$table_fieldname = $table->getVar('table_fieldname');
		$fpif = ''; $fpsf = null;
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
			if($fields[$f]->getVar('field_search') == 1) {
				$fpsf = $field_name;
			}
		}
		$img_search = 'blank.gif';
		$ret = <<<EOT
\n// search callback functions
function {$module_dirname}_search(\$queryarray, \$andor, \$limit, \$offset, \$userid)
{
	global \$xoopsDB;	
	\$sql = "SELECT '{$fpif}', '{$fpmf}' FROM ".\$xoopsDB->prefix('mod_{$module_dirname}_{$table_name}')." WHERE {$fpif} != 0";	
	if ( \$userid != 0 ) {
		\$sql .= " AND {$table_fieldname}_submitter=".intval(\$userid);
	}	
	if ( is_array(\$queryarray) && \$count = count(\$queryarray) ) 
	{
		\$sql .= " AND (
EOT;
		$ret .= $this->getSearchField($fpsf, 0).'"';		
		$ret .= <<<EOT
		
		for(\$i = 1; \$i < \$count; \$i++)
		{
			\$sql .= " \$andor ";
			\$sql .= "{$this->getSearchField($fpsf, '$i')}";
		}
		\$sql .= ")";
	}	
	\$sql .= " ORDER BY '{$fpif}' DESC";
	\$result = \$xoopsDB->query(\$sql,\$limit,\$offset);
	\$ret = array();
	\$i = 0;
	while(\$myrow = \$xoopsDB->fetchArray(\$result))
	{
		\$ret[\$i]['image'] = 'assets/images/icons/32/{$img_search}';
		\$ret[\$i]['link'] = '{$table_name}.php?{$fpif}='.\$myrow['{$fpif}'];
		\$ret[\$i]['title'] = \$myrow['{$fpmf}'];			
		\$i++;
	}
	unset(\$i);
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
		$module_dirname = $module->getVar('mod_dirname');        				
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .= $this->getSearchFunction($module_dirname);
		//
		$this->tdmcfile->create($module_dirname, 'include', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}