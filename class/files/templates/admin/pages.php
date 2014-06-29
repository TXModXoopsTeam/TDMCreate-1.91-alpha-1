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
require_once TDMC_PATH . '/class/files/htmlsmartycodes.php';
class TemplatesAdminPages extends HtmlSmartyCodes
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
	*  @private function getTemplatesAdminPagesHeader
	*  @param string $module_dirname
	*  @param string $table
	*  @param string $language
	*/
	private function getTemplatesAdminPagesHeader($module_dirname, $table, $language) {    
		$table_name = $table->getVar('table_name');
		$ret = <<<EOT
<{include file="db:{$module_dirname}_admin_header.tpl"}>
<{if {$table_name}_list}>
	<table class="outer {$table_name} width100">
		<thead>
			<tr class="head">\n
EOT;
		$fields = $this->getTableFields($table->getVar('table_id'));
		foreach(array_keys($fields) as $f)
		{
			$field_name = $fields[$f]->getVar('field_name');
			$lang_fn = $language.strtoupper($field_name);		
			$ret .= <<<EOT
				<th class="center"><{\$smarty.const.{$lang_fn}}></th>\n
EOT;
		}
		$ret .= <<<EOT
			</tr>
		</thead>\n
EOT;
		return $ret;
	}
	/*
	*  @private function getTemplatesAdminPagesBody
	*  @param string $module_dirname
	*  @param string $table
	*  @param string $language
	*/
	private function getTemplatesAdminPagesBody($module_dirname, $table, $language) 
	{    
		$module_dirname = strtolower($module_dirname);
		$table_name = $table->getVar('table_name');
		$ret = <<<EOT
		<tbody>
			<{foreach item=list from=\${$table_name}_list}>	
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
				if($str !== false) { 
					$rp_field_name = substr($field_name, $str + 1, strlen($field_name));
				} 		
			}
			switch( $field_element ) {			    
				case 8:			
					$ret .= <<<EOT
					<td class="center"><span style="background-color: <{\$list.{$rp_field_name}}>;">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>\n			
EOT;
				break;
				case 9:
					$ret .= <<<EOT
					<td class="center"><img src="<{\${$module_dirname}_upload_url}>/images/{$table_name}/<{\$list.{$rp_field_name}}>" alt="{$table_name}"></td>\n
EOT;
				break;
				default:
					$ret .= <<<EOT
					<td class="center"><{\$list.{$rp_field_name}}></td>\n
EOT;
				break;
			}
		}
		$ret .= <<<EOT
				</tr>
			<{/foreach}>
		</tbody>
	</table>\n
EOT;
		return $ret;
	}
	/*
	*  @private function getTemplatesAdminPagesBodyFieldnameEmpty
	*  @param string $module_dirname
	*  @param string $table
	*  @param string $language
	*/
	private function getTemplatesAdminPagesBodyFieldnameEmpty($module_dirname, $table, $language) 
	{ 		
		$table_name = $table->getVar('table_name');		
		$ret = <<<EOT
	<tbody>
			<{foreach item=list from=\${$table_name}_list}>	
				<tr class="<{cycle values='odd, even'}>">\n
EOT;
		$fields = $this->getTableFields($table->getVar('table_id'));
		foreach(array_keys($fields) as $f) 
		{
			$field_name = $fields[$f]->getVar('field_name');
			$field_element = $fields[$f]->getVar('field_element');			
			switch( $field_element ) {			    
				case 8:			
					$ret .= <<<EOT
					<td class="center"><span style="background-color: <{\$list.{$field_name}}>;">\t\t</span></td>\n			
EOT;
				break;
				case 9:
					$ret .= <<<EOT
					<td class="center"><img src="<{\${$module_dirname}_upload_url}>/images/{$table_name}/<{\$list.{$field_name}}>" alt="{$table_name}"></td>\n
EOT;
				break;
				default:
					$ret .= <<<EOT
					<td class="center"><{\$list.{$field_name}}></td>\n
EOT;
				break;
			}
		}
		$ret .= <<<EOT
				</tr>
			<{/foreach}>
		</tbody>
	</table>\n
EOT;
		return $ret;
	}
	/*
	*  @private function getTemplatesAdminPagesFooter
	*  @param string $module_dirname
	*/
	private function getTemplatesAdminPagesFooter($module_dirname) {    
		$ret = <<<EOT
	<div class="clear">&nbsp;</div>
	<{if \$pagenav}><br />
		<!-- Display navigation -->
	    <div class="xo-pagenav floatright"><{\$pagenav}></div><div class="clear spacer"></div>
	<{/if}>
	<{if \$error}>
		<div class="errorMsg">
			<strong><{\$error}></strong>
		</div>
	<{/if}>
<{/if}>
<{if \$form}>
	<!-- Display form (add,edit) -->
	<div class="spacer"><{\$form}></div>
<{/if}>
<br />
<!-- Footer -->
<{include file="db:{$module_dirname}_admin_footer.tpl"}>
EOT;
		return $ret;
	}
	/*
	*  @public function render
	*  @param null
	*/
	public function renderFile($filename) {    
		$module = $this->getModule();
		$table = $this->getTable(); 	
		$module_dirname = $module->getVar('mod_name');		
		$table_name = $table->getVar('table_name');
		$table_fieldname = $table->getVar('table_fieldname');		
		$language = $this->getLanguage($module_dirname, 'AM');			
		$content = $this->getTemplatesAdminPagesHeader($module_dirname, $table, $language);
		// Verify if table_fieldname is not empty
		if(!empty($table_fieldname)) {
			$content .= $this->getTemplatesAdminPagesBody($module_dirname, $table, $language);
		} else {
			$content .= $this->getTemplatesAdminPagesBodyFieldnameEmpty($module_dirname, $table, $language);
		}
		$content .= $this->getTemplatesAdminPagesFooter($module_dirname);
		//
		$this->tdmcfile->create($module_dirname, 'templates/admin', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}