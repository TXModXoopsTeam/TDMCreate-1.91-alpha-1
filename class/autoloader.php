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
 * @version         $Id: autoloader.php 12258 2014-01-02 09:33:29Z timgno $
 */
function autoLoader($className) {
	// Directories
	$directories = array(
		'', 
		'files/', 
		'files/admin/',
		'files/blocks/',
		'files/classes/',
		'files/css/',
		'files/docs/',
		'files/include/',
		'files/language/',
		'files/sql/',
		'files/templates/user/',
		'files/templates/admin/',
		'files/templates/blocks/',
		'files/user/'
	);
	
	// File naming format
	$fileNameFormats = array( '%s.php' );
	
	foreach($directories as $directory) {
		foreach($fileNameFormats as $fileNameFormat) {
			$path = $directory.sprintf($fileNameFormat, $className);
			if(file_exists($path)) {
				include_once $path;
				return true;
			}
		}
	}
	return false;
}
//
spl_autoload_register('autoLoader');