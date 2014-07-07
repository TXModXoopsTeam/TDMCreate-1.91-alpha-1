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
 * @version         $Id: building.php 12258 2014-01-02 09:33:29Z timgno $
 */
include 'header.php';
$op = XoopsRequest::getString('op', 'default');
$mid = XoopsRequest::getInt('mod_id');
$moduleObj = $tdmcreate->getHandler('modules')->get( $mid );
// Switch option
switch ($op) {
	case 'build':		 
		$template_main = 'tdmcreate_building.tpl';	
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('building.php'));
		// Get var module dirname
		$moduleDirname = $moduleObj->getVar('mod_dirname');
		// Directories for copy from to
		$fromDir = TDMC_UPLOAD_REPOSITORY_PATH.'/'.strtolower($moduleDirname);
		$toDir = XOOPS_ROOT_PATH.'/modules/'.strtolower($moduleDirname);
		if(isset($moduleDirname)) {
			// Clear this module if it's in repository
			if(is_dir($fromDir)) {
				TDMCreate_clearDir($fromDir);
			}
			// Clear this module if it's in root/modules
			if(is_dir($toDir)) {
				TDMCreate_clearDir($toDir);
			}
        }			
		// Structure			
		include_once TDMC_PATH . '/class/files/architecture.php';
		$handler = TDMCreateArchitecture::getInstance();
		$handler->getPath( TDMC_PATH );
		$handler->getUploadPath( TDMC_UPLOAD_PATH );
		// Creation of the structure of folders and files
		$base_architecture = $handler->createBaseFoldersFiles( $moduleObj );
		if($base_architecture !== false) { 
			$GLOBALS['xoopsTpl']->assign('base_architecture', true);			
		} else {
			$GLOBALS['xoopsTpl']->assign('base_architecture', false);
		}
		// Get files
		$build = array();
		$files = $handler->createFilesToBuilding( $moduleObj );
		foreach($files as $file) {
			if($file) {
				$build['list'] = $file;
			} 				
			$GLOBALS['xoopsTpl']->append('builds', $build);
		}
		unset($build);
		// Directory to saved all files        
		$GLOBALS['xoopsTpl']->assign('building_directory', sprintf(_AM_TDMCREATE_BUILDING_DIRECTORY, $moduleDirname));
		// Copy this module in root modules
		if( $moduleObj->getVar('mod_inroot_copy') == 1 ) {	
			TDMCreate_copyr($fromDir, $toDir);
        }
	break;
	
	case 'default':
	default:
		$template_main = 'tdmcreate_building.tpl';	
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('building.php'));	
		// Redirect if there aren't modules
		$nbModules = $tdmcreate->getHandler('modules')->getCount();
		if( $nbModules == 0 ) {
			redirect_header('modules.php?op=new', 2, _AM_TDMCREATE_NOTMODULES );
		} 
		unset($nbModules);	
		// Redirect if there aren't tables
		$nbTables = $tdmcreate->getHandler('tables')->getCount();
		if($nbTables == 0)  {
			redirect_header('tables.php?op=new', 2, _AM_TDMCREATE_NOTTABLES );
		}  
		unset($nbTables);	
		include_once TDMC_PATH . '/class/building.php';
		$handler = TDMCreateBuilding::getInstance();
		$form = $handler->getForm();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
	break;
}
include 'footer.php';