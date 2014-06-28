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
 * @version         $Id: admin_menu.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class AdminMenu extends TDMCreateFile
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
	*  @param mixed $tables
	*  @param string $filename
	*/
	public function write($module, $tables, $filename) {    
		$this->setModule($module);
		$this->setTables($tables);
		$this->setFileName($filename);
	}
	/*
	*  @public function render
	*  @param null
	*/
	public function render() {    
        $module = $this->getModule();
		$tables = $this->getTables();
		$filename = $this->getFileName();
		$module_name = $module->getVar('mod_name');		
		$language = $this->getLanguage($module_name, 'MI', 'ADMENU');
		$menu = 1;
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .= <<<EOT
\$dirname = basename( dirname( dirname( __FILE__ ) ) ) ;
\$module_handler =& xoops_gethandler('module');
\$xoopsModule =& XoopsModule::getByDirname(\$dirname);
\$moduleInfo =& \$module_handler->get(\$xoopsModule->getVar('mid'));
\$sysPathIcon32 = \$moduleInfo->getInfo('sysicons32');
\$adminmenu = array(); 
\$i = 1;
\$adminmenu[\$i]['title'] = {$language}{$menu};
\$adminmenu[\$i]['link'] = 'admin/index.php';
\$adminmenu[\$i]['icon'] = \$sysPathIcon32.'/home.png';
\$i++;\n
EOT;
		foreach (array_keys($tables) as $i)
		{		
			$table_permissions = $tables[$i]->getVar('table_permissions');
			if ( $tables[$i]->getVar('table_admin') == 1 ) 
			{   
			    $menu++;
				$content .= <<<EOT
\$adminmenu[\$i]['title'] = {$language}{$menu};
\$adminmenu[\$i]['link'] = 'admin/{$tables[$i]->getVar('table_name')}.php';
\$adminmenu[\$i]['icon'] = \$sysPathIcon32.'/{$tables[$i]->getVar('table_image')}';
\$i++;\n
EOT;
			}
		}
		if( $table_permissions == 1 ) {
			$menu++;
			$content .= <<<EOT
\$adminmenu[\$i]['title'] = {$language}{$menu};
\$adminmenu[\$i]['link'] = 'admin/permissions.php';
\$adminmenu[\$i]['icon'] = \$sysPathIcon32.'/permissions.png';
\$i++;\n
EOT;
		}
		$menu++;
		$content .= <<<EOT
\$adminmenu[\$i]['title'] = {$language}{$menu};
\$adminmenu[\$i]['link']  = 'admin/about.php';
\$adminmenu[\$i]['icon'] = \$sysPathIcon32.'/about.png';
unset( \$i );
EOT;
		unset( $menu );
		
		$this->tdmcfile->create($module_name, 'admin', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}