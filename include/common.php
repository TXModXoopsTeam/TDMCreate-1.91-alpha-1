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
 * @version         $Id: common.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');
$dirname = $GLOBALS['xoopsModule']->getVar('dirname');
// Local Directories
define('TDMC_PATH', XOOPS_ROOT_PATH . '/modules/' . $dirname );
define('TDMC_URL', XOOPS_URL . '/modules/' . $dirname );
define('TDMC_IMAGE_PATH', TDMC_PATH . '/assets/images' );
define('TDMC_IMAGE_URL', TDMC_URL . '/assets/images' );
define('TDMC_ICONS_PATH', TDMC_IMAGE_PATH . '/icons' );
define('TDMC_ICONS_URL', TDMC_IMAGE_URL . '/icons' );
// Uploads Directories
define('TDMC_UPLOAD_PATH', XOOPS_UPLOAD_PATH . '/' . $dirname );
define('TDMC_UPLOAD_URL', XOOPS_UPLOAD_URL . '/' . $dirname );
define('TDMC_UPLOAD_REPOSITORY_PATH', TDMC_UPLOAD_PATH . '/repository' );
define('TDMC_UPLOAD_REPOSITORY_URL', TDMC_UPLOAD_URL . '/repository' );
define('TDMC_UPLOAD_IMGMOD_PATH', TDMC_UPLOAD_PATH . '/images/repository' );
define('TDMC_UPLOAD_IMGMOD_URL', TDMC_UPLOAD_URL . '/images/repository' );
define('TDMC_UPLOAD_IMGTAB_PATH', TDMC_UPLOAD_PATH . '/images/tables' );
define('TDMC_UPLOAD_IMGTAB_URL', TDMC_UPLOAD_URL . '/images/tables' );
// Xoops Request
include_once XOOPS_ROOT_PATH . '/class/xoopsrequest.php';
// Include files
$cf = '/class/files/';
$cfa = '/class/files/admin/';
$cfb = '/class/files/blocks/';
$cfcl = '/class/files/classes/';
$cfcs = '/class/files/css/';
$cfd = '/class/files/docs/';
$cfi = '/class/files/include/';
$cfl = '/class/files/language/';
$cfs = '/class/files/sql/';
$cftu = '/class/files/templates/user/';
$cfta = '/class/files/templates/admin/';
$cftb = '/class/files/templates/blocks/';
$cfu = '/class/files/user/';
include_once TDMC_PATH . '/class/helper.php';
include_once TDMC_PATH . '/class/session.php';
require_once TDMC_PATH . $cf .'file.php';
include_once TDMC_PATH . $cfa .'about.php';
include_once TDMC_PATH . $cfa .'footer.php';
include_once TDMC_PATH . $cfa .'header.php';
include_once TDMC_PATH . $cfa .'index.php';
include_once TDMC_PATH . $cfa .'menu.php';
include_once TDMC_PATH . $cfa .'pages.php';
include_once TDMC_PATH . $cfa .'permissions.php';
include_once TDMC_PATH . $cfb .'blocks.php';
include_once TDMC_PATH . $cfcl .'classes.php';
include_once TDMC_PATH . $cfcl .'helper.php';
include_once TDMC_PATH . $cfcs .'styles.php';
include_once TDMC_PATH . $cfd .'changelog.php';
include_once TDMC_PATH . $cfd .'docs.php';
include_once TDMC_PATH . $cfi .'comments.php';
include_once TDMC_PATH . $cfi .'comment_functions.php';
include_once TDMC_PATH . $cfi .'common.php';
include_once TDMC_PATH . $cfi .'functions.php';
include_once TDMC_PATH . $cfi .'install.php';
include_once TDMC_PATH . $cfi .'jquery.php';
include_once TDMC_PATH . $cfi .'notifications.php';
include_once TDMC_PATH . $cfi .'search.php';
include_once TDMC_PATH . $cfi .'update.php';
include_once TDMC_PATH . $cfl .'admin.php';
include_once TDMC_PATH . $cfl .'blocks.php';
include_once TDMC_PATH . $cfl .'help.php';
include_once TDMC_PATH . $cfl .'mail.php';
include_once TDMC_PATH . $cfl .'main.php';
include_once TDMC_PATH . $cfl .'modinfo.php';
include_once TDMC_PATH . $cfs .'mysql.php';
include_once TDMC_PATH . $cfta .'about.php';
include_once TDMC_PATH . $cfta .'header.php';
include_once TDMC_PATH . $cfta .'index.php';
include_once TDMC_PATH . $cfta .'footer.php';
include_once TDMC_PATH . $cfta .'pages.php';
include_once TDMC_PATH . $cftb .'blocks.php';
include_once TDMC_PATH . $cftu .'header.php';
include_once TDMC_PATH . $cftu .'index.php';
include_once TDMC_PATH . $cftu .'footer.php';
include_once TDMC_PATH . $cftu .'pages.php';
include_once TDMC_PATH . $cfu .'footer.php';
include_once TDMC_PATH . $cfu .'header.php';
include_once TDMC_PATH . $cfu .'index.php';
include_once TDMC_PATH . $cfu .'pages.php';
include_once TDMC_PATH . $cfu .'notification_update.php';
include_once TDMC_PATH . $cfu .'xoopsversion.php';