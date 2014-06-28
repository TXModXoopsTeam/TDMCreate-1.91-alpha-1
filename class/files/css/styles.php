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
 * @version         $Id: 1.91 css_styles.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class CssStyles extends TDMCreateFile
{	
	/*
	*  @public function constructor
	*  @param null
	*/
	public function __construct() { 		
		$this->tdmcfile = TDMCreateFile::getInstance();		
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
	*  @public function write
	*  @param string $module
	*  @param string $filename	
	*/
	public function write($module, $filename) {    
		$this->setModule($module);
		$this->setFileName($filename);
	}
	/*
	*  @public function render
	*  @param null
	*/
	public function render() {    
        $module = $this->getModule();
		$filename = $this->getFileName();
		$module_name = strtolower($module->getVar('mod_name'));
		//$content = $this->getHeaderFilesComments($module, $filename);
		$content = <<<EOT
table.{$module_name} {
   margin: 0;
   padding: 2px;
   border: 1px solid #ccc;
   width: 100%;
}

thead {
   margin: 0;
   padding: 2px;
}

tbody {
   margin: 0;
   padding: 2px;
}

tr {
   font-family: Verdana, Tahoma;   
}

td {
   font-size: 12px;
   font-weight: normal;
}

div.outer {
   color: #555;
   background-color: #eee;
   border: 1px solid #ccc;
   width: 100%;
}

ul.menu > li {
   display: inline;
   width: 100%;
   text-align: center;
   list-style-type: none;   
}
EOT;
		$this->tdmcfile->create($module_name, 'assets/css', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}