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
 * @version         $Id: tables.php 12258 2014-01-02 09:33:29Z timgno $
*/
include 'header.php';
// Recovered value of arguments op in the URL $ 
$op = XoopsRequest::getString('op', 'list');
//
$mod_id = XoopsRequest::getInt('mod_id');
//
$table_id = XoopsRequest::getInt('table_id');
$table_mid = XoopsRequest::getInt('table_mid');
$table_nbfields = XoopsRequest::getInt('table_nbfields');
$table_fieldname = XoopsRequest::getString('table_fieldname', '');
//
switch ($op) 
{   
	case 'list': 
	default: 
		$start = XoopsRequest::getInt('start', 0);
        $limit = XoopsRequest::getInt('limit', $tdmcreate->getConfig('modules_adminpager'));
		// Define main template
		$template_main = 'tdmcreate_tables.tpl';
		$GLOBALS['xoTheme']->addStylesheet( 'modules/TDMCreate/assets/css/admin/style.css' );
		$GLOBALS['xoTheme']->addScript('modules/TDMCreate/assets/js/functions.js');
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('tables.php'));
		$adminMenu->addItemButton(_AM_TDMCREATE_ADD_TABLE, 'tables.php?op=new', 'add');            
		$GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton()); 
		$GLOBALS['xoopsTpl']->assign('tdmc_url', TDMC_URL);
		$GLOBALS['xoopsTpl']->assign('tdmc_icons_url', TDMC_ICONS_URL);
		$GLOBALS['xoopsTpl']->assign('tdmc_upload_imgmod_url', TDMC_UPLOAD_IMGMOD_URL);		
        /*$tdmc_upload_image_url = is_dir($sysPathIcon32) ? $sysPathIcon32 : TDMC_UPLOAD_IMGTAB_PATH;
		$GLOBALS['xoopsTpl']->assign('tdmc_table_image_url', $tdmc_upload_image_url);*/
		$GLOBALS['xoopsTpl']->assign('tdmc_upload_imgtab_url', TDMC_UPLOAD_IMGTAB_URL);
		$GLOBALS['xoopsTpl']->assign('modPathIcon16', $modPathIcon16);
		$GLOBALS['xoopsTpl']->assign('sysPathIcon32', $sysPathIcon32);
		// Get the list of modules
		$criteria = new CriteriaCompo();
		$criteria->setSort('mod_id ASC, mod_name');
		$criteria->setOrder('ASC');        
		$nb_modules = $tdmcreate->getHandler('modules')->getCount($criteria);
		// Redirect if there aren't modules
		if ( $nb_modules == 0 ) {
			redirect_header('modules.php?op=new', 2, _AM_TDMCREATE_NOTMODULES );
		}       
		$mods_arr = $tdmcreate->getHandler('modules')->getAll($criteria);
		unset($criteria);	
        $nb_tables = $tdmcreate->getHandler('tables')->getObjects(null);
		// Redirect if there aren't tables
		if ($nb_tables == 0)  {
			redirect_header('tables.php?op=new', 2, _AM_TDMCREATE_NOTTABLES );
		} 	
        unset($nb_tables);		
		// Display modules list
		if ( $nb_modules > 0 ) 
		{			       					
			foreach (array_keys($mods_arr) as $i) 
			{				
				$mod['id'] = $i;				
				$mod['name'] = $mods_arr[$i]->getVar('mod_name');					
				$mod['image'] = $mods_arr[$i]->getVar('mod_image');					
				$mod['admin'] = $mods_arr[$i]->getVar('mod_admin');	
				$mod['user'] = $mods_arr[$i]->getVar('mod_user');					
				$mod['search'] = $mods_arr[$i]->getVar('mod_search');				
				$mod['comments'] = $mods_arr[$i]->getVar('mod_comments');	
				$mod['notifications'] = $mods_arr[$i]->getVar('mod_notifications');
                $mod['permissions'] = $mods_arr[$i]->getVar('mod_permissions');					
				// Get the list of tables
				$criteria = new CriteriaCompo();
				$criteria->add(new Criteria('table_mid', $i));
				$criteria->setSort('table_id ASC, table_name');
				$criteria->setOrder('ASC');	
				$nb_tables = $tdmcreate->getHandler('tables')->getCount($criteria);
				$tables_arr = $tdmcreate->getHandler('tables')->getAll($criteria);
				unset($criteria);
				// Display tables list
				$tables = array();
				$lid = 1;
				if ( $nb_tables > 0 ) 
				{ 	
					foreach (array_keys($tables_arr) as $t) 
					{	
						$table['id'] = $t;
						$table['lid'] = $lid;
						$table['mid'] = $tables_arr[$t]->getVar('table_mid');
						$table['name'] = ucfirst($tables_arr[$t]->getVar('table_name'));					
						$table['image'] = $tables_arr[$t]->getVar('table_image');	
						$table['nbfields'] = $tables_arr[$t]->getVar('table_nbfields');	
						$table['blocks'] = $tables_arr[$t]->getVar('table_blocks');						
						$table['admin'] = $tables_arr[$t]->getVar('table_admin');	
						$table['user'] = $tables_arr[$t]->getVar('table_user');	
						$table['submenu'] = $tables_arr[$t]->getVar('table_submenu');	
						$table['search'] = $tables_arr[$t]->getVar('table_search');				
						$table['comments'] = $tables_arr[$t]->getVar('table_comments');	
						$table['notifications'] = $tables_arr[$t]->getVar('table_notifications');
						$table['permissions'] = $tables_arr[$t]->getVar('table_permissions');
						$tables[] = $table;
						unset($table);					
						$lid++;						
					}									
				} 
				unset($lid);
				$mod['tables'] = $tables;	    			
				$GLOBALS['xoopsTpl']->append('modules_list', $mod);                
				unset($mod);
			}	            
			if ( $nb_modules > $limit ) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new XoopsPageNav($nb_modules, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			} 			
		} else {
			$GLOBALS['xoopsTpl']->assign('error', _AM_TDMCREATE_THEREARENT_TABLES);
		}
	break;

	case 'new': 
		// Define main template
		$template_main = 'tdmcreate_tables.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('tables.php'));
		$adminMenu->addItemButton(_AM_TDMCREATE_TABLES_LIST, 'tables.php', 'list');            
		$GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());	

		$tablesObj =& $tdmcreate->getHandler('tables')->create();
		$form = $tablesObj->getForm();		
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
	break;

	case 'save':
		if ( !$GLOBALS['xoopsSecurity']->check() ) {
			redirect_header('tables.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		$tables =& $tdmcreate->getHandler('tables');				
		if (!isset($table_id)) {
			// Checking if table name exist
			$table_name_search = $tables->getObjects(null);
			foreach (array_keys($table_name_search) as $t) 
			{
				if( ($table_name_search[$t]->getVar('table_name') === $_POST['table_name']) &&
					($table_name_search[$t]->getVar('table_mid') === $table_mid) &&
					($table_name_search[$t]->getVar('table_id') === $table_id)) {
					redirect_header('tables.php?op=new', 10, sprintf(_AM_TDMCREATE_ERROR_TABLE_NAME_EXIST, $_POST['table_name']));
					exit();
				} 
			}	
        } else {
			if (isset($table_id)) {
				$tablesObj =& $tables->get($table_id);
			} else {			
				$tablesObj =& $tables->create();							
			}			
			// Form save tables
			$tablesObj->setVars(array('table_mid' => $table_mid, 
								'table_name' => $_POST['table_name'],
								'table_category' => (($_REQUEST['table_category'] == 1) ? '1' : '0'), 
								'table_nbfields' => $table_nbfields, 
								'table_fieldname' => $table_fieldname));
			//Form table_image	
			include_once XOOPS_ROOT_PATH.'/class/uploader.php';
			$framePathIcon32 = XOOPS_ROOT_PATH . '/Frameworks/moduleclasses/icons/32';
			$uploaddir = is_dir($framePathIcon32) ? $framePathIcon32 : TDMC_UPLOAD_IMGTAB_PATH;			
			$uploader = new XoopsMediaUploader($uploaddir, $tdmcreate->getConfig('mimetypes'), 
														   $tdmcreate->getConfig('maxsize'), null, null);
			if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {							
				$uploader->fetchMedia($_POST['xoops_upload_file'][0]);
				if (!$uploader->upload()) {
					$errors = $uploader->getErrors();
					redirect_header('javascript:history.go(-1)', 3, $errors);
				} else {
					$tablesObj->setVar('table_image', $uploader->getSavedFileName());
				}
			} else {
				$tablesObj->setVar('table_image', $_POST['table_image']);
			}		
			$tablesObj->setVars(array('table_blocks' => (($_REQUEST['table_blocks'] == 1) ? '1' : '0'), 
								'table_admin' => (($_REQUEST['table_admin'] == 1) ? '1' : '0'), 
								'table_user' => (($_REQUEST['table_user'] == 1) ? '1' : '0'), 
								'table_submenu' => (($_REQUEST['table_submenu'] == 1) ? '1' : '0'), 
								'table_search' => (($_REQUEST['table_search'] == 1) ? '1' : '0'), 
								'table_comments' => (($_REQUEST['table_comments'] == 1) ? '1' : '0'), 
								'table_notifications' => (($_REQUEST['table_notifications'] == 1) ? '1' : '0'),
								'table_permissions' => (($_REQUEST['table_permissions'] == 1) ? '1' : '0')));        
			//
			if( $tables->insert($tablesObj) ) {	 
				if( $tablesObj->isNew() ) { 
					$table_iid = $GLOBALS['xoopsDB']->getInsertId();
					$table_action='&field_mid='.$table_mid.'&field_tid='.$table_iid.'&field_numb='.$table_nbfields.'&field_name='.$table_fieldname;	
					redirect_header('fields.php?op=new'.$table_action, 5, sprintf(_AM_TDMCREATE_TABLE_FORM_SAVED_OK, $_POST['table_name']));
				} else {
					// Get fields where table id					
					$fields =& $tdmcreate->getHandler('fields');
					$fieldsObj = $fields->get($table_id);
					$fieldsObj->setVar('field_numb', $table_nbfields);
					$fields->insert($fieldsObj);
					redirect_header('tables.php', 5, sprintf(_AM_TDMCREATE_TABLE_FORM_UPDATED_OK, $_POST['table_name']));
				}
			}
		}
		//
		$GLOBALS['xoopsTpl']->assign('error', $tablesObj->getHtmlErrors());        
		$form = $tablesObj->getForm();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
	break;

	case 'edit':	    		
		// Define main template            			
		$template_main = 'tdmcreate_tables.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('tables.php'));
		$adminMenu->addItemButton(_AM_TDMCREATE_ADD_TABLE, 'tables.php?op=new', 'add');	
        $adminMenu->addItemButton(_AM_TDMCREATE_TABLES_LIST, 'tables.php?op=list', 'list');			
		$GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());			
		
		$tablesObj = $tdmcreate->getHandler('tables')->get($table_id);
		$form = $tablesObj->getForm();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
	break;	

	case 'delete':
		$tablesObj =& $tdmcreate->getHandler('tables')->get($table_id);
		if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
			if ( !$GLOBALS['xoopsSecurity']->check() ) {
				redirect_header('tables.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if ($tdmcreate->getHandler('tables')->delete($tablesObj)) {
				redirect_header('tables.php', 3, _AM_TDMCREATE_FORMDELOK);
			} else {
				echo $tablesObj->getHtmlErrors();
			}
		} else {
			xoops_confirm(array('ok' => 1, 'table_id' => $table_id, 'op' => 'delete'), $_SERVER['REQUEST_URI'], sprintf(_AM_TDMCREATE_FORMSUREDEL, $tablesObj->getVar('table_name')));
		}
	break;

    case 'display':
		$table_blocks = XoopsRequest::getInt('table_blocks');
		$table_admin = XoopsRequest::getInt('table_admin');
		$table_user = XoopsRequest::getInt('table_user');
		$table_submenu = XoopsRequest::getInt('table_submenu');
		$table_search = XoopsRequest::getInt('table_search');
		$table_comments = XoopsRequest::getInt('table_comments');
		$table_notifications = XoopsRequest::getInt('table_notifications');
		$table_permissions = XoopsRequest::getInt('table_permissions');	
		
		if ( $table_id > 0 ) {          
			$tablesObj =& $tdmcreate->getHandler('tables')->get($table_id);
            if(isset($table_blocks)) {			
				$tablesObj->setVar('table_blocks', $table_blocks);
			} elseif(isset($table_adminm)) {			
				$tablesObj->setVar('table_admin', $table_admin);
			} elseif(isset($table_user)) {
				$tablesObj->setVar('table_user', $table_user);
			} elseif(isset($table_submenu)) {
				$tablesObj->setVar('table_submenu', $table_submenu);
			} elseif(isset($table_search)) {
				$tablesObj->setVar('table_search', $table_search);
			} elseif(isset($table_comments)) {
				$tablesObj->setVar('table_comments', $table_comments);
			} elseif(isset($table_notifications)) {
				$tablesObj->setVar('table_notifications', $table_notifications);
			} elseif(isset($table_permissions)) {
				$tablesObj->setVar('table_permissions', $table_permissions);
			}
			if ($tdmcreate->getHandler('tables')->insert($tablesObj, true)) {
				redirect_header('modules.php', 1, _AM_TDMCREATE_TOGGLE_SUCCESS);
			} else {
				redirect_header('modules.php', 1, _AM_TDMCREATE_TOGGLE_FAILED);
			}
        }	
    break;	
}
include 'footer.php';