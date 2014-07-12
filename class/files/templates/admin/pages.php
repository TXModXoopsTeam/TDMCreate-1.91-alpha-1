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
	*  @param string $moduleDirname
	*  @param string $tableName
	*  @param string $fields
	*  @param string $language
	*/
	private function getTemplatesAdminPagesHeader($moduleDirname, $tableName, $fields, $language) {    
		$ret = <<<EOT
<{include file="db:{$moduleDirname}_admin_header.tpl"}>
<{if {$tableName}_list}>
	<table class="outer {$tableName} width100">
		<thead>
			<tr class="head">\n
EOT;
		foreach(array_keys($fields) as $f)
		{
			$fieldName = $fields[$f]->getVar('field_name');
			$lang_fn = $language.strtoupper($fieldName);			
			if( $fields[$f]->getVar('field_inlist') == 1 ) { 
				$ret .= <<<EOT
				<th class="center"><{\$smarty.const.{$lang_fn}}></th>\n
EOT;
			}
		}
		$ret .= <<<EOT
				<th class="center"><{\$smarty.const.{$language}FORMACTION}></th>
			</tr>
		</thead>\n
EOT;
		return $ret;
	}
	/*
	*  @private function getTemplatesAdminPagesBody
	*  @param string $moduleDirname
	*  @param string $tableName
	*  @param string $fields
	*  @param string $language
	*/
	private function getTemplatesAdminPagesBody($moduleDirname, $tableName, $fields, $language) 
	{    
		$ret = <<<EOT
		<tbody>
			<{foreach item=list from=\${$tableName}_list}>	
				<tr class="<{cycle values='odd, even'}>">\n
EOT;
		foreach(array_keys($fields) as $f) 
		{
			$fieldName = $fields[$f]->getVar('field_name');
			$fieldElement = $fields[$f]->getVar('field_element');
			if($f == 0) {
				$field_id = $fieldName;
				$rpFieldName = $this->tdmcfile->getRightString($field_id);				
			} else {
				$rpFieldName = $this->tdmcfile->getRightString($fieldName);
			}			
			$lp_field_name = substr($fieldName, 0, strpos($fieldName, '_'));
			if( $fields[$f]->getVar('field_inlist') == 1 ) {	
				switch( $fieldElement ) {			    
					case 9:			
						$ret .= <<<EOT
					<td class="center"><span style="background-color: <{\$list.{$rpFieldName}}>;">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>\n			
EOT;
					break;
					case 10:
						$ret .= <<<EOT
					<td class="center"><img src="<{xoModuleIcons32}><{\$list.{$rpFieldName}}>" alt="{$tableName}"></td>\n
EOT;
					break;
					case 11:
						$ret .= <<<EOT
					<td class="center"><img src="<{\${$moduleDirname}_upload_url}>/images/{$tableName}/<{\$list.{$rpFieldName}}>" alt="{$tableName}"></td>\n
EOT;
					break;
					default:
						$ret .= <<<EOT
					<td class="center"><{\$list.{$rpFieldName}}></td>\n
EOT;
					break;
				}
			}
		}
		$ret .= <<<EOT
					<td class="center">
						<a href="{$tableName}.php?op=edit&amp;{$field_id}=<{\$list.{$rpFieldName}}>" title="<{\$smarty.const._EDIT}>">
							<img src="<{xoModuleIcons16 edit.png}>" alt="<{\$smarty.const._EDIT}>" />
						</a>                   
						<a href="{$tableName}.php?op=delete&amp;{$field_id}=<{\$list.{$rpFieldName}}>" title="<{\$smarty.const._DELETE}>">
							<img src="<{xoModuleIcons16 delete.png}>" alt="<{\$smarty.const._DELETE}>" />
						</a>
					</td>
				</tr>
			<{/foreach}>
		</tbody>
	</table>\n
EOT;
		return $ret;
	}
	/*
	*  @private function getTemplatesAdminPagesBodyFieldnameEmpty
	*  @param string $moduleDirname
	*  @param string $tableName
	*  @param string $fields
	*  @param string $language
	*/
	private function getTemplatesAdminPagesBodyFieldnameEmpty($moduleDirname, $tableName, $fields, $language) 
	{ 		
		$ret = <<<EOT
	<tbody>
			<{foreach item=list from=\${$tableName}_list}>	
				<tr class="<{cycle values='odd, even'}>">\n
EOT;
		foreach(array_keys($fields) as $f) 
		{
			$fieldName = $fields[$f]->getVar('field_name');
			$fieldElement = $fields[$f]->getVar('field_element');
			if($f == 0) {
				$field_id = $fieldName;							
			}
			if( $fields[$f]->getVar('field_inlist') == 1 ) { 
				switch( $fieldElement ) {			    
					case 9:			
						$ret .= <<<EOT
					<td class="center"><span style="background-color: <{\$list.{$fieldName}}>;">\t\t</span></td>\n			
EOT;
					break;
					case 10:
						$ret .= <<<EOT
					<td class="center"><img src="<{xoModuleIcons32}><{\$list.{$fieldName}}>" alt="{$tableName}"></td>\n
EOT;
					break;
					case 11:
						$ret .= <<<EOT
					<td class="center"><img src="<{\${$moduleDirname}_upload_url}>/images/{$tableName}/<{\$list.{$fieldName}}>" alt="{$tableName}"></td>\n
EOT;
					break;
					default:
						$ret .= <<<EOT
					<td class="center"><{\$list.{$fieldName}}></td>\n
EOT;
					break;
				}
			}
		}
		$ret .= <<<EOT
					<td class="center">
						<a href="{$tableName}.php?op=edit&amp;{$field_id}=<{\$list.{$field_id}}>" title="<{\$smarty.const._EDIT}>">
							<img src="<{xoModuleIcons16 edit.png}>" alt="<{\$smarty.const._EDIT}>" />
						</a>                   
						<a href="{$tableName}.php?op=delete&amp;{$field_id}=<{\$list.{$field_id}}>" title="<{\$smarty.const._DELETE}>">
							<img src="<{xoModuleIcons16 delete.png}>" alt="<{\$smarty.const._DELETE}>" />
						</a>
					</td>
				</tr>
			<{/foreach}>
		</tbody>
	</table>\n
EOT;
		return $ret;
	}
	/*
	*  @private function getTemplatesAdminPagesFooter
	*  @param string $moduleDirname
	*/
	private function getTemplatesAdminPagesFooter($moduleDirname) {    
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
<{include file="db:{$moduleDirname}_admin_footer.tpl"}>
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
		$moduleDirname = $module->getVar('mod_dirname');		
		$tableName = $table->getVar('table_name');
		$tableFieldname = $table->getVar('table_fieldname');		
		$language = $this->getLanguage($moduleDirname, 'AM');	
		$fields = $this->getTableFields($table->getVar('table_id'));
		$content = $this->getTemplatesAdminPagesHeader($moduleDirname, $tableName, $fields, $language);
		// Verify if table_fieldname is not empty
		if(!empty($tableFieldname)) {
			$content .= $this->getTemplatesAdminPagesBody($moduleDirname, $tableName, $fields, $language);
		} else {
			$content .= $this->getTemplatesAdminPagesBodyFieldnameEmpty($moduleDirname, $tableName, $fields, $language);
		}
		$content .= $this->getTemplatesAdminPagesFooter($moduleDirname);
		//
		$this->tdmcfile->create($moduleDirname, 'templates/admin', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}