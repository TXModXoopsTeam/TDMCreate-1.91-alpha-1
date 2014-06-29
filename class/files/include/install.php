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
 * @version         $Id: include_install.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class IncludeInstall extends TDMCreateFile
{	
	/*
	*  @public function constructor
	*  @param null
	*/
	public function __construct() {    
		parent::__construct();
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
	public function write($module, $table, $tables, $filename) {    
		$this->setModule($module);
		$this->setTable($table);
		$this->setTables($tables);
		$this->setFileName($filename);		
	}
	/*
	*  @private function getInstallModuleFolder
	*  @param string $module_dirname
	*/
	private function getInstallModuleFolder($module_dirname) {    
		$ret = <<<EOT
//
defined('XOOPS_ROOT_PATH') or die('Restricted access');
// Copy base file
\$indexFile = XOOPS_UPLOAD_PATH.'/index.html';
\$blankFile = XOOPS_UPLOAD_PATH.'/blank.gif';
// Making of "uploads/{$module_dirname}" folder
\${$module_dirname} = XOOPS_UPLOAD_PATH.'/{$module_dirname}';
if(!is_dir(\${$module_dirname}))
	mkdir(\${$module_dirname}, 0777);
	chmod(\${$module_dirname}, 0777);
copy(\$indexFile, \${$module_dirname}.'/index.html');\n
EOT;
		return $ret;
	}
	/*
	*  @private function getHeaderTableFolder
	*  @param string $module_dirname
	*  @param string $table_name
	*/
	private function getInstallTableFolder($module_dirname, $table_name) {    
		$ret = <<<EOT
// Making of {$table_name} uploads folder
\${$table_name} = \${$module_dirname}.'/{$table_name}';
if(!is_dir(\${$table_name}))
	mkdir(\${$table_name}, 0777);
	chmod(\${$table_name}, 0777);
copy(\$indexFile, \${$table_name}.'/index.html');\n
EOT;
		return $ret;
	}
	/*
	*  @private function getInstallImagesFolder
	*  @param string $module_dirname
	*/
	private function getInstallImagesFolder($module_dirname) {    
		$ret = <<<EOT
// Making of images folder
\$images = \${$module_dirname}.'/images';
if(!is_dir(\$images))
	mkdir(\$images, 0777);
	chmod(\$images, 0777);
copy(\$indexFile, \$images.'/index.html');
copy(\$blankFile, \$images.'/blank.gif');\n
EOT;
		return $ret;
	}
	/*
	*  @private function getInstallTableImagesFolder
	*  @param string $table_name
	*/
	private function getInstallTableImagesFolder($table_name) {    
		$ret = <<<EOT
// Making of "{$table_name}" images folder
\${$table_name} = \$images.'/{$table_name}';
if(!is_dir(\${$table_name}))
	mkdir(\${$table_name}, 0777);
	chmod(\${$table_name}, 0777);
copy(\$indexFile, \${$table_name}.'/index.html');
copy(\$blankFile, \${$table_name}.'/blank.gif');\n
EOT;
		return $ret;
	}
	/*
	*  @private function getInstallFilesFolder
	*  @param string $module_dirname
	*/
	private function getInstallFilesFolder($module_dirname) {    
		$ret = <<<EOT
// Making of files folder
\$files = \${$module_dirname}.'/files';
if(!is_dir(\$files))
	mkdir(\$files, 0777);
	chmod(\$files, 0777);
copy(\$indexFile, \$files.'/index.html');\n
EOT;
		return $ret;
	}
	/*
	*  @private function getInstallTableFilesFolder
	*  @param string $table_name
	*/
	private function getInstallTableFilesFolder($table_name) {    
		$ret = <<<EOT
// Making of "{$table_name}" files folder
\${$table_name} = \$files.'/{$table_name}';
if(!is_dir(\${$table_name}))
	mkdir(\${$table_name}, 0777);
	chmod(\${$table_name}, 0777);
copy(\$indexFile, \${$table_name}.'/index.html');\n
EOT;
		return $ret;
	}
	/*
	*  @private function getInstallFooter
	*  @param null
	*/
	private function getInstallFooter() {    
		$ret = <<<EOT
// ---------- Install Footer ---------- //
EOT;
		return $ret;
	}
	/*
	*  @public function render
	*  @param null
	*/
	public function render() 
	{  		
		$module = $this->getModule();
		$module_dirname = $module->getVar('mod_dirname');
		$table = $this->getTable();
		$tables = $this->getTables();
		$filename = $this->getFileName();
		$content = $this->getHeaderFilesComments($module, $filename);
		$content .= $this->getInstallModuleFolder($module_dirname);				
		$fields = $this->getTableFields($table->getVar('table_id'));
		foreach(array_keys($fields) as $f) 
		{				
			$field_element = $fields[$f]->getVar('field_element');		
			// All fields elements selected
			switch( $field_element ) {
				case 9:
					$content .= $this->getInstallImagesFolder($module_dirname);
					foreach(array_keys($tables) as $t) 
					{	
						$table_name = $tables[$t]->getVar('table_name');	
						$content .= $this->getInstallTableImagesFolder($table_name);			
					}
				break;
				case 10:
					$content .= $this->getInstallFilesFolder($module_dirname);
					foreach(array_keys($tables) as $t) 
					{	
						$table_name = $tables[$t]->getVar('table_name');	
						$content .= $this->getInstallTableFilesFolder($table_name);			
					}
				break;
			}
		}					
		$content .= $this->getInstallFooter();
		//
		$this->tdmcfile->create($module_dirname, 'include', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}