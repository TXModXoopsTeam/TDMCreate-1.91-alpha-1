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
 * @version         $Id: architecture.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');
require_once 'structure.php';
/*include_once TDMC_PATH . '/include/functions.php';
spl_autoload_register('TDMCreate_autoload');*/

class TDMCreateArchitecture extends TDMCreateStructure
{	
	/*
	* @var mixed
	*/
	private $tdmcreate = null;
	/*
	* @var mixed
	*/
	private $structure = null;
	/*
	* @var mixed
	*/
	private $path = null;
	/*
	* @var mixed
	*/
	private $upload_path = null;
	/*
	*  @public function constructor class
	*  @param null
	*/
	public function __construct() {		
		$this->tdmcreate = TDMCreate::getInstance();
		$this->structure = TDMCreateStructure::getInstance();
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
	*  @public function getPath
	*  @param string $path
	*/
	public function getPath($path) {		
		$this->path = $path;
	} 
	/*
	*  @public function getUploadPath
	*  @param string $path
	*/
	public function getUploadPath($path) {		
		$this->upload_path = $path;
	} 
	/* 
	*  @public function createBaseFoldersFiles
	*  @param string $module                              
	*/
	public function createBaseFoldersFiles( $module )
	{	
		// Module
		$mod_id = $module->getVar('mod_id');       
		// Id of tables
		$criteria_tables = new CriteriaCompo();
		$criteria_tables->add(new Criteria('table_mid', $mod_id));		
		$tables = $this->tdmcreate->getHandler('tables')->getObjects($criteria_tables);
		unset($criteria_tables);
		//
		$table = null;
		foreach (array_keys($tables) as $t)
		{			
			$table_id = $tables[$t]->getVar('table_id');
			$table_name = $tables[$t]->getVar('table_name');
			$table_admin = $tables[$t]->getVar('table_admin');
			$table_user = $tables[$t]->getVar('table_user');
			$table_blocks = $tables[$t]->getVar('table_blocks');
			$table = $this->tdmcreate->getHandler('tables')->get($table_id);
		}
		//
		$indexFile = $this->path.'/index.html';	
		$docs_folder = $this->path.'/docs';
		$logos_folder = $this->path.'/assets/images/logos';
		$stl_module_name = $module->getVar('mod_dirname');
		$stl_module_author = str_replace(' ', '', strtolower($module->getVar('mod_author')));
		// Creation of the Directory in repository
		$targetDirectory = $this->upload_path.'/repository/'. $stl_module_name;			
		$upload_images_folder = $this->upload_path.'/images/repository';			
		
		// Creation of "module" folder
		$this->structure->getPath($targetDirectory);
		// Creation of "module" folder
		$this->structure->makeDir($targetDirectory);
		// Copied of index.html file in "root module" folder	
		$this->structure->copyFile('', $indexFile, 'index.html');
		if (is_object($table)) {
			if ( $table->getVar('table_admin') == 1) {
				// Creation of "admin" folder and index.html file
				$this->structure->makeDirAndCopyFile('admin', $indexFile, 'index.html');
			}
			if ( $table->getVar('table_blocks') == 1) {
				// Creation of "blocks" folder and index.html file
				$this->structure->makeDirAndCopyFile('blocks', $indexFile, 'index.html');
			}					
		}
		// Creation of "class" folder and index.html file
		$this->structure->makeDirAndCopyFile('class', $indexFile, 'index.html');
		// Creation of "assets" folder and index.html file
		$this->structure->makeDirAndCopyFile('assets', $indexFile, 'index.html');		
		// Creation of "css" folder and index.html file
		$this->structure->makeDirAndCopyFile('assets/css', $indexFile, 'index.html');
		// Creation of "images" folder and index.html file
		$this->structure->makeDirAndCopyFile('assets/images', $indexFile, 'index.html');	
		//Copy the logo of the module
		$mod_image = str_replace(' ', '', strtolower($module->getVar('mod_image')));
		$this->structure->copyFile('assets/images', $upload_images_folder.'/'.$mod_image, $mod_image);				
		// Creation of 'images/icons' folder and index.html file - Added in Version 1.15
		$this->structure->makeDirAndCopyFile('assets/images/icons', $indexFile, 'index.html');	
		// Creation of "images/icons/16" folder and index.html file
		$this->structure->makeDirAndCopyFile('assets/images/icons/16', $indexFile, 'index.html');
		// Creation of "images/icons/32" folder and index.html file
		$this->structure->makeDirAndCopyFile('assets/images/icons/32', $indexFile, 'index.html');		
		// Copy of 'module_author_logo.gif' file in uploads dir
		$logo_gif_from = $upload_images_folder.'/'.$stl_module_author.'_logo.gif';
		if (!file_exists($logo_gif_from)) {
			copy($logos_folder.'/'.$stl_module_author.'_logo.gif', $logo_gif_from);
		} 
		// Creation of 'module_author_logo.gif' file
		$this->structure->copyFile('assets/images', $logo_gif_from, $stl_module_author.'_logo.gif');	
		// Creation of "images" folder and index.html file
		$this->structure->makeDirAndCopyFile('assets/js', $indexFile, 'index.html');
		// Creation of 'docs' folder and index.html file
		$this->structure->makeDirAndCopyFile('docs', $indexFile, 'index.html');    
		// Creation of 'credits.txt' file
		$this->structure->copyFile('docs', $docs_folder.'/credits.txt', 'credits.txt');	
		// Creation of 'install.txt' file
		$this->structure->copyFile('docs', $docs_folder.'/install.txt', 'install.txt');
		// Creation of 'lang_diff.txt' file
		$this->structure->copyFile('docs', $docs_folder.'/lang_diff.txt', 'lang_diff.txt');
		// Creation of 'license.txt' file
		$this->structure->copyFile('docs', $docs_folder.'/license.txt', 'license.txt');
		// Creation of 'readme.txt' file
		$this->structure->copyFile('docs', $docs_folder.'/readme.txt', 'readme.txt');		
		// Creation of "include" folder and index.html file	
		$this->structure->makeDirAndCopyFile('include', $indexFile, 'index.html');
		// Creation of "language" folder and index.html file	
		$this->structure->makeDirAndCopyFile('language', $indexFile, 'index.html');
		// Creation of "language/local_language" folder and index.html file	
		$this->structure->makeDirAndCopyFile('language/'.$GLOBALS['xoopsConfig']['language'], $indexFile, 'index.html');	
		// Creation of "language/local_language/help" folder and index.html file	
		$this->structure->makeDirAndCopyFile('language/'.$GLOBALS['xoopsConfig']['language']. '/help', $indexFile, 'index.html');
		if (is_object($table)) {
			if (( $table->getVar('table_user') == 1) || ( $table->getVar('table_admin') == 1 )) {
				// Creation of "templates" folder and index.html file	
				$this->structure->makeDirAndCopyFile('templates', $indexFile, 'index.html');
			}
			if ( $table->getVar('table_admin') == 1 ) {
				// Creation of "templates/admin" folder and index.html file	
				$this->structure->makeDirAndCopyFile('templates/admin', $indexFile, 'index.html');	
			}
			if ( $table->getVar('table_blocks') == 1 ) {
				// Creation of "templates/blocks" folder and index.html file	
				$this->structure->makeDirAndCopyFile('templates/blocks', $indexFile, 'index.html');
			}
			if ( $table->getVar('table_name') != null ) {
				// Creation of "sql" folder and index.html file	
				$this->structure->makeDirAndCopyFile('sql', $indexFile, 'index.html');	
			}
			if ( $table->getVar('table_notifications') == 1 ) {
				// Creation of "mail_template" folder and index.html file	
				$this->structure->makeDirAndCopyFile('language/'.$GLOBALS['xoopsConfig']['language'].'/mail_template', $indexFile, 'index.html');	
			}
		}
	}	
	
	/* 
	*  @public function createBuildingFiles
	*  @param string $module
	*/
	public function createFilesToBuilding( $module )
	{	
		// Module
		$mod_id = $module->getVar('mod_id');
        $mod_dirname = $module->getVar('mod_dirname');
		$uploadTablesIcons32 = $this->upload_path.'/images/tables';
		// Id of tables
		$criteria_tables = new CriteriaCompo();
		$criteria_tables->add(new Criteria('table_mid', $mod_id));		
		$tables = $this->tdmcreate->getHandler('tables')->getObjects($criteria_tables);
		unset($criteria_tables);		
		$ret = array();
		//
		$table = null;
		foreach (array_keys($tables) as $t)
		{
			$table_mid = $tables[$t]->getVar('table_mid');
			$table_id = $tables[$t]->getVar('table_id');
			$table_name = $tables[$t]->getVar('table_name');
			$table_image = $tables[$t]->getVar('table_image');
			$table_admin = $tables[$t]->getVar('table_admin');
			$table_user = $tables[$t]->getVar('table_user');
			$table_blocks = $tables[$t]->getVar('table_blocks');
			$table_search = $tables[$t]->getVar('table_search');
			$table_comments = $tables[$t]->getVar('table_comments');
			$table_notifications = $tables[$t]->getVar('table_notifications');
			$table_permissions = $tables[$t]->getVar('table_permissions');
			// Get Table Object		
			$table = $this->tdmcreate->getHandler('tables')->get($table_id);
			// Copy of tables images file
			if( file_exists($upload_table_image = $uploadTablesIcons32.'/'.$table_image)) {
				$this->structure->copyFile('assets/images/32', $upload_table_image, $table_image);
			}										
			// Creation of admin files
			if ( $table_admin == 1) {	
				// Admin Pages File
				$adminPages = AdminPages::getInstance();
				$adminPages->write($module, $table);				
				$ret[] = $adminPages->renderFile($table_name.'.php');				
				// Admin Templates File
				$adminTemplatesPages = TemplatesAdminPages::getInstance();
				$adminTemplatesPages->write($module, $table);
				$ret[] = $adminTemplatesPages->renderFile($mod_dirname.'_admin_'.$table_name.'.tpl');
			}
			// Creation of blocks
			if ( $table_blocks == 1) {				
				// Blocks Files
				$blocksFiles = BlocksFiles::getInstance();
				$blocksFiles->write($module, $table);
				$ret[] = $blocksFiles->renderFile($table_name.'.php');
				// Templates Blocks Files
				$templatesFiles = TemplatesBlocks::getInstance();
				$templatesFiles->write($module, $table);
				$ret[] = $templatesFiles->renderFile($mod_dirname.'_block_'.$table_name.'.tpl');
			}
			// Blocks Templates File
			/*$blocksTemplates = BlocksTemplates::getInstance();
			$blocksTemplates->write($module, $table);
			$ret[] = $blocksTemplates->renderFile($table_name.'.tpl');*/
			// Creation of classes
			if ( $table_admin == 1 || $table_user == 1) {
				// Class Files
				$classFiles = ClassFiles::getInstance();
				$classFiles->write($module, $table, $tables);
				$ret[] = $classFiles->renderFile($table_name.'.php');
			}
			// Creation of user files
			if ( $table_user == 1) {
				// User Pages File
				$userPages = UserPages::getInstance();
				$userPages->write($module, $table);
				$ret[] = $userPages->renderFile($table_name.'.php');
				// User Templates File
				$userTemplatesPages = TemplatesUserPages::getInstance();
				$userTemplatesPages->write($module, $table);
				$ret[] = $userTemplatesPages->renderFile($mod_dirname.'_'.$table_name.'.tpl');
			}					
			/*var_dump($table_name); */           						
		}	
		// Language Modinfo File 
		$languageModinfo = LanguageModinfo::getInstance();	
		$languageModinfo->write($module, $table, $tables, 'modinfo.php');
		$ret[] = $languageModinfo->render();	
		// Creation of blocks language file
		if (is_object($table)) {
			if ( $table->getVar('table_blocks') == 1) {			
				// Language Blocks File 
				$languageBlocks = LanguageBlocks::getInstance();
				$languageBlocks->write($module, $tables, 'blocks.php');
				$ret[] = $languageBlocks->render();
			}		
					
			// Creation of admin files
			if ( $table->getVar('table_admin') == 1) {					
				// Admin Header File 
				$adminHeader = AdminHeader::getInstance();
				$adminHeader->write($module, $table, $tables, 'header.php');
				$ret[] = $adminHeader->render();
				// Admin Index File
				$adminIndex = AdminIndex::getInstance();
				$adminIndex->write($module, $tables, 'index.php');
				$ret[] = $adminIndex->render();
				// Admin Menu File
				$adminMenu = AdminMenu::getInstance();
				$adminMenu->write($module, $tables, 'menu.php');
				$ret[] = $adminMenu->render();
				// Creation of admin permission file
				if (( $table->getVar('table_permissions') == 1)) {
					// Admin Permissions File
					$adminPermissions = AdminPermissions::getInstance();
					$adminPermissions->write($module, $tables, 'permissions.php');
					$ret[] = $adminPermissions->render();
					// Templates Admin Permissions File
					$adminTemplatesPermissions = TemplatesAdminPermissions::getInstance();
					$adminTemplatesPermissions->write($module, $mod_dirname.'_admin_permissions.tpl');
					$ret[] = $adminTemplatesPermissions->render();
				}
				// Admin Aboutr File 
				$adminAbout = AdminAbout::getInstance();
				$adminAbout->write($module, 'about.php');				
				$ret[] = $adminAbout->render();	
				// Admin Footer File 
				$adminFooter = AdminFooter::getInstance();	
				$adminFooter->write($module, 'footer.php');
				$ret[] = $adminFooter->render();
				// Language Admin File 
				$languageAdmin = LanguageAdmin::getInstance();	
				$languageAdmin->write($module, $tables, 'admin.php');
				$ret[] = $languageAdmin->render();
				// Templates Admin About File
				$adminTemplatesAbout = TemplatesAdminAbout::getInstance();
				$adminTemplatesAbout->write($module, $mod_dirname.'_admin_about.tpl');
				$ret[] = $adminTemplatesAbout->render();
				// Templates Admin Index File
				$adminTemplatesIndex = TemplatesAdminIndex::getInstance();
				$adminTemplatesIndex->write($module, $mod_dirname.'_admin_index.tpl');
				$ret[] = $adminTemplatesIndex->render();
				// Templates Admin Footer File 
				$adminTemplatesFooter = TemplatesAdminFooter::getInstance();
				$adminTemplatesFooter->write($module, $mod_dirname.'_admin_footer.tpl');				
				$ret[] = $adminTemplatesFooter->render();	
				// Templates Admin Header File 
				$adminTemplatesHeader = TemplatesAdminHeader::getInstance();
				$adminTemplatesHeader->write($module, $mod_dirname.'_admin_header.tpl');
				$ret[] = $adminTemplatesHeader->render();
			}		
			// Creation of notifications files
			if ( $table->getVar('table_notifications') == 1 ) {
				// Include Notifications File
				$includeNotifications = IncludeNotifications::getInstance();
				$includeNotifications->write($module, $table, 'notifications.inc.php');
				$ret[] = $includeNotifications->render();
				// Language Mail Template Category File 
				$languageMailTpl = LanguageMailTpl::getInstance();	
				$languageMailTpl->write($module);
				$ret[] = $languageMailTpl->renderFile('category_new_notify.tpl');
			}
			// Include Install File
			$includeInstall = IncludeInstall::getInstance();
			$includeInstall->write($module, $table, $tables, 'install.php');
			$ret[] = $includeInstall->render();
			// Creation of sql file
			if ( $table->getVar('table_name') != null) {
				// Sql File
				$sqlFile = SqlFile::getInstance();
				$sqlFile->write($module, $tables, 'mysql.sql');
				$ret[] = $sqlFile->render();	
			}
			// Creation of search file
			if ( $table->getVar('table_search') == 1) {
				// Include Search File
				$includeSearch = IncludeSearch::getInstance();
				$includeSearch->write($module, $table, 'search.inc.php');
				$ret[] = $includeSearch->render();
			}
			// Creation of comments files
			if ( $table->getVar('table_comments') == 1) {
				// Include Comments File
				$includeComments = IncludeComments::getInstance();
				$includeComments->write($module, $table);
				$ret[] = $includeComments->renderCommentsIncludes($module, 'comment_edit');
				// Include Comments File
				$includeComments = IncludeComments::getInstance();
				$includeComments->write($module, $table);
				$ret[] = $includeComments->renderCommentsIncludes($module, 'comment_delete');
				// Include Comments File
				$includeComments = IncludeComments::getInstance();
				$includeComments->write($module, $table);
				$ret[] = $includeComments->renderCommentsIncludes($module, 'comment_post');
				// Include Comments File
				$includeComments = IncludeComments::getInstance();
				$includeComments->write($module, $table);
				$ret[] = $includeComments->renderCommentsIncludes($module, 'comment_reply');
				// Include Comments File
				$includeComments = IncludeComments::getInstance();
				$includeComments->write($module, $table);
				$ret[] = $includeComments->renderCommentsNew($module, 'comment_new');
				// Include Comment Functions File
				$includeCommentFunctions = IncludeCommentFunctions::getInstance();
				$includeCommentFunctions->write($module, $table, 'comment_functions.php');
				$ret[] = $includeCommentFunctions->renderFile();
			}
			// Creation of user files
			if ( ($table->getVar('table_user') == 1)) {							
				// Templates Index File
				$userTemplatesIndex = TemplatesUserIndex::getInstance();
				$userTemplatesIndex->write($module, $mod_dirname.'_index.tpl');
				$ret[] = $userTemplatesIndex->render();
				// Templates Footer File 
				$userTemplatesFooter = TemplatesUserFooter::getInstance();
				$userTemplatesFooter->write($module, $table, $mod_dirname.'_footer.tpl');				
				$ret[] = $userTemplatesFooter->render();	
				// Templates Header File 
				$userTemplatesHeader = TemplatesUserHeader::getInstance();
				$userTemplatesHeader->write($module, $tables, $mod_dirname.'_header.tpl');
				$ret[] = $userTemplatesHeader->render();	
				// User Footer File 
				$userFooter = UserFooter::getInstance();
				$userFooter->write($module, 'footer.php');				
				$ret[] = $userFooter->render();	
				// User Header File 
				$userHeader = UserHeader::getInstance();
				$userHeader->write($module, 'header.php');
				$ret[] = $userHeader->render();
				// User Notification Update File
				if ( ($table->getVar('table_notifications') == 1 )) {				
					$userNotificationUpdate = UserNotificationUpdate::getInstance();
					$userNotificationUpdate->write($module, 'notification_update.php');
					$ret[] = $userNotificationUpdate->render();
				}							
				// User Index File
				$userIndex = UserIndex::getInstance();
				$userIndex->write($module, 'index.php');
				$ret[] = $userIndex->render();
				// Language Main File
				$languageMain = LanguageMain::getInstance();
				$languageMain->write($module, $table, $tables, 'main.php');
				$ret[] = $languageMain->render();
			}
		}	
		// Class Helper File
		$classHelper = ClassHelper::getInstance();
		$classHelper->write($module, 'helper.php');
		$ret[] = $classHelper->render();
		// Css Styles File
		$cssStyles = CssStyles::getInstance();	
		$cssStyles->write($module, 'style.css');
		$ret[] = $cssStyles->render();	
		// Include Common File
		$includeCommon = IncludeCommon::getInstance();
		$includeCommon->write($module, 'common.php');
		$ret[] = $includeCommon->render();
		// Include Functions File
		$includeFunctions = IncludeFunctions::getInstance();
		$includeFunctions->write($module, 'functions.php');
		$ret[] = $includeFunctions->render();
		// Include Update File
		$includeUpdate = IncludeUpdate::getInstance();
		$includeUpdate->write($module, 'update.php');
		$ret[] = $includeUpdate->renderFile();
		// Docs Changelog File
		$docsChangelog = DocsChangelog::getInstance();
		$docsChangelog->write($module, 'changelog.txt');
		$ret[] = $docsChangelog->render();
		// Language Help File 
		$languageHelp = LanguageHelp::getInstance();
		$languageHelp->write($module, 'help.html');			
		$ret[] = $languageHelp->render();
		// Include Jquery File
		$includeJquery = IncludeJquery::getInstance();
		$includeJquery->write($module, 'functions.js');
		$ret[] = $includeJquery->render();		
		// User Xoops Version File
		$userXoopsVersion = UserXoopsVersion::getInstance();
		$userXoopsVersion->write($module, $table, $tables, 'xoops_version.php');
		$ret[] = $userXoopsVersion->render();
		// Return Array
		return $ret;		 
	}	
}