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
/*$fieldMid = TDMCreate_CleanVars($_REQUEST, 'field_mid');
$fieldTid = TDMCreate_CleanVars($_REQUEST, 'field_tid');
$fieldNumb = TDMCreate_CleanVars($_REQUEST, 'field_numb');  
$fieldName = TDMCreate_CleanVars($_REQUEST, 'field_name', '', 'string');*/   
$fieldMid = XoopsRequest::getInt('field_mid');
$fieldTid = XoopsRequest::getInt('field_tid');
$fieldNumb = XoopsRequest::getInt('field_numb');
$fieldName = XoopsRequest::getString('field_name'); /**/
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
		$countModules = $tdmcreate->getHandler('modules')->getCount();
		if ( $countModules == 0 ) {
			redirect_header('modules.php?op=new', 2, _AM_TDMCREATE_NOTMODULES );
		} 
		unset($countModules);	
		// Redirect if there aren't tables
		$countTables = $tdmcreate->getHandler('tables')->getCount();
		if ($countTables == 0)  {
			redirect_header('tables.php?op=new', 2, _AM_TDMCREATE_NOTTABLES );
		} 	
        unset($countTables);		
		// Get the list of tables
		$criteria = new CriteriaCompo();
		$criteria->setSort('table_id ASC, table_name');
		$criteria->setOrder('ASC');	
		$countTables = $tdmcreate->getHandler('tables')->getCount($criteria);
		$tablesAll = $tdmcreate->getHandler('tables')->getAll($criteria);
		unset($criteria);		
		if ($countTables > 0) 
		{	
			foreach (array_keys($tablesAll) as $tid) 
			{	
				// Display tables list
				$table['id'] = $tid;				
				$table['mid'] = $tablesAll[$tid]->getVar('table_mid');
                $table['name'] = ucfirst($tablesAll[$tid]->getVar('table_name'));				
				$table['image'] = $tablesAll[$tid]->getVar('table_image');	
				$table['nbfields'] = $tablesAll[$tid]->getVar('table_nbfields');
				$table['autoincrement'] = $tablesAll[$tid]->getVar('table_autoincrement');	
				$table['blocks'] = $tablesAll[$tid]->getVar('table_blocks');						
				$table['admin'] = $tablesAll[$tid]->getVar('table_admin');	
				$table['user'] = $tablesAll[$tid]->getVar('table_user');					
				$table['search'] = $tablesAll[$tid]->getVar('table_search');				
                // Get the list of fields
				$criteria = new CriteriaCompo();
				$criteria->add(new Criteria('field_mid', $table['mid']));
				$criteria->add(new Criteria('field_tid', $tid));
				$criteria->setSort('field_id ASC, field_name');
				$criteria->setOrder('ASC');	
				$countFields = $tdmcreate->getHandler('fields')->getCount($criteria);
				$fieldsAll = $tdmcreate->getHandler('fields')->getObjects($criteria);
				unset($criteria);
				// Display fields list
				$fields = array();
				$lid = 1;
				if ( $countFields > 0 ) 
				{					
					foreach (array_keys($fieldsAll) as $fid) 
					{						
						$field['id'] = $fid;
						$field['lid'] = $lid;
						$field['name'] = str_replace('_', ' ', ucfirst($fieldsAll[$fid]->getVar('field_name')));
						$field['parent'] = $fieldsAll[$fid]->getVar('field_parent');
						$field['inlist'] = $fieldsAll[$fid]->getVar('field_inlist');
						$field['inform'] = $fieldsAll[$fid]->getVar('field_inform');
						$field['admin'] = $fieldsAll[$fid]->getVar('field_admin');	
						$field['user'] = $fieldsAll[$fid]->getVar('field_user');
						$field['block'] = $fieldsAll[$fid]->getVar('field_block');
						$field['main'] = $fieldsAll[$fid]->getVar('field_main');
						$field['search'] = $fieldsAll[$fid]->getVar('field_search');
						$field['required'] = $fieldsAll[$fid]->getVar('field_required');
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
			if ( $countTables > $limit ) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new XoopsPageNav($countTables, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			} 			
		} else {
			$GLOBALS['xoopsTpl']->assign('error', _AM_TDMCREATE_THEREARENT_FIELDS);
		}
		var_dump($fieldMid);
		var_dump($fieldTid);
		var_dump($fieldNumb);
		var_dump($fieldName);
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
		$form = $fieldsObj->getFormNew($fieldMid, $fieldTid, $fieldNumb, $fieldName);
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		// Test -> Will be removed
		var_dump($fieldMid);
		var_dump($fieldTid);
		var_dump($fieldNumb);
		var_dump($fieldName);		
    break;	
	
	case 'save':
		//
		if ( !$GLOBALS['xoopsSecurity']->check() ) {
            redirect_header('fields.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }	
		$fieldId = XoopsRequest::getInt('field_id');
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
			if (isset($fieldMid) && isset($fieldTid) && !empty($_POST['field_name'][$key])) {
				// Set Data		
				$fieldsObj->setVar( 'field_mid', $fieldMid );
				$fieldsObj->setVar( 'field_tid', $fieldTid );								
				$fieldsObj->setVar( 'field_numb', $fieldNumb );
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
		$tables =& $tdmcreate->getHandler('tables')->get($fieldTid);
		$table_name = $tables->getVar('table_name');
		// Set field elements
		if ($fieldsObj->isNew()) {		    
			// Fields Elements Handler
			$fieldelementObj =& $tdmcreate->getHandler('fieldelements')->create();
			$fieldelementObj->setVar( 'fieldelement_mid', $fieldMid );
			$fieldelementObj->setVar( 'fieldelement_tid', $fieldTid );
			$fieldelementObj->setVar( 'fieldelement_name', 'Table : '.ucfirst($table_name) );
			$fieldelementObj->setVar( 'fieldelement_value', 'XoopsFormTables-'.ucfirst($table_name) );
			// Insert new field element id for table name
			if (!$tdmcreate->getHandler('fieldelements')->insert($fieldelementObj) ) {
				$GLOBALS['xoopsTpl']->assign('error', $fieldelementObj->getHtmlErrors() . ' Field element');
			}			
			redirect_header('fields.php', 2, sprintf(_AM_TDMCREATE_FIELDS_FORM_SAVED_OK, $table_name));					
		} else {
			redirect_header('fields.php', 2, sprintf(_AM_TDMCREATE_FIELDS_FORM_UPDATED_OK, $table_name));
		}
        //
		$GLOBALS['xoopsTpl']->assign('error', $fieldsObj->getHtmlErrors()); 		      
		$form = $fieldsObj->getForm(null, $fieldTid);
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
		$fieldId = XoopsRequest::getInt('field_id');
		$fieldsObj = $tdmcreate->getHandler('fields')->get( $fieldId );        		
		$form = $fieldsObj->getFormEdit($fieldMid, $fieldTid);
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		// Test -> Will be removed
		var_dump($fieldTid);
	break;

    case 'drag':        
        $side = TDMCreate_CleanVars( $_POST, 'field_id', 0, 'int' );
		$fieldId = XoopsRequest::getInt('field_id');
        if ( $fieldId > 0 ) {
            $fieldsObj = $tdmcreate->getHandler('fields')->get( $fieldId );
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
		//
		$fields = $tdmcreate->getHandler('fields');
		// Fields Handler
		foreach($_REQUEST['field_id'] as $key => $value)
		{
			/*$fieldId = XoopsRequest::getInt('field_id');
			$fieldParent = XoopsRequest::getInt('field_parent');
			$fieldInlist = XoopsRequest::getInt('field_inlist');
			$fieldInform = XoopsRequest::getInt('field_inform');
			$fieldAdmin = XoopsRequest::getInt('field_admin');
			$fieldUser = XoopsRequest::getInt('field_user');
			$fieldBlock = XoopsRequest::getInt('field_block');
			$fieldMain = XoopsRequest::getInt('field_main');
			$fieldSearch = XoopsRequest::getInt('field_search');
			$fieldRequired = XoopsRequest::getInt('field_required');*/	
			
			$fieldsObj =& $fields->get($value);				         
			/*$fieldsObj->setVar('field_parent', $fieldParent);
			$fieldsObj->setVar('field_inlist', $fieldInlist);
			$fieldsObj->setVar('field_inform', $fieldInform);
			$fieldsObj->setVar('field_admin', $fieldAdmin);
			$fieldsObj->setVar('field_user', $fieldUser);
			$fieldsObj->setVar('field_block', $fieldBlock);
			$fieldsObj->setVar('field_main', $fieldMain);	
			$fieldsObj->setVar('field_search', $fieldSearch);
			$fieldsObj->setVar('field_required', $fieldRequired);*/
			$fieldsObj->setVar( 'field_parent', $_POST['field_parent'][$key]);
			$fieldsObj->setVar( 'field_inlist', $_POST['field_inlist'][$key]);
			$fieldsObj->setVar( 'field_inform', $_POST['field_inform'][$key]);
			$fieldsObj->setVar( 'field_admin', $_POST['field_admin'][$key]);
			$fieldsObj->setVar( 'field_user', $_POST['field_user'][$key]); 
			$fieldsObj->setVar( 'field_block', $_POST['field_block'][$key]); 
			$fieldsObj->setVar( 'field_main', $_POST['field_main'][$key]); 
			$fieldsObj->setVar( 'field_search',  $_POST['field_search'][$key]); 
			$fieldsObj->setVar( 'field_required', $_POST['field_required'][$key]);	
			//
			$fields->insert($fieldsObj, true);			
		}
		redirect_header('fields.php', 3, _AM_TDMCREATE_TOGGLE_SUCCESS);		       
    break;	
}
include 'footer.php';