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
 * @version         $Id: 1.91 fields.php 12258 2014-01-02 09:33:29Z timgno $
 */
include 'header.php';
// Recovered value of arguments op in the URL $ 
$op = XoopsRequest::getString('op', 'list');
// Get fields Variables
$field_mid = TDMCreate_CleanVars($_REQUEST, 'field_mid');
$field_tid = TDMCreate_CleanVars($_REQUEST, 'field_tid');
$field_numb = TDMCreate_CleanVars($_REQUEST, 'field_numb');  
$field_name = TDMCreate_CleanVars($_REQUEST, 'field_name', '', 'string');/**/   
/*$field_mid = XoopsRequest::getInt('field_mid');
$field_tid = XoopsRequest::getInt('field_tid');
$field_numb = XoopsRequest::getInt('field_numb');
$field_name = XoopsRequest::getString('field_name', ''); */
//
switch ($op) 
{   
    case 'list': 
    default:
        $start = XoopsRequest::getInt('start', 0);
		$limit = XoopsRequest::getInt('limit', $tdmcreate->getConfig('tables_adminpager'));
		// Define main template
		$template_main = 'tdmcreate_fields.tpl';
		$GLOBALS['xoTheme']->addStylesheet( 'modules/TDMCreate/assets/css/admin/style.css' );
		$GLOBALS['xoTheme']->addScript('modules/TDMCreate/assets/js/functions.js');
		$GLOBALS['xoTheme']->addScript('modules/TDMCreate/assets/js/fields.js');
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('fields.php'));
		$adminMenu->addItemButton(_AM_TDMCREATE_ADD_TABLE, 'tables.php?op=new', 'add');            
		$GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton()); 
		$GLOBALS['xoopsTpl']->assign('tdmc_url', TDMC_URL);
		$GLOBALS['xoopsTpl']->assign('tdmc_icons_url', TDMC_ICONS_URL);
		$GLOBALS['xoopsTpl']->assign('tdmc_upload_url', TDMC_UPLOAD_URL);
		$GLOBALS['xoopsTpl']->assign('tdmc_upload_imgtab_url', TDMC_UPLOAD_IMGTAB_URL);
		$GLOBALS['xoopsTpl']->assign('modPathIcon16', $modPathIcon16);
		$GLOBALS['xoopsTpl']->assign('sysPathIcon32', $sysPathIcon32);
		//var_dump($sysPathIcon32);
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
		// Get the list of tables
		$criteria = new CriteriaCompo();
		$criteria->setSort('table_id ASC, table_name');
		$criteria->setOrder('ASC');	
		$nb_tables = $tdmcreate->getHandler('tables')->getCount($criteria);
		$tables_arr = $tdmcreate->getHandler('tables')->getAll($criteria);
		unset($criteria);		
		if ($nb_tables > 0) 
		{	
			foreach (array_keys($tables_arr) as $tid) 
			{	
				// Display tables list
				$table['id'] = $tid;				
				$table['mid'] = $tables_arr[$tid]->getVar('table_mid');
                $table['name'] = ucfirst($tables_arr[$tid]->getVar('table_name'));				
				$table['image'] = $tables_arr[$tid]->getVar('table_image');	
				$table['nbfields'] = $tables_arr[$tid]->getVar('table_nbfields');	
				$table['blocks'] = $tables_arr[$tid]->getVar('table_blocks');						
				$table['admin'] = $tables_arr[$tid]->getVar('table_admin');	
				$table['user'] = $tables_arr[$tid]->getVar('table_user');					
				$table['search'] = $tables_arr[$tid]->getVar('table_search');									
                // Get the list of fields
				$criteria = new CriteriaCompo();
				$criteria->add(new Criteria('field_tid', $tid));
				$criteria->setSort('field_id ASC, field_name');
				$criteria->setOrder('ASC');	
				$nb_fields = $tdmcreate->getHandler('fields')->getCount($criteria);
				$fields_arr = $tdmcreate->getHandler('fields')->getObjects($criteria);
				unset($criteria);
				// Display fields list
				$fields = array();
				$lid = 1;
				if ( $nb_fields > 0 ) 
				{ 	
					foreach (array_keys($fields_arr) as $fid) 
					{	
						$field['id'] = $fid;
						$field['lid'] = $lid;
						$field['name'] = str_replace('_', ' ', ucfirst($fields_arr[$fid]->getVar('field_name')));
						$field['parent'] = $fields_arr[$fid]->getVar('field_parent');
						$field['inlist'] = $fields_arr[$fid]->getVar('field_inlist');
						$field['inform'] = $fields_arr[$fid]->getVar('field_inform');
						$field['admin'] = $fields_arr[$fid]->getVar('field_admin');	
						$field['user'] = $fields_arr[$fid]->getVar('field_user');
						$field['block'] = $fields_arr[$fid]->getVar('field_block');
						$field['main'] = $fields_arr[$fid]->getVar('field_main');
						$field['search'] = $fields_arr[$fid]->getVar('field_search');
						$field['required'] = $fields_arr[$fid]->getVar('field_required');
						$fields[] = $field;
						unset($field);	
                        $lid++;						
					}									
				} 
				unset($lid);
				$table['fields'] = $fields;	    			
				$GLOBALS['xoopsTpl']->append('tables_list', $table);                
				unset($table);				
			}
			if ( $nb_tables > $limit ) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new XoopsPageNav($nb_tables, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			} 			
		} else {
			$GLOBALS['xoopsTpl']->assign('error', _AM_TDMCREATE_THEREARENT_FIELDS);
		}	
	break;
	
    case 'new': 
		// Define main template
		$template_main = 'tdmcreate_fields.tpl';
		$GLOBALS['xoTheme']->addStylesheet( 'modules/TDMCreate/assets/css/admin/style.css' );
		$GLOBALS['xoTheme']->addScript('modules/TDMCreate/assets/js/fields.js');
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('fields.php'));
		$adminMenu->addItemButton(_AM_TDMCREATE_TABLES_LIST, 'tables.php', 'list'); 
		$adminMenu->addItemButton(_AM_TDMCREATE_FIELDS_LIST, 'fields.php', 'list');           
		$GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
		// Form Add
        $fieldsObj =& $tdmcreate->getHandler('fields')->create();        	
		$form = $fieldsObj->getFormNew($field_mid, $field_tid, $field_numb, $field_name);
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		// Test -> Will be removed
		var_dump($field_mid);
		var_dump($field_tid);
		var_dump($field_numb);
		var_dump($field_name);		
    break;	
	
	case 'save':
		//
		if ( !$GLOBALS['xoopsSecurity']->check() ) {
            redirect_header('fields.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }	
		$field_id = XoopsRequest::getInt('field_id');
		// Fields Handler
		$fields = $tdmcreate->getHandler('fields');		
		// Set Variables		
		foreach($_POST['field_id'] as $key => $value) 
		{				
			switch($value){
				case 'new':
					$fieldsObj =& $fields->create();					
				break;
				default:					
					$fieldsObj =& $fields->get($value);									
				break;					
			}            			
			if (isset($field_mid) && isset($field_tid) && !empty($_POST['field_name'][$key])) {
				// Set Data		
				$fieldsObj->setVar( 'field_mid', $field_mid );
				$fieldsObj->setVar( 'field_tid', $field_tid );								
				$fieldsObj->setVar( 'field_numb', $field_numb );
				$fieldsObj->setVar( 'field_name', (isset($_POST['field_name'][$key]) ? $_POST['field_name'][$key] : '') );
				$fieldsObj->setVar( 'field_type', (isset($_POST['field_type'][$key]) ? $_POST['field_type'][$key] : '') ); 
				$fieldsObj->setVar( 'field_value', (isset($_POST['field_value'][$key]) ? $_POST['field_value'][$key] : '') );
				$fieldsObj->setVar( 'field_attribute', (isset($_POST['field_attribute'][$key]) ? $_POST['field_attribute'][$key] : '') );
				$fieldsObj->setVar( 'field_null', (isset($_POST['field_null'][$key]) ? $_POST['field_null'][$key] : '') ); 
				$fieldsObj->setVar( 'field_default', (isset($_POST['field_default'][$key]) ? $_POST['field_default'][$key] : '') ); 
				$fieldsObj->setVar( 'field_key', (isset($_POST['field_key'][$key]) ? $_POST['field_key'][$key] : '') );							
				$fieldsObj->setVar( 'field_element', (isset($_POST['field_element'][$key]) ? $_POST['field_element'][$key] : '') );                
				$fieldsObj->setVar( 'field_parent', ((isset($_REQUEST['field_parent'][$key]) == 1) ? 1 : 0) );
				$fieldsObj->setVar( 'field_inlist', ((isset($_REQUEST['field_inlist'][$key]) == 1) ? 1 : 0) );
				$fieldsObj->setVar( 'field_inform', ((isset($_REQUEST['field_inform'][$key]) == 1) ? 1 : 0) );
				$fieldsObj->setVar( 'field_admin', ((isset($_REQUEST['field_admin'][$key]) == 1) ? 1 : 0) );
				$fieldsObj->setVar( 'field_user', ((isset($_REQUEST['field_user'][$key]) == 1) ? 1 : 0) ); 
				$fieldsObj->setVar( 'field_block', ((isset($_REQUEST['field_block'][$key]) == 1) ? 1 : 0) ); 
				$fieldsObj->setVar( 'field_main', (($key == isset($_REQUEST['field_main'][$key])) ? 1 : 0) ); 
				$fieldsObj->setVar( 'field_search',  ((isset($_REQUEST['field_search'][$key]) == 1) ? 1 : 0) ); 
				$fieldsObj->setVar( 'field_required', ((isset($_REQUEST['field_required'][$key]) == 1) ? 1 : 0) );		
				// Insert Data
				$tdmcreate->getHandler('fields')->insert($fieldsObj);
			}
		}
		// Get table name from field table id
		$tables =& $tdmcreate->getHandler('tables')->get($field_tid);
		$table_name = $tables->getVar('table_name');
		// Set field elements
		if ($fieldsObj->isNew()) {		    
			// Fields Elements Handler
			$fieldelementObj =& $tdmcreate->getHandler('fieldelements')->create();
			$fieldelementObj->setVar( 'fieldelement_mid', $field_mid );
			$fieldelementObj->setVar( 'fieldelement_tid', $field_tid );
			$fieldelementObj->setVar( 'fieldelement_name', 'Table : '.ucfirst($table_name) );
			$fieldelementObj->setVar( 'fieldelement_value', 'XoopsFormTables-'.ucfirst($table_name) );
			// Insert new field element id for table name
			if (!$tdmcreate->getHandler('fieldelements')->insert($fieldelementObj) ) {
				$GLOBALS['xoopsTpl']->assign('error', $fieldelementObj->getHtmlErrors() . ' Field element');
			}			
			redirect_header('fields.php', 2, sprintf(_AM_TDMCREATE_FIELD_FORM_SAVED_OK, $table_name));					
		} else {
			redirect_header('fields.php', 2, sprintf(_AM_TDMCREATE_FIELD_FORM_UPDATED_OK, $table_name));
		}
        //
		$GLOBALS['xoopsTpl']->assign('error', $fieldsObj->getHtmlErrors()); 		      
		$form = $fieldsObj->getForm(null, $field_tid);
		$GLOBALS['xoopsTpl']->assign('form', $form->render());		
	break;
	
	case 'edit':
		// Define main template
		$template_main = 'tdmcreate_fields.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('fields.php'));
		$adminMenu->addItemButton(_AM_TDMCREATE_ADD_TABLE, 'tables.php?op=new', 'add');
		$adminMenu->addItemButton(_AM_TDMCREATE_TABLES_LIST, 'tables.php', 'list');
		$adminMenu->addItemButton(_AM_TDMCREATE_FIELDS_LIST, 'fields.php', 'list');           
		$GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
		// Form Edit
		$field_id = XoopsRequest::getInt('field_id');
		$fieldsObj = $tdmcreate->getHandler('fields')->get( $field_id );        		
		$form = $fieldsObj->getFormEdit($field_mid, $field_tid);
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		// Test -> Will be removed
		var_dump($field_tid);
	break;

    case 'drag':        
        $side = TDMCreate_CleanVars( $_POST, 'field_id', 0, 'int' );
		$field_id = XoopsRequest::getInt('field_id');
        if ( $field_id > 0 ) {
            $fieldsObj = $tdmcreate->getHandler('fields')->get( $field_id );
            $fieldsObj->setVar('field_id', $side);
            if (!$tdmcreate->getHandler('fields')->insert( $fieldsObj )) {
                redirect_header('fields.php', 5, _AM_TDMCREATE_FIELD_SIDE_ERROR);
            }
        }
    break;

    case 'order':        
        if ( isset($_POST['field_id'] ) ) {
            $i = 0;
            foreach($_POST['field_id'] as $order) {
                if( $order > 0 ) {
                    $fieldsObj = $tdmcreate->getHandler('fields')->get( $order );
                    $fieldsObj->setVar('field_id', $i);
                    if (!$tdmcreate->getHandler('fields')->insert( $fieldsObj )) {
                        redirect_header('fields.php', 5, _AM_TDMCREATE_FIELD_ORDER_ERROR);
                    }
                    $i++;
                }
            }
			unset($i);
        }
        exit;
    break;	
	
	case 'display':
		// Get the list of fields
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('field_tid', $field_tid));
	    $fields = $tdmcreate->getHandler('fields')->getObjects($criteria);
        $fieldsObj =& $tdmcreate->getHandler('fields')->get($field_id);
		if (isset($_GET['field_tid'])) {
            if (isset($_GET['field_parent'])) {
				foreach ($fields as $field) {
					$fld_parent = $field->getVar('field_parent');                
					$field_parent = ($field->getVar('field_id') == $fld_parent) ? '1' : '0';				
					$fieldsObj->setVar('field_parent', $field_parent);
				}
            } elseif (isset($_GET['field_inlist'])) {
                $fld_inlist = intval($_GET['field_inlist']);                
				$field_inlist = ($fld_inlist == 1) ? '0' : '1';				
				$fieldsObj->setVar('field_inlist', $field_inlist);
            } elseif (isset($_GET['field_inform'])) {
                $fld_inform = intval($_GET['field_inform']);                
				$field_inform = ($fld_inform == 1) ? '0' : '1';				
				$fieldsObj->setVar('field_inform', $field_inform);
            } elseif (isset($_GET['field_admin'])) {
                $fld_admin = intval($_GET['field_admin']);                
				$field_admin = ($fld_admin == 1) ? '0' : '1';				
				$fieldsObj->setVar('field_admin', $field_admin);
            } elseif (isset($_GET['field_user'])) {
                $fld_user = intval($_GET['field_user']);                
				$field_user = ($fld_user == 1) ? '0' : '1';				
				$fieldsObj->setVar('field_user', $field_user);
            } elseif (isset($_GET['field_block'])) {
                $fld_block = intval($_GET['field_block']);                
				$field_block = ($fld_block == 1) ? '0' : '1';				
				$fieldsObj->setVar('field_block', $field_block);
            } elseif (isset($_GET['field_main'])) {               
				foreach ($fields as $field) {
					$fld_main = $field->getVar('field_main');                
					$field_main = ($field->getVar('field_id') == $fld_main) ? '1' : '0';				
					$fieldsObj->setVar('field_main', $field_main);
				}
            } elseif (isset($_GET['field_search'])) {
                $fld_search = intval($_GET['field_search']);                
				$field_search = ($fld_search == 1) ? '0' : '1';				
				$fieldsObj->setVar('field_search', $field_search);
            } elseif (isset($_GET['field_required'])) {
                $fld_required = intval($_GET['field_required']);                
				$field_required = ($fld_required == 1) ? '0' : '1';				
				$fieldsObj->setVar('field_required', $field_required);
            }
			if ($tdmcreate->getHandler('fields')->insert($fieldsObj, true)) {
				redirect_header('fields.php', 3, _AM_TDMCREATE_TOGGLE_SUCCESS);
			} else {
				redirect_header('fields.php', 3, _AM_TDMCREATE_TOGGLE_FAILED);
			}
        }
    break;	
}
include 'footer.php';