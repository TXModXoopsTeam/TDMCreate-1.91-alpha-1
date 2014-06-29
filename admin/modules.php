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
 * @since           2.5.5
 * @author          Txmod Xoops <support@txmodxoops.org>
 * @version         $Id: 1.59 modules.php 11297 2013-03-24 10:58:10Z timgno $
 */
include 'header.php';
// Recovered value of argument op in the URL $ 
$op = XoopsRequest::getString('op', 'list');
//
$mod_id = XoopsRequest::getInt('mod_id');
//
switch ($op)
{   
    case 'list': 
    default:		
		$start = XoopsRequest::getInt('start', 0);
        $limit = XoopsRequest::getInt('limit', $tdmcreate->getConfig('modules_adminpager'));
	    // Define main template
        $template_main = 'tdmcreate_modules.tpl'; 
		$GLOBALS['xoTheme']->addScript('modules/TDMCreate/assets/js/functions.js');
		$GLOBALS['xoTheme']->addStylesheet( 'modules/TDMCreate/assets/css/admin/style.css' );
        $GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('modules.php'));
		$adminMenu->addItemButton(_AM_TDMCREATE_ADD_MODULE, 'modules.php?op=new', 'add');            
		$GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());  
		$GLOBALS['xoopsTpl']->assign('tdmc_url', TDMC_URL);
		$GLOBALS['xoopsTpl']->assign('tdmc_upload_imgmod_url', TDMC_UPLOAD_IMGMOD_URL);
		$GLOBALS['xoopsTpl']->assign('modPathIcon16', $modPathIcon16);
		$GLOBALS['xoopsTpl']->assign('sysPathIcon32', $sysPathIcon32);
		$criteria = new CriteriaCompo();
		$criteria->setSort('mod_id ASC, mod_name');
		$criteria->setOrder('ASC');
		$nb_modules = $tdmcreate->getHandler('modules')->getCount( $criteria );		
		$mods_arr = $tdmcreate->getHandler('modules')->getAll( $criteria );
		unset($criteria); 
		// Redirect if there aren't modules
		if ( $nb_modules == 0 ) {
			redirect_header('modules.php?op=new', 2, _AM_TDMCREATE_NOTMODULES );
		}
		// Display modules list
		if ( $nb_modules > 0 ) {            						
			foreach (array_keys($mods_arr) as $i) {				
				$mod['id'] = $i;
                $mod['name'] = $mods_arr[$i]->getVar('mod_name');	
				$mod['version'] = $mods_arr[$i]->getVar('mod_version');	
                $mod['image'] = $mods_arr[$i]->getVar('mod_image');				
				$mod['release'] = $mods_arr[$i]->getVar('mod_release');	
				$mod['status'] = $mods_arr[$i]->getVar('mod_status');	
				$mod['admin'] = $mods_arr[$i]->getVar('mod_admin');	
				$mod['user'] = $mods_arr[$i]->getVar('mod_user');	
				$mod['search'] = $mods_arr[$i]->getVar('mod_search');				
				$mod['comments'] = $mods_arr[$i]->getVar('mod_comments');	
				$mod['notifications'] = $mods_arr[$i]->getVar('mod_notifications');
				$mod['permissions'] = $mods_arr[$i]->getVar('mod_permissions');
				$GLOBALS['xoopsTpl']->append('modules_list', $mod);
                unset($mod);				
			}
			if ( $nb_modules > $limit ) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new XoopsPageNav($nb_modules, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			} 		
		} else {
			$GLOBALS['xoopsTpl']->assign('error', _AM_TDMCREATE_THEREARENT_MODULES);
		}		
    break;

    case 'new': 
	    // Define main template
        $template_main = 'tdmcreate_modules.tpl'; 
		$GLOBALS['xoTheme']->addScript('modules/TDMCreate/assets/js/functions.js');
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('modules.php'));
        $adminMenu->addItemButton(_AM_TDMCREATE_MODULES_LIST, 'modules.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
        
        $obj =& $tdmcreate->getHandler('modules')->create();
        $form = $obj->getForm();			
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
    break;	
	
	case 'save':
		if ( !$GLOBALS['xoopsSecurity']->check() ) {
           redirect_header('modules.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($mod_id)) {
           $obj =& $tdmcreate->getHandler('modules')->get($mod_id);
        } else {
           $obj =& $tdmcreate->getHandler('modules')->create();
        }		
		//Form module save		
		$obj->setVars(array('mod_name' => $_POST['mod_name'], 
							'mod_dirname' => preg_replace('/[^a-zA-Z0-9]\s+/', '', strtolower($_POST['mod_dirname'])),
							'mod_version' => $_POST['mod_version'],
							'mod_since' => $_POST['mod_since'],
                            'mod_min_php' => $_POST['mod_min_php'], 
							'mod_min_xoops' => $_POST['mod_min_xoops'], 
                            'mod_min_admin' => $_POST['mod_min_admin'], 
							'mod_min_mysql' => $_POST['mod_min_mysql'], 							
		                    'mod_description' => $_POST['mod_description'], 
							'mod_author' => $_POST['mod_author'], 
							'mod_author_mail' => $_POST['mod_author_mail'], 
							'mod_author_website_url' => $_POST['mod_author_website_url'], 
							'mod_author_website_name' => $_POST['mod_author_website_name'], 
							'mod_credits' => $_POST['mod_credits'], 
							'mod_license' => $_POST['mod_license'], 
							'mod_release_info' => $_POST['mod_release_info'], 
							'mod_release_file' => $_POST['mod_release_file'], 
							'mod_manual' => $_POST['mod_manual'], 
							'mod_manual_file' => $_POST['mod_manual_file']));
		//Form mod_image	
		include_once XOOPS_ROOT_PATH . '/class/uploader.php';
		$uploader = new XoopsMediaUploader(TDMC_UPLOAD_IMGMOD_PATH, $tdmcreate->getConfig('mimetypes'), 
																	$tdmcreate->getConfig('maxsize'), null, null);
		if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
		    $extension = preg_replace( '/^.+\.([^.]+)$/sU' , '\\1' , $_FILES['attachedfile']['name']);
            $name_img = strtolower($_POST['mod_name']).'_slogo.'.$extension;
			$uploader->setPrefix($name_img);
			$uploader->fetchMedia($_POST['xoops_upload_file'][0]);
			if (!$uploader->upload()) {
				$errors = $uploader->getErrors();
				redirect_header('javascript:history.go(-1)',3, $errors);
			} else {
				$obj->setVar('mod_image', $uploader->getSavedFileName());
			}
		} else {
			$obj->setVar('mod_image', $_POST['mod_image']);
		}		
		//Form module save		
		$obj->setVars(array('mod_demo_site_url' => $_POST['mod_demo_site_url'], 
		                    'mod_demo_site_name' => $_POST['mod_demo_site_name'], 
							'mod_support_url' => $_POST['mod_support_url'], 
							'mod_support_name' => $_POST['mod_support_name'], 
							'mod_website_url' => $_POST['mod_website_url'], 
							'mod_website_name' => $_POST['mod_website_name'], 
							'mod_release' => $_POST['mod_release'], 
							'mod_status' => $_POST['mod_status'],
							'mod_admin' => (($_REQUEST['mod_admin'] == 1) ? '1' : '0'),
							'mod_user' => (($_REQUEST['mod_user'] == 1) ? '1' : '0'),							
							'mod_search' => (($_REQUEST['mod_search'] == 1) ? '1' : '0'),
							'mod_comments' => (($_REQUEST['mod_comments'] == 1) ? '1' : '0'),
							'mod_notifications' => (($_REQUEST['mod_notifications'] == 1) ? '1' : '0'),
							'mod_permissions' => (($_REQUEST['mod_permissions'] == 1) ? '1' : '0'),
							'mod_inroot_copy' => (($_REQUEST['mod_inroot_copy'] == 1) ? '1' : '0'),
							'mod_donations' => $_POST['mod_donations'], 
							'mod_subversion' => $_POST['mod_subversion'])
					);
		
        if ($tdmcreate->getHandler('modules')->insert($obj)) {
            redirect_header('modules.php', 2, _AM_TDMCREATE_FORMOK);
        }

        $GLOBALS['xoopsTpl']->assign('error', $obj->getHtmlErrors());
        $form =& $obj->getForm();		
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
	break;
	
	case 'edit':	 
	    // Define main template
        $template_main = 'tdmcreate_modules.tpl'; 
		$GLOBALS['xoTheme']->addScript('modules/TDMCreate/assets/js/functions.js');
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('modules.php'));
        $adminMenu->addItemButton(_AM_TDMCREATE_ADD_MODULE, 'modules.php?op=new', 'add');
		$adminMenu->addItemButton(_AM_TDMCREATE_MODULES_LIST, 'modules.php', 'list');        
        $GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
		
		$obj = $tdmcreate->getHandler('modules')->get($mod_id);
		$form = $obj->getForm();		
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
	break;
	
	case 'delete':
		$obj =& $tdmcreate->getHandler('modules')->get($mod_id);
		if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
			if ( !$GLOBALS['xoopsSecurity']->check() ) {
				redirect_header('modules.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if ($tdmcreate->getHandler('modules')->delete($obj)) {
				redirect_header('modules.php', 3, _AM_TDMCREATE_FORMDELOK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $obj->getHtmlErrors());
			}
		} else {
			xoops_confirm(array('ok' => 1, 'mod_id' => $mod_id, 'op' => 'delete'), $_SERVER['REQUEST_URI'], sprintf(_AM_TDMCREATE_FORMSUREDEL, $obj->getVar('mod_name')));
		}
	break;

	case 'display':
        $mod_admin = XoopsRequest::getInt('mod_admin');
		$mod_user = XoopsRequest::getInt('mod_user');
		$mod_search = XoopsRequest::getInt('mod_search');
		$mod_comments = XoopsRequest::getInt('mod_comments');
		$mod_notifications = XoopsRequest::getInt('mod_notifications');
		$mod_permissions = XoopsRequest::getInt('mod_permissions');	
		
		if ( $mod_id > 0 ) {          
			$obj =& $tdmcreate->getHandler('modules')->get($mod_id);
            if(isset($mod_adminm)) {
				$obj->setVar('mod_admin', $mod_admin);
			} elseif(isset($mod_user)) {
				$obj->setVar('mod_user', $mod_user);
			} elseif(isset($mod_search)) {
				$obj->setVar('mod_search', $mod_search);
			} elseif(isset($mod_comments)) {
				$obj->setVar('mod_comments', $mod_comments);
			} elseif(isset($mod_notifications)) {
				$obj->setVar('mod_notifications', $mod_notifications);
			} elseif(isset($mod_permissions)) {
				$obj->setVar('mod_permissions', $mod_permissions);
			}
			if ($tdmcreate->getHandler('modules')->insert($obj, true)) {
				redirect_header('modules.php', 1, _AM_TDMCREATE_TOGGLE_SUCCESS);
			} else {
				redirect_header('modules.php', 1, _AM_TDMCREATE_TOGGLE_FAILED);
			}
        }		
    break;
}
include 'footer.php';