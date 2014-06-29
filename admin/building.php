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
//
switch ($op) {
	case 'build':		 
		$template_main = 'tdmcreate_building.tpl';	
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('building.php'));
		// Get var module dirname
		$mod_dirname = $moduleObj->getVar('mod_dirname');
		// Directories for copy from to
		$from_dir = TDMC_UPLOAD_REPOSITORY_PATH.'/'.strtolower($mod_dirname);
		$to_dir = XOOPS_ROOT_PATH.'/modules/'.strtolower($mod_dirname);
		if(isset($mod_dirname)) {
			// Clear this module if it's in repository
			if(is_dir($from_dir)) {
				TDMCreate_clearDir($from_dir);
			}
			// Clear this module if it's in root/modules
			if(is_dir($to_dir)) {
				TDMCreate_clearDir($to_dir);
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
		$GLOBALS['xoopsTpl']->assign('building_directory', sprintf(_AM_TDMCREATE_BUILDING_DIRECTORY, $mod_dirname));
		// Copy this module in root modules
		if ( $moduleObj->getVar('mod_inroot_copy') == 1 ) {	
			TDMCreate_copyr($from_dir, $to_dir);
        }
	break;
	
	case 'default':
	default:
		$template_main = 'tdmcreate_building.tpl';	
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('building.php'));	
		// Redirect if there aren't modules
		$nb_modules = $tdmcreate->getHandler('modules')->getCount();
		if ( $nb_modules == 0 ) {
			redirect_header('modules.php?op=new', 2, _AM_TDMCREATE_NOTMODULES );
		} 
		unset($nb_modules);	
		// Redirect if there aren't tables
		$nb_tables = $tdmcreate->getHandler('tables')->getCount();
		if ($nb_tables == 0)  {
			redirect_header('tables.php?op=new', 2, _AM_TDMCREATE_NOTTABLES );
		}  
		unset($nb_tables);	
		include_once TDMC_PATH . '/class/building.php';
		$handler = TDMCreateBuilding::getInstance();
		$form = $handler->getForm();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
	break;
}
include 'footer.php';