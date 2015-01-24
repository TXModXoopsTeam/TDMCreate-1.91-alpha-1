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
 * @version         $Id: LanguageModinfo.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');
require_once 'LanguageDefines.php';
class LanguageModinfo extends TDMCreateFile
{	
	/*
	* @var mixed
	*/
	private $defines = null;
	/*
	*  @public function constructor
	*  @param null
	*/
	public function __construct() {   
		parent::__construct();
		$this->tdmcfile = TDMCreateFile::getInstance();	
		$this->defines = LanguageDefines::getInstance();
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
	*  @param mixed $tables
	*  @param string $filename
	*/
	public function write($module, $table, $tables, $filename) {    
		$this->setModule($module);		
		$this->setTable($table);
		$this->setTables($tables);
		$this->setFileName($filename);
	}
	/*
	*  @private function getLanguageMain
	*  @param string $language
	*  @param string $module	
	*/
	private function getLanguageMain($language, $module) 
	{    
		$ret = $this->defines->getAboveHeadDefines('Admin Main');
		$ret .= $this->defines->getDefine($language, "NAME", "{$module->getVar('mod_name')}");
		$ret .= $this->defines->getDefine($language, "DESC", "{$module->getVar('mod_description')}");
		return $ret;
	}
	/*
	*  @private function getLanguageMenu
	*  @param string $language
	*  @param array $table
	*  @param array $tables
	*/
	private function getLanguageMenu($language, $table, $tables)
	{
		$menu = 1;
		$ret = $this->defines->getAboveHeadDefines('Admin Menu');
		$ret .= $this->defines->getDefine($language, "ADMENU{$menu}", "Dashboard");
		foreach (array_keys($tables) as $i) 
		{   
			$menu++;
			$ucfTableName = ucfirst($tables[$i]->getVar('table_name'));			
			$ret .= $this->defines->getDefine($language, "ADMENU{$menu}", "{$ucfTableName}");			
		}
		if (is_object($table) && $table->getVar('table_permissions') == 1) {
			$menu++;
			$ret .= $this->defines->getDefine($language, "ADMENU{$menu}", "Permissions");
		}
		$menu++;
		$ret .= $this->defines->getDefine($language, "ADMENU{$menu}", "About");		
		unset( $menu );
		return $ret;
	}
	/*
	*  @private function getLanguageAdmin
	*  @param string $language
	*/
	private function getLanguageAdmin($language) 
	{ 		
		$ret = $this->defines->getAboveHeadDefines('Admin Nav');
		$ret .= $this->defines->getDefine($language, "ADMINPAGER", "Admin pager");
		$ret .= $this->defines->getDefine($language, "ADMINPAGER_DESC", "Admin per page list");		
		return $ret;
	}
	/*
	*  @private function getLanguageSubmenu
	*  @param string $language
	*  @param array $tables
	*/
	private function getLanguageSubmenu($language, $tables) 
	{ 		
		$ret = $this->defines->getAboveDefines('Submenu');
		$i = 1;
		foreach(array_keys($tables) as $t) 
		{	
			$tableName = $tables[$t]->getVar('table_name');			
			if( $tables[$t]->getVar('table_submenu') == 1 ) {
				$ret .= $this->defines->getDefine($language, "SMNAME{$i}", "{$tableName}");
			}
			$i++;
		}
		unset($i);
		return $ret;
	}
	/*
	*  @private function getLanguageBlocks
	*  @param string $language
	*  @param array $tables
	*/
	private function getLanguageBlocks($language, $tables) 
	{ 		
		$ret = $this->defines->getAboveDefines('Blocks');		
		foreach (array_keys($tables) as $i) 
		{	
			$tableName = $tables[$i]->getVar('table_name');
			$stuTableName = strtoupper($tableName);
			$ucfTableName = ucfirst($tableName);
			if( $tables[$i]->getVar('table_blocks') == 1 ) {
				$ret .= $this->defines->getDefine($language, "{$stuTableName}_BLOCK", "{$ucfTableName} block");			
			}
		}
		return $ret;
	}
	/*
	*  @private function getLanguageUser
	*  @param string $language
	*/
	private function getLanguageUser($language) 
	{ 		
		$ret = $this->defines->getAboveDefines('User');
		$ret .= $this->defines->getDefine($language, "USERPAGER", "User pager");
		$ret .= $this->defines->getDefine($language, "USERPAGER_DESC", "User per page list");
		return $ret;
	}
	/*
	*  @private function getLanguageConfig
	*  @param string $language
	*  @param string $table
	*/
	private function getLanguageConfig($language, $table) 
	{    
		$ret = $this->defines->getAboveDefines('Config');
		if (is_object($table)) {
			if ( $table->getVar('table_image') != '' ) 
			{
				$ret .= $this->defines->getDefine($language, "EDITOR", "Editor");
				$ret .= $this->defines->getDefine($language, "EDITOR_DESC", "Select the Editor to use");
			}
		}
		$ret .= $this->defines->getDefine($language, "KEYWORDS", "Keywords");
		$ret .= $this->defines->getDefine($language, "KEYWORDS_DESC", "Insert here the keywords (separate by comma)");		
		if (is_object($table)) {
			if ( $table->getVar('table_image') != '' ) 
			{
				$ret .= $this->defines->getDefine($language, "MAXSIZE", "Max size");
				$ret .= $this->defines->getDefine($language, "MAXSIZE_DESC", "Set a number of max size uploads file in byte");
				$ret .= $this->defines->getDefine($language, "MIMETYPES", "Mime Types");
				$ret .= $this->defines->getDefine($language, "MIMETYPES_DESC", "Set the mime types selected");
			}
		}
		$ret .= $this->defines->getDefine($language, "IDPAYPAL", "Paypal ID");
		$ret .= $this->defines->getDefine($language, "IDPAYPAL_DESC", "Insert here your PayPal ID for donactions.");
		$ret .= $this->defines->getDefine($language, "ADVERTISE", "Advertisement Code");
		$ret .= $this->defines->getDefine($language, "ADVERTISE_DESC", "Insert here the advertisement code");
		$ret .= $this->defines->getDefine($language, "BOOKMARKS", "Social Bookmarks");
		$ret .= $this->defines->getDefine($language, "BOOKMARKS_DESC", "Show Social Bookmarks in the form");
		$ret .= $this->defines->getDefine($language, "FBCOMMENTS", "Facebook comments");
		$ret .= $this->defines->getDefine($language, "FBCOMMENTS_DESC", "Allow Facebook comments in the form");		
		return $ret;
	}
	/*
	*  @private function getLanguageNotifications
	*  @param string $language
	*  @param mixed $table
	*/
	private function getLanguageNotifications($language) 
	{    
		$ret = $this->defines->getAboveDefines('Notifications');
		$ret .= $this->defines->getDefine($language, "GLOBAL_NOTIFY", "Global notify");
		$ret .= $this->defines->getDefine($language, "GLOBAL_NOTIFY_DESC", "Global notify desc");
		$ret .= $this->defines->getDefine($language, "CATEGORY_NOTIFY", "Category notify");
		$ret .= $this->defines->getDefine($language, "CATEGORY_NOTIFY_DESC", "Category notify desc");
		$ret .= $this->defines->getDefine($language, "FILE_NOTIFY", "File notify");
		$ret .= $this->defines->getDefine($language, "FILE_NOTIFY_DESC", "File notify desc");
		$ret .= $this->defines->getDefine($language, "GLOBAL_NEWCATEGORY_NOTIFY", "Global newcategory notify");
		$ret .= $this->defines->getDefine($language, "GLOBAL_NEWCATEGORY_NOTIFY_CAPTION", "Global newcategory notify caption");	
		$ret .= $this->defines->getDefine($language, "GLOBAL_NEWCATEGORY_NOTIFY_DESC", "Global newcategory notify desc");
		$ret .= $this->defines->getDefine($language, "GLOBAL_NEWCATEGORY_NOTIFY_SUBJECT", "Global newcategory notify subject");
		$ret .= $this->defines->getDefine($language, "GLOBAL_FILEMODIFY_NOTIFY", "Global filemodify notify");
		$ret .= $this->defines->getDefine($language, "GLOBAL_FILEMODIFY_NOTIFY_CAPTION", "Global filemodify notify caption");
		$ret .= $this->defines->getDefine($language, "GLOBAL_FILEMODIFY_NOTIFY_DESC", "Global filemodify notify desc");
		$ret .= $this->defines->getDefine($language, "GLOBAL_FILEMODIFY_NOTIFY_SUBJECT", "Global filemodify notify subject");
		$ret .= $this->defines->getDefine($language, "GLOBAL_FILEBROKEN_NOTIFY", "Global filebroken notify");
		$ret .= $this->defines->getDefine($language, "GLOBAL_FILEBROKEN_NOTIFY_CAPTION", "Global filebroken notify caption");	
		$ret .= $this->defines->getDefine($language, "GLOBAL_FILEBROKEN_NOTIFY_DESC", "Global filebroken notify desc");
		$ret .= $this->defines->getDefine($language, "GLOBAL_FILEBROKEN_NOTIFY_SUBJECT", "Global filebroken notify subject");
		$ret .= $this->defines->getDefine($language, "GLOBAL_FILESUBMIT_NOTIFY", "Global filesubmit notify");
		$ret .= $this->defines->getDefine($language, "GLOBAL_FILESUBMIT_NOTIFY_CAPTION", "Global filesubmit notify caption");
		$ret .= $this->defines->getDefine($language, "GLOBAL_FILESUBMIT_NOTIFY_DESC", "Global filesubmit notify desc");
		$ret .= $this->defines->getDefine($language, "GLOBAL_FILESUBMIT_NOTIFY_SUBJECT", "Global filesubmit notify subject");
		$ret .= $this->defines->getDefine($language, "GLOBAL_NEWFILE_NOTIFY", "Global newfile notify");
		$ret .= $this->defines->getDefine($language, "GLOBAL_NEWFILE_NOTIFY_CAPTION", "Global newfile notify caption");	
		$ret .= $this->defines->getDefine($language, "GLOBAL_NEWFILE_NOTIFY_DESC", "Global newfile notify desc");
		$ret .= $this->defines->getDefine($language, "GLOBAL_NEWFILE_NOTIFY_SUBJECT", "Global newfile notify subject");
		$ret .= $this->defines->getDefine($language, "CATEGORY_FILESUBMIT_NOTIFY", "Category filesubmit notify");
		$ret .= $this->defines->getDefine($language, "CATEGORY_FILESUBMIT_NOTIFY_CAPTION", "Category filesubmit notify caption");
		$ret .= $this->defines->getDefine($language, "CATEGORY_FILESUBMIT_NOTIFY_DESC", "Category filesubmit notify desc");
		$ret .= $this->defines->getDefine($language, "CATEGORY_FILESUBMIT_NOTIFY_SUBJECT", "Category filesubmit notify subject");
		$ret .= $this->defines->getDefine($language, "CATEGORY_NEWFILE_NOTIFY", "Category newfile notify");
		$ret .= $this->defines->getDefine($language, "CATEGORY_NEWFILE_NOTIFY_CAPTION", "Category newfile notify caption");	
		$ret .= $this->defines->getDefine($language, "CATEGORY_NEWFILE_NOTIFY_DESC", "Category newfile notify desc");
		$ret .= $this->defines->getDefine($language, "CATEGORY_NEWFILE_NOTIFY_SUBJECT", "Category newfile notify subject");
		$ret .= $this->defines->getDefine($language, "FILE_APPROVE_NOTIFY", "File approve notify");
		$ret .= $this->defines->getDefine($language, "FILE_APPROVE_NOTIFY_CAPTION", "File approve notify caption");
		$ret .= $this->defines->getDefine($language, "FILE_APPROVE_NOTIFY_DESC", "File approve notify desc");
		$ret .= $this->defines->getDefine($language, "FILE_APPROVE_NOTIFY_SUBJECT", "File approve notify subject");
		return $ret;
	}
	/*
	*  @private function getLanguagePermissions
	*  @param string $language
	*/
	private function getLanguagePermissions($language) 
	{    
		$ret = $this->defines->getAboveDefines('Permissions Groups');
		$ret .= $this->defines->getDefine($language, "GROUPS", "Groups access");
		$ret .= $this->defines->getDefine($language, "GROUPS_DESC", "Select general access permission for groups.");
		$ret .= $this->defines->getDefine($language, "ADMINGROUPS", "Admin Group Permissions");
		$ret .= $this->defines->getDefine($language, "ADMINGROUPS_DESC", "Which groups have access to tools and permissions page");		
		return $ret;
	}
	/*
	*  @private function getFooter
	*  @param null
	*/
	private function getLanguageFooter() 
	{    
		$ret = $this->defines->getBelowDefines('End');		
		return $ret;
	}
	/*
	*  @public function render
	*  @param null
	*/
	public function render() {    
		$module = $this->getModule();
		$table = $this->getTable();        		
		$tables = $this->getTables();
		$filename = $this->getFileName();
        $moduleDirname = $module->getVar('mod_dirname');		
		$language = $this->getLanguage($moduleDirname, 'MI');
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .= $this->getLanguageMain($language, $module);	
		$content .= $this->getLanguageMenu($language, $table, $tables);		
		if (is_object($table)) {
			if ( $table->getVar('table_admin') == 1 ) {
				$content .= $this->getLanguageAdmin($language);	
			}
			if ( $table->getVar('table_user') == 1 ) {
				$content .= $this->getLanguageUser($language);		
			}
			if ( $table->getVar('table_submenu') == 1 ) {
				$content .= $this->getLanguageSubmenu($language, $tables);
			}
			$content .= $this->getLanguageBlocks($language, $tables);
		}
		$content .= $this->getLanguageConfig($language, $table);
		if (is_object($table)) {	
			if ( $table->getVar('table_notifications') == 1 ) 
			{
				$content .= $this->getLanguageNotifications($language);
			}
			if ( $table->getVar('table_permissions') == 1 ) {
				$content .= $this->getLanguagePermissions($language);	
			}
		}
		$content .= $this->getLanguageFooter();
		//
		$this->tdmcfile->create($moduleDirname, 'language/english', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}