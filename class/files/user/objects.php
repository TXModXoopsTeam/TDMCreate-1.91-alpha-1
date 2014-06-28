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
 * @version         $Id: user_objects.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class UserObjects
{	
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
	*  @public function getCodeUserHeader
	*  @param string $fieldname
	*/
	public function getCodeUserHeader($fieldname) {    
		$ret = <<<EOT
include_once 'header.php';
\$xoopsOption['template_main'] = '{$fieldname}.tpl';
include_once XOOPS_ROOT_PATH.'/header.php';\n	
EOT;
		return $ret;
	}
	/*
	*  @public function getCodeUserIndex
	*  @param null
	*/
	public function getCodeUserIndex() {    
		$ret = <<<EOT
include_once 'header.php';
\$xoopsOption['template_main'] = 'index.tpl';
include_once XOOPS_ROOT_PATH.'/header.php';\n	
EOT;
		return $ret;
	}
	/*
	*  @public function getCodeUserFooter
	*  @param null
	*/
	public function getCodeUserFooter() {    
		$ret = <<<EOT
include_once 'footer.php';	
EOT;
		return $ret;
	}	
}