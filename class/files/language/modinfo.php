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

class LanguageModinfo extends TDMCreateFile
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
	*  @private function getMain
	*  @param string $language
	*  @param string $module	
	*/
	private function getMain($language, $module) {    
		$ret = <<<EOT
// Main
define('{$language}NAME', "{$module->getVar('mod_name')}");
define('{$language}DESC', "{$module->getVar('mod_description')}");\n
EOT;
		return $ret;
	}
	/*
	*  @private function getMenu
	*  @param string $language
	*  @param array $tables
	*/
	private function getMenu($language, $table, $tables) {
		$menu = 1;
		$ret = <<<EOT
// Admin Menu 
define('{$language}ADMENU{$menu}', "Dashboard");\n
EOT;
		
		foreach (array_keys($tables) as $i) 
		{   
			$menu++;
			$ucfTableName = ucfirst(str_replace('_', ' ', $tables[$i]->getVar('table_name')));			
			$ret .= <<<EOT
define('{$language}ADMENU{$menu}', "{$ucfTableName}");\n
EOT;
		}
		if (is_object($table) && $table->getVar('table_permissions') == 1) {
			$menu++;
			$ret .= <<<EOT
define('{$language}ADMENU{$menu}', "Permissions");\n
EOT;
		}
		$menu++;
		$ret .= <<<EOT
define('{$language}ADMENU{$menu}', "About");\n
EOT;
		unset( $menu );
		return $ret;
	}
	/*
	*  @private function getAdmin
	*  @param string $language
	*/
	private function getAdmin($language) { 		
		$ret = <<<EOT
// Admin
define('{$language}ADMINPAGER', "Admin pager");
define('{$language}ADMINPAGER_DESC', "Admin per page list");\n
EOT;
		return $ret;
	}
	/*
	*  @private function getSubmenu
	*  @param string $language
	*  @param array $tables
	*/
	private function getSubmenu($language, $tables) { 		
		$ret = <<<EOT
// Blocks\n
EOT;
		$i = 1;
		foreach (array_keys($tables) as $t) 
		{	
			$tableName = $tables[$t]->getVar('table_name');			
			if ( $tables[$t]->getVar('table_submenu') == 1 ) {
			$ret .= <<<EOT
define('{$language}SMNAME{$i}', "{$tableName}");\n
EOT;
			}
			$i++;
		}
		unset($i);
		return $ret;
	}
	/*
	*  @private function getBlocks
	*  @param string $language
	*  @param array $tables
	*/
	private function getBlocks($language, $tables) { 		
		$ret = <<<EOT
// Blocks\n
EOT;
		foreach (array_keys($tables) as $i) 
		{	
			$tableName = $tables[$i]->getVar('table_name');
			$language1 = $language.strtoupper($tableName);
			$ucfTableName = str_replace("_", " ", ucfirst($tableName));
			if ( $tables[$i]->getVar('table_blocks') == 1 ) {
			$ret .= <<<EOT
define('{$language1}_BLOCK', "{$ucfTableName} block");\n
EOT;
			}
		}
		return $ret;
	}
	/*
	*  @private function getUser
	*  @param string $language
	*/
	private function getUser($language) { 		
		$ret = <<<EOT
// User
define('{$language}USERPAGER', "User pager");
define('{$language}USERPAGER_DESC', "User per page list");\n
EOT;
		return $ret;
	}
	/*
	*  @private function getConfig
	*  @param string $language
	*  @param string $table_image
	*/
	private function getConfig($language, $table) {    
		$ret = <<<EOT
// Config
define('{$language}EDITOR', "Editor");
define('{$language}EDITOR_DESC', "Select the Editor to use");
define('{$language}KEYWORDS', "Keywords");
define('{$language}KEYWORDS_DESC', "Insert here the keywords (separate by comma)");\n
EOT;
		if ( $table->getVar('table_image') != '' ) 
		{
			$ret .= <<<EOT
define('{$language}MAXSIZE', "Max size");
define('{$language}MAXSIZE_DESC', "Set a number of max size uploads file in byte");
define('{$language}MIMETYPES', "Mime Types");
define('{$language}MIMETYPES_DESC', "Set the mime types selected");\n
EOT;
		}
		$ret .= <<<EOT
define('{$language}IDPAYPAL', "Paypal ID");
define('{$language}IDPAYPAL_DESC', "Insert here your PayPal ID for donactions.");
define('{$language}ADVERTISE', "Advertisement Code");
define('{$language}ADVERTISE_DESC', "Insert here the advertisement code");
define('{$language}BOOKMARKS', "Social Bookmarks");
define('{$language}BOOKMARKS_DESC', "Show Social Bookmarks in the form");
define('{$language}FBCOMMENTS', "Facebook comments");
define('{$language}FBCOMMENTS_DESC', "Allow Facebook comments in the form");\n
EOT;
		return $ret;
	}
	/*
	*  @private function getNotifications
	*  @param string $language
	*  @param mixed $table
	*/
	private function getNotifications($language) {    
		$ret = <<<EOT
// Notifications
define('{$language}GLOBAL_NOTIFY', "Allow Facebook comments in the form");
define('{$language}GLOBAL_NOTIFY_DESC', "Allow Facebook comments in the form");
define('{$language}CATEGORY_NOTIFY', "Allow Facebook comments in the form");
define('{$language}CATEGORY_NOTIFY_DESC', "Allow Facebook comments in the form");
define('{$language}FILE_NOTIFY', "Allow Facebook comments in the form");
define('{$language}FILE_NOTIFY_DESC', "Allow Facebook comments in the form");
define('{$language}GLOBAL_NEWCATEGORY_NOTIFY', "Allow Facebook comments in the form");
define('{$language}GLOBAL_NEWCATEGORY_NOTIFY_CAPTION', "Allow Facebook comments in the form");
define('{$language}GLOBAL_NEWCATEGORY_NOTIFY_DESC', "Allow Facebook comments in the form");
define('{$language}GLOBAL_NEWCATEGORY_NOTIFY_SUBJECT', "Allow Facebook comments in the form");
define('{$language}GLOBAL_FILEMODIFY_NOTIFY', "Allow Facebook comments in the form");
define('{$language}GLOBAL_FILEMODIFY_NOTIFY_CAPTION', "Allow Facebook comments in the form");
define('{$language}GLOBAL_FILEMODIFY_NOTIFY_DESC', "Allow Facebook comments in the form");
define('{$language}GLOBAL_FILEMODIFY_NOTIFY_SUBJECT', "Allow Facebook comments in the form");
define('{$language}GLOBAL_FILEBROKEN_NOTIFY', "Allow Facebook comments in the form");
define('{$language}GLOBAL_FILEBROKEN_NOTIFY_CAPTION', "Allow Facebook comments in the form");
define('{$language}GLOBAL_FILEBROKEN_NOTIFY_DESC', "Allow Facebook comments in the form");
define('{$language}GLOBAL_FILEBROKEN_NOTIFY_SUBJECT', "Allow Facebook comments in the form");
define('{$language}GLOBAL_FILESUBMIT_NOTIFY', "Allow Facebook comments in the form");
define('{$language}GLOBAL_FILESUBMIT_NOTIFY_CAPTION', "Allow Facebook comments in the form");
define('{$language}GLOBAL_FILESUBMIT_NOTIFY_DESC', "Allow Facebook comments in the form");
define('{$language}GLOBAL_FILESUBMIT_NOTIFY_SUBJECT', "Allow Facebook comments in the form");
define('{$language}GLOBAL_NEWFILE_NOTIFY', "Allow Facebook comments in the form");
define('{$language}GLOBAL_NEWFILE_NOTIFY_CAPTION', "Allow Facebook comments in the form");
define('{$language}GLOBAL_NEWFILE_NOTIFY_DESC', "Allow Facebook comments in the form");
define('{$language}GLOBAL_NEWFILE_NOTIFY_SUBJECT', "Allow Facebook comments in the form");
define('{$language}CATEGORY_FILESUBMIT_NOTIFY', "Allow Facebook comments in the form");
define('{$language}CATEGORY_FILESUBMIT_NOTIFY_CAPTION', "Allow Facebook comments in the form");
define('{$language}CATEGORY_FILESUBMIT_NOTIFY_DESC', "Allow Facebook comments in the form");
define('{$language}CATEGORY_FILESUBMIT_NOTIFY_SUBJECT', "Allow Facebook comments in the form");
define('{$language}CATEGORY_NEWFILE_NOTIFY', "Allow Facebook comments in the form");
define('{$language}CATEGORY_NEWFILE_NOTIFY_CAPTION', "Allow Facebook comments in the form");
define('{$language}CATEGORY_NEWFILE_NOTIFY_DESC', "Allow Facebook comments in the form");
define('{$language}CATEGORY_NEWFILE_NOTIFY_SUBJECT', "Allow Facebook comments in the form");
define('{$language}FILE_APPROVE_NOTIFY', "Allow Facebook comments in the form");
define('{$language}FILE_APPROVE_NOTIFY_CAPTION', "Allow Facebook comments in the form");
define('{$language}FILE_APPROVE_NOTIFY_DESC', "Allow Facebook comments in the form");
define('{$language}FILE_APPROVE_NOTIFY_SUBJECT', "Allow Facebook comments in the form");\n
EOT;
		return $ret;
	}
	/*
	*  @private function getPermissions
	*  @param string $language
	*/
	private function getPermissions($language) {    
		$ret = <<<EOT
// Permissions Groups
define('{$language}GROUPS', "Groups access");
define('{$language}GROUPS_DESC', "Select general access permission for groups.");
define('{$language}ADMINGROUPS', "Admin Group Permissions");
define('{$language}ADMINGROUPS_DESC', "Which groups have access to tools and permissions page");
EOT;
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
		$content .= $this->getMain($language, $module);	
		$content .= $this->getMenu($language, $table, $tables);		
		if (is_object($table)) {
			if ( $table->getVar('table_admin') == 1 ) {
				$content .= $this->getAdmin($language);	
			}
			if ( $table->getVar('table_user') == 1 ) {
				$content .= $this->getUser($language);		
			}
			if ( $table->getVar('table_submenu') == 1 ) {
				$content .= $this->getSubmenu($language, $tables);
			}			
			$content .= $this->getBlocks($language, $tables);
			$content .= $this->getConfig($language, $table);
			if ( $table->getVar('table_notifications') == 1 ) 
			{
				$content .= $this->getNotifications($language);
			}
			if ( $table->getVar('table_permissions') == 1 ) {
				$content .= $this->getPermissions($language);	
			}
		}
		//
		$this->tdmcfile->create($moduleDirname, 'language/'.$GLOBALS['xoopsConfig']['language'], $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}