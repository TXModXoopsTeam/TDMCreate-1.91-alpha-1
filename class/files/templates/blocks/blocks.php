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
 * @version         $Id: blocks.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class TemplatesBlocks extends TDMCreateFile
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
	*  @private function getTemplatesBlocksHeader
	*  @param string $module_name
	*  @param string $table
	*  @param string $language
	*/
	private function getTemplatesBlocksHeader($module_name, $table, $language) {    
		$stl_mod_name = strtolower($module_name);
		$table_name = $table->getVar('table_name');
		$ret = <<<EOT
<table class="{$table_name} width100">
	<thead>
		<tr class="head">\n
EOT;
		$fields = $this->getTableFields($table->getVar('table_id'));
		foreach(array_keys($fields) as $f) 
		{
			$field_name = $fields[$f]->getVar('field_name');			
			$lang_stu_field_name = $language.strtoupper($field_name);
			$ret .= <<<EOT
			<th class="center"><{\$smarty.const.{$lang_stu_field_name}}></th>\n
EOT;
		}
		$ret .= <<<EOT
		</tr>
	</thead>\n	
EOT;
		return $ret;
	}
	/*
	*  @private function getTemplatesBlocksBody
	*  @param string $module_name
	*  @param string $table
	*  @param string $language
	*/
	private function getTemplatesBlocksBody($module_name, $table, $language) 
	{    
		$stl_mod_name = strtolower($module_name);
		$table_name = $table->getVar('table_name');
		$ret = <<<EOT
	<tbody>
		<{foreach item=list from=\${$table_name}}>	
			<tr class="<{cycle values='odd, even'}>">\n
EOT;
		$fields = $this->getTableFields($table->getVar('table_id'));
		foreach(array_keys($fields) as $f) 
		{
			$field_name = $fields[$f]->getVar('field_name');
			$field_element = $fields[$f]->getVar('field_element');
			$rp_field_name = $field_name;
			if(strpos($field_name, '_')) {       
				$str = strpos($field_name, '_'); 
				if($str !== false){ 
					$rp_field_name = substr($field_name, $str + 1, strlen($field_name));
				} 		
			}
			if( $field_element == 9 ) {
				$ret .= <<<EOT
				<td class="center">
					<img src="<{\${$module_name}_upload_url}>/images/{$table_name}/<{\$list.{$rp_field_name}}>" alt="{$table_name}">
				</td>\n
EOT;
			} elseif( $field_element == 8 ) {			
				$ret .= <<<EOT
				<td class="center"><span style="background-color: <{\$list.{$rp_field_name}}>;">\t\t</span></td>\n
EOT;
			} else {
				$ret .= <<<EOT
				<td class="center"><{\$list.{$rp_field_name}}></td>\n
EOT;
			}
		}
		$ret .= <<<EOT
			</tr>
		<{/foreach}>
    </tbody>
</table>
EOT;
		return $ret;
	}
	/*
	*  @private function getTemplatesBlocksBodyFieldnameEmpty
	*  @param string $module_name
	*  @param string $table
	*  @param string $language
	*/
	private function getTemplatesBlocksBodyFieldnameEmpty($module_name, $table, $language) 
	{ 		
		$stl_mod_name = strtolower($module_name);
		$table_name = $table->getVar('table_name');		
		$ret = <<<EOT
	<tbody>
		<{foreach item=list from=\${$table_name}}>	
			<tr class="<{cycle values='odd, even'}>">\n
EOT;
		$fields = $this->getTableFields($table->getVar('table_id'));
		foreach(array_keys($fields) as $f) 
		{
			$field_name = $fields[$f]->getVar('field_name');
			$field_element = $fields[$f]->getVar('field_element');			
			if( $field_element == 9 ) {
				$ret .= <<<EOT
				<td class="center">
					<img src="<{\${$module_name}_upload_url}>/images/{$table_name}/<{\$list.{$field_name}}>" alt="{$table_name}">
				</td>\n
EOT;
			} elseif( $field_element == 8 ) {			
				$ret .= <<<EOT
				<td class="center"><span style="background-color: <{\$list.{$field_name}}>;">\t\t</span></td>\n
EOT;
			} else {
				$ret .= <<<EOT
				<td class="center"><{\$list.{$field_name}}></td>\n
EOT;
			}
		}
		$ret .= <<<EOT
			</tr>
		<{/foreach}>
    </tbody>
</table>
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
		$module_name = strtolower($module->getVar('mod_name'));
		$table_name = $table->getVar('table_name');
		$table_fieldname = $table->getVar('table_fieldname');
        $language = $this->getLanguage($module_name, 'MB');		
		$content = $this->getTemplatesBlocksHeader($module_name, $table, $language);
		// Verify if table_fieldname is not empty
		if(!empty($table_fieldname)) {
			$content .= $this->getTemplatesBlocksBody($module_name, $table, $language);
		} else {
			$content .= $this->getTemplatesBlocksBodyFieldnameEmpty($module_name, $table, $language);
		}
		//$content .= $this->getTemplatesBlocksFooter($module_name);
		//
		$this->tdmcfile->create($module_name, 'templates/blocks', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}