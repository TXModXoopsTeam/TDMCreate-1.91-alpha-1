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
 * @version         $Id: admin_objects.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class AdminObjects
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
	*  @public function getSimpleSetVar
	*  @param string $tableName
	*  @param string $fieldName
	*/
	public function getSimpleSetVar($tableName, $fieldName) {    
		$ret = <<<EOT
		\${$tableName}Obj->setVar('{$fieldName}', \$_POST['{$fieldName}']);\n
EOT;
		return $ret;
	}
	/*
	*  @public function getTextDateSelect
	*  @param string $tableName
	*  @param string $fieldName
	*/
	public function getTextDateSelect($tableName, $fieldName) {    
		$ret = <<<EOT
		\${$tableName}Obj->setVar('{$fieldName}', strtotime(\$_POST['{$fieldName}']));\n
EOT;
		return $ret;
	}
	/*
	*  @public function getCheckBoxOrRadioYN
	*  @param string $tableName
	*  @param string $fieldName
	*/
	public function getCheckBoxOrRadioYN($tableName, $fieldName) {    
		$ret = <<<EOT
		\${$tableName}Obj->setVar('{$fieldName}', ((\$_REQUEST['{$fieldName}'] == 1) ? '1' : '0'));\n
EOT;
		return $ret;
	}
	/*
	*  @public function getImageList
	*  @param string $moduleDirname
	*  @param string $tableName
	*  @param string $fieldName
	*/
	public function getImageList($moduleDirname, $tableName, $fieldName) {    
		$ret = <<<EOT
		// Set Var Image
		include_once XOOPS_ROOT_PATH.'/class/uploader.php';
		\$uploaddir = XOOPS_ROOT_PATH . '/Frameworks/moduleclasses/icons/32';
		\$uploader = new XoopsMediaUploader(\$uploaddir, \${$moduleDirname}->getConfig('mimetypes'),
														 \${$moduleDirname}->getConfig('maxsize'), null, null);
		if (\$uploader->fetchMedia(\$_POST['xoops_upload_file'][0])) {
			//\$uploader->setPrefix('{$fieldName}_');
			//\$uploader->fetchMedia(\$_POST['xoops_upload_file'][0]);
			if (!\$uploader->upload()) {
				\$errors = \$uploader->getErrors();
				redirect_header('javascript:history.go(-1)', 3, \$errors);
			} else {
				\${$tableName}Obj->setVar('{$fieldName}', \$uploader->getSavedFileName());
			}
		} else {
			\${$tableName}Obj->setVar('{$fieldName}', \$_POST['{$fieldName}']);
		}\n
EOT;
		return $ret;
	}
	/*
	*  @public function getUploadImage
	*  @param string $moduleDirname
	*  @param string $tableName
	*  @param string $fieldName
	*/
	public function getUploadImage($moduleDirname, $tableName, $fieldName) {    
		$stuModuleDirname = strtolower($moduleDirname);
		$ret = <<<EOT
		// Set Var Image
		include_once XOOPS_ROOT_PATH.'/class/uploader.php';
		\$uploaddir = {$stuModuleDirname}_UPLOAD_PATH.'/images/{$tableName}';
		\$uploader = new XoopsMediaUploader(\$uploaddir, \${$moduleDirname}->getConfig('mimetypes'),
														 \${$moduleDirname}->getConfig('maxsize'), null, null);
		if (\$uploader->fetchMedia(\$_POST['xoops_upload_file'][0])) {
			//\$uploader->setPrefix('{$fieldName}_');
			//\$uploader->fetchMedia(\$_POST['xoops_upload_file'][0]);
			if (!\$uploader->upload()) {
				\$errors = \$uploader->getErrors();
				redirect_header('javascript:history.go(-1)', 3, \$errors);
			} else {
				\${$tableName}Obj->setVar('{$fieldName}', \$uploader->getSavedFileName());
			}
		} else {
			\${$tableName}Obj->setVar('{$fieldName}', \$_POST['{$fieldName}']);
		}\n
EOT;
		return $ret;
	}
	/*
	*  @public function getUploadFile
	*  @param string $moduleDirname
	*  @param string $tableName
	*  @param string $fieldName
	*/
	public function getUploadFile($moduleDirname, $tableName, $fieldName) {    
		$stuModuleDirname = strtolower($moduleDirname);
		$ret = <<<EOT
		// Set Var File
		include_once XOOPS_ROOT_PATH.'/class/uploader.php';
		\$uploaddir = {$stuModuleDirname}_UPLOAD_PATH.'/files/{$tableName}';
		\$uploader = new XoopsMediaUploader(\$uploaddir, \${$moduleDirname}->getConfig('mimetypes'),
														 \${$moduleDirname}->getConfig('maxsize'), null, null);
		if (\$uploader->fetchMedia(\$_POST['xoops_upload_file'][0])) {
			//\$uploader->setPrefix('{$fieldName}_') ;
			//\$uploader->fetchMedia(\$_POST['xoops_upload_file'][0]);
			if (!\$uploader->upload()) {
				\$errors = \$uploader->getErrors();
				redirect_header('javascript:history.go(-1)', 3, \$errors);
			} else {
				\${$tableName}Obj->setVar('{$fieldName}', \$uploader->getSavedFileName());
			}
		}\n
EOT;
		return $ret;
	}	
}