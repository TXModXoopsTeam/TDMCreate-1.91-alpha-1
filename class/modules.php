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
 * modules class
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         tdmcreate
 * @since           2.5.x
 * @author          TDM TEAM DEV MODULE
 * @version         $Id: modules.php 12209 2013-10-23 02:49:09Z beckmi $
 * @version         $Id: modules.php 12400 2014-02-13 10:22:12Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

/*
*  @Class TDMCreateModules
*  @extends XoopsObject 
*/
class TDMCreateModules extends XoopsObject
{ 
	/**
     * Instance of TDMCreate class
     *
     * @var mixed
     */
	private $tdmcreate = null;
	/*
	*  @public function constructor class
	*  @param null
	*/
	public function __construct()
	{
		$this->tdmcreate = TDMCreateHelper::getInstance();
		$this->initVar('mod_id',XOBJ_DTYPE_INT);
		$this->initVar('mod_name',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('name'));
		$this->initVar('mod_dirname',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('dirname'));
		$this->initVar('mod_version',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('version'));
		$this->initVar('mod_since',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('since'));
		$this->initVar('mod_min_php',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('min_php'));
		$this->initVar('mod_min_xoops',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('min_xoops'));
		$this->initVar('mod_min_admin',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('min_admin'));
		$this->initVar('mod_min_mysql',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('min_mysql'));
		$this->initVar('mod_description',XOBJ_DTYPE_TXTAREA, $this->tdmcreate->getConfig('description'));
		$this->initVar('mod_author',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('author'));
		$this->initVar('mod_author_mail',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('author_email'));
		$this->initVar('mod_author_website_url',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('author_website_url'));
        $this->initVar('mod_author_website_name',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('author_website_name'));
		$this->initVar('mod_credits',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('credits'));
		$this->initVar('mod_license',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('license'));
		$this->initVar('mod_release_info',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('release_info'));
		$this->initVar('mod_release_file',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('release_file'));
		$this->initVar('mod_manual',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('manual'));
		$this->initVar('mod_manual_file',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('manual_file'));
		$this->initVar('mod_image',XOBJ_DTYPE_TXTBOX, null);
		$this->initVar('mod_demo_site_url',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('demo_site_url'));
		$this->initVar('mod_demo_site_name',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('demo_site_name'));
		$this->initVar('mod_support_url',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('support_url'));
        $this->initVar('mod_support_name',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('support_name'));
		$this->initVar('mod_website_url',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('website_url'));
		$this->initVar('mod_website_name',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('website_name'));
		$this->initVar('mod_release',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('release_date'));
		$this->initVar('mod_status',XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('status'));
		$this->initVar('mod_admin',XOBJ_DTYPE_INT, $this->tdmcreate->getConfig('display_admin'));		
		$this->initVar('mod_user',XOBJ_DTYPE_INT, $this->tdmcreate->getConfig('display_user'));
		$this->initVar('mod_blocks',XOBJ_DTYPE_INT, $this->tdmcreate->getConfig('active_blocks'));
		$this->initVar('mod_search',XOBJ_DTYPE_INT, $this->tdmcreate->getConfig('active_search'));
		$this->initVar('mod_comments',XOBJ_DTYPE_INT, $this->tdmcreate->getConfig('active_comments'));
		$this->initVar('mod_notifications', XOBJ_DTYPE_INT, $this->tdmcreate->getConfig('active_notifications'));
        $this->initVar('mod_permissions', XOBJ_DTYPE_INT, $this->tdmcreate->getConfig('active_permissions'));	
        $this->initVar('mod_inroot_copy', XOBJ_DTYPE_INT, $this->tdmcreate->getConfig('inroot_copy'));			
		$this->initVar('mod_donations', XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('donations'));
		$this->initVar('mod_subversion', XOBJ_DTYPE_TXTBOX, $this->tdmcreate->getConfig('subversion'));
	}
	
	/**
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        $arg = isset($args[0]) ? $args[0] : null;
        return $this->getVar($method, $arg);
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
	*  @public function getForm
	*  @param mixed $action
	*/
	public function getForm($action = false)
    {
		global $sysPathIcon32;
		//
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
		//
        $isNew = $this->isNew();
		$title = $isNew ? sprintf(_AM_TDMCREATE_MODULE_NEW) : sprintf(_AM_TDMCREATE_MODULE_EDIT);
		//
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
		//
        $form = new XoopsThemeForm($title, 'modulesform', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		//
		$form->insertBreak('<div class="center"><b>'._AM_TDMCREATE_MODULE_IMPORTANT.'</b></div>','head');
		//
		$mod_name = new XoopsFormText(_AM_TDMCREATE_MODULE_NAME, 'mod_name', 50, 255, $this->getVar('mod_name'));
		$mod_name->setDescription(_AM_TDMCREATE_MODULE_NAME_DESC);
		$form->addElement($mod_name, true);
		//
		$mod_dirname = new XoopsFormText(_AM_TDMCREATE_MODULE_DIRNAME, 'mod_dirname', 25, 255, $this->getVar('mod_dirname'));
		$mod_dirname->setDescription(_AM_TDMCREATE_MODULE_DIRNAME_DESC);
		$form->addElement($mod_dirname, true);
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_VERSION, 'mod_version', 10, 25, $this->getVar('mod_version')), true);
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_SINCE, 'mod_since', 10, 25, $this->getVar('mod_since')), true);
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_MIN_PHP, 'mod_min_php', 10, 25, $this->getVar('mod_min_php')), true);
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_MIN_XOOPS, 'mod_min_xoops', 10, 25, $this->getVar('mod_min_xoops')), true);
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_MIN_ADMIN, 'mod_min_admin', 10, 25, $this->getVar('mod_min_admin')), true);
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_MIN_MYSQL, 'mod_min_mysql', 10, 25, $this->getVar('mod_min_mysql')), true);
		// Name description
        $editor_configs=array();
        $editor_configs['name'] = 'mod_description';
        $editor_configs['value'] = $this->getVar('mod_description', 'e');
        $editor_configs['rows'] = 5;
        $editor_configs['cols'] = 100;
        $editor_configs['width'] = '50%';
        $editor_configs['height'] = '100px';
        $editor_configs['editor'] = $this->tdmcreate->getConfig('tdmcreate_editor');
        $form->addElement( new XoopsFormEditor(_AM_TDMCREATE_MODULE_DESCRIPTION, 'mod_description', $editor_configs), true);
		// Author
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_AUTHOR, 'mod_author', 50, 255, $this->getVar('mod_author')), true);
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_LICENSE, 'mod_license', 50, 255, $this->getVar('mod_license')), true);
		//
		$mod_admin = $isNew ? $this->tdmcreate->getConfig('display_admin') : $this->getVar('mod_admin');
		$form->addElement(new XoopsFormRadioYN(_AM_TDMCREATE_MODULE_ADMIN, 'mod_admin', $mod_admin, _YES, _NO), true);		
		//
		$mod_user = $isNew ? $this->tdmcreate->getConfig('display_user') : $this->getVar('mod_user');
		$form->addElement(new XoopsFormRadioYN(_AM_TDMCREATE_MODULE_USER, 'mod_user', $mod_user, _YES, _NO), true);
		//
		$mod_blocks = $isNew ? $this->tdmcreate->getConfig('active_blocks') : $this->getVar('mod_blocks');
		$form->addElement(new XoopsFormRadioYN(_AM_TDMCREATE_MODULE_BLOCKS, 'mod_blocks', $mod_blocks, _YES, _NO), true);
		//
		$mod_search = $isNew ? $this->tdmcreate->getConfig('active_search') : $this->getVar('mod_search');
		$form->addElement(new XoopsFormRadioYN(_AM_TDMCREATE_MODULE_SEARCH, 'mod_search', $mod_search, _YES, _NO), true);
		//
		$mod_comments = $isNew ? $this->tdmcreate->getConfig('active_comments') : $this->getVar('mod_comments');
		$form->addElement(new XoopsFormRadioYN(_AM_TDMCREATE_MODULE_COMMENTS, 'mod_comments', $mod_comments, _YES, _NO), true);
		//
		$mod_notifications = $isNew ? $this->tdmcreate->getConfig('active_notifications') : $this->getVar('mod_notifications');
		$form->addElement(new XoopsFormRadioYN(_AM_TDMCREATE_MODULE_NOTIFICATIONS, 'mod_notifications', $mod_notifications, _YES, _NO), true);
		//
		$mod_permissions = $isNew ? $this->tdmcreate->getConfig('active_permissions') : $this->getVar('mod_permissions');
		$form->addElement(new XoopsFormRadioYN(_AM_TDMCREATE_MODULE_PERMISSIONS, 'mod_permissions', $mod_permissions, _YES, _NO), true);
		//
		$mod_inroot_copy = $isNew ? $this->tdmcreate->getConfig('inroot_copy') : $this->getVar('mod_inroot_copy');
		$form->addElement(new XoopsFormRadioYN(_AM_TDMCREATE_MODULE_INROOT_MODULES_COPY, 'mod_inroot_copy', $mod_inroot_copy, _YES, _NO), true);
		//
		$this_image = $this->getVar('mod_image');
		$mod_image = $this_image ? $this_image : 'empty.png';
		//
		$uploadirectory = 'uploads/'.$GLOBALS['xoopsModule']->dirname().'/images/repository';
		$imgtray = new XoopsFormElementTray(_AM_TDMCREATE_MODULE_IMAGE, '<br />');
		$imgpath = sprintf(_AM_TDMCREATE_FORMIMAGE_PATH, './' . strtolower($uploadirectory) . '/');
		$imageselect= new XoopsFormSelect($imgpath, 'mod_image', $mod_image);
		$mod_image_array = XoopsLists::getImgListAsArray( TDMC_UPLOAD_IMGMOD_PATH );
		foreach( $mod_image_array as $image ) {
			$imageselect->addOption("{$image}", $image);
		}
		$imageselect->setExtra( "onchange='showImgSelected(\"image3\", \"mod_image\", \"" . $uploadirectory . "\", \"\", \"" . XOOPS_URL . "\")'" );
		$imgtray->addElement($imageselect);
		$imgtray->addElement( new XoopsFormLabel( '', "<br /><img src='" . TDMC_UPLOAD_IMGMOD_URL . "/" . $mod_image . "' name='image3' id='image3' alt='' /><br />" ) );
		//
        $fileseltray = new XoopsFormElementTray('', '<br />');
		$fileseltray->addElement(new XoopsFormFile(_AM_TDMCREATE_FORMUPLOAD, 'attachedfile', $this->tdmcreate->getConfig('maxsize')));
		$fileseltray->addElement(new XoopsFormLabel(''));
		$imgtray->addElement($fileseltray);
		$form->addElement($imgtray);
		//---------- START LOGO GENERATOR -----------------    
		$tables_img = $this->getVar('table_image') ? $this->getVar('table_image') : 'about.png';
		$iconsdir = '/Frameworks/moduleclasses/icons/32';
		if(is_dir(XOOPS_ROOT_PATH . $iconsdir)){
			$uploadirectory = $iconsdir; 
			$imgpath = sprintf(_AM_TDMCREATE_FORMIMAGE_PATH, ".{$iconsdir}/");
		} else {
			$uploadirectory = "/uploads/".$GLOBALS['xoopsModule']->dirname()."/images/tables";
			$imgpath = sprintf(_AM_TDMCREATE_FORMIMAGE_PATH, "./uploads/".$GLOBALS['xoopsModule']->dirname()."/images/tables");
		}
		$createLogoTray = new XoopsFormElementTray('Create new Logo','<br />');
		$iconSelect= new XoopsFormSelect($imgpath, 'tables_img', $tables_img, 8);
		$tables_img_array = XoopsLists::getImgListAsArray( XOOPS_ROOT_PATH . $uploadirectory );
		foreach( $tables_img_array as $image ) {
			$iconSelect->addOption("{$image}", $image);
		}
		$iconSelect->setExtra( "onchange='showImgSelected2(\"image4\", \"tables_img\", \"" . $uploadirectory . "\", \"\", \"".XOOPS_URL."\")'" );
		$createLogoTray->addElement($iconSelect);
		$createLogoTray -> addElement( new XoopsFormLabel( '', "<br /><img src='".XOOPS_URL."/".$uploadirectory."/".$tables_img."' name='image4' id='image4' alt='' />" ) );
		// Create preview and submit buttons
		$buttonLogoGenerator4= new XoopsFormButton('', 'button4', "Create New Logo", 'button');
		$buttonLogoGenerator4->setExtra("onclick='createNewModuleLogo(\"" . XOOPS_URL . "\")'");
		$createLogoTray->addElement($buttonLogoGenerator4);
		//
		$form->addElement($createLogoTray);
		//------------ END LOGO GENERATOR --------------------
		//        
		$form->insertBreak('<div class="center"><b>'._AM_TDMCREATE_MODULE_NOTIMPORTANT.'</b></div>','head');		
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_AUTHOR_MAIL, 'mod_author_mail', 50, 255, $this->getVar('mod_author_mail')));
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_AUTHOR_WEBSITE_URL, 'mod_author_website_url', 50, 255, $this->getVar('mod_author_website_url')));
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_AUTHOR_WEBSITE_NAME, 'mod_author_website_name', 50, 255, $this->getVar('mod_author_website_name')));
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_CREDITS, 'mod_credits', 50, 255, $this->getVar('mod_credits')));
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_RELEASE_INFO, 'mod_release_info', 50, 255, $this->getVar('mod_release_info')));
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_RELEASE_FILE, 'mod_release_file', 50, 255, $this->getVar('mod_release_file')));
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_MANUAL, 'mod_manual', 50, 255, $this->getVar('mod_manual')));
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_MANUAL_FILE, 'mod_manual_file', 50, 255, $this->getVar('mod_manual_file')));
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_DEMO_SITE_URL, 'mod_demo_site_url', 50, 255, $this->getVar('mod_demo_site_url')));
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_DEMO_SITE_NAME, 'mod_demo_site_name', 50, 255, $this->getVar('mod_demo_site_name')));
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_SUPPORT_URL, 'mod_support_url', 50, 255, $this->getVar('mod_support_url')));
        //
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_SUPPORT_NAME, 'mod_support_name', 50, 255, $this->getVar('mod_support_name')));
        //
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_WEBSITE_URL, 'mod_website_url', 50, 255, $this->getVar('mod_website_url')));
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_WEBSITE_NAME, 'mod_website_name', 50, 255, $this->getVar('mod_website_name')));
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_RELEASE, 'mod_release', 50, 255, $this->getVar('mod_release')));
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_STATUS, 'mod_status', 50, 255, $this->getVar('mod_status')));		
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_PAYPAL_BUTTON, 'mod_donations', 50, 255, $this->getVar('mod_donations')));
		//
		$form->addElement(new XoopsFormText(_AM_TDMCREATE_MODULE_SUBVERSION, 'mod_subversion', 50, 255, $this->getVar('mod_subversion')));
		//
		$form->addElement(new XoopsFormHidden('op', 'save'));
        $form->addElement(new XoopsFormButton(_REQUIRED.' <span class="red bold">*</span>', 'submit', _SUBMIT, 'submit'));
        return $form;
	}
	
	/*
	*  @private static function createLogo
	*  @param mixed $logoIcon
	*  @param string $moduleName
	*/
	private static function createLogo($logoIcon, $moduleName)
	{
		global $pathIcon32;
		
		if (!extension_loaded("gd")) {
			return false;
		} else {
			$required_functions = array("imagecreatefrompng", "imagefttext", "imagecopy", "imagepng", "imagedestroy", "imagecolorallocate");
			foreach ($required_functions as $func) {
				if (!function_exists($func)) {
					return false;
				}
			}
		}

		// $dirname = $GLOBALS['xoopsModule']->dirname();
		$iconFileName = $pathIcon32 . '/' . basename($logoIcon);

		$dirlogos = TDMC_PATH . "/images/logos";		
		if (!file_exists($imageBase = $dirlogos . "/empty.png") || 
			!file_exists($font = $dirlogos . "/VeraBd.ttf") || 
			!file_exists($iconFile = $iconFileName)) {
			return false;
		}

		$imageModule = imagecreatefrompng($imageBase);
		$imageIcon = imagecreatefrompng($iconFile);

		// Write text
		$text_color = imagecolorallocate($imageModule, 0, 0, 0);
		$space_to_border = (92 - strlen($moduleName) * 7.5) / 2;
		imagefttext($imageModule, 8.5, 0, $space_to_border, 45, $text_color, $font, ucfirst($moduleName), array());

		imagecopy($imageModule, $imageIcon, 29, 2, 0, 0, 32, 32);

		$targetImage = TDMC_UPLOAD_IMGMOD_URL . "/" . $moduleName . "_logo.png";
		
		imagepng($imageModule, $targetImage );

		imagedestroy($imageModule);
		imagedestroy($imageIcon);

		return XOOPS_URL . $targetImage;
	}
}
/*
*  @Class TDMCreateModulesHandler
*  @extends XoopsPersistableObjectHandler
*/
class TDMCreateModulesHandler extends XoopsPersistableObjectHandler
{
    /*
	*  @public function constructor class
	*  @param mixed $db
	*/
	public function __construct(&$db) 
    {
        parent::__construct($db, 'tdmcreate_modules', 'tdmcreatemodules', 'mod_id', 'mod_name');
    }
}