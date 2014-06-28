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
	*  @param string $table_name
	*  @param string $field_name
	*/
	public function getSimpleSetVar($table_name, $field_name) {    
		$ret = <<<EOT
		\${$table_name}Obj->setVar('{$field_name}', \$_POST['{$field_name}']);\n
EOT;
		return $ret;
	}
	/*
	*  @public function getTextDateSelect
	*  @param string $table_name
	*  @param string $field_name
	*/
	public function getTextDateSelect($table_name, $field_name) {    
		$ret = <<<EOT
		\${$table_name}Obj->setVar('{$field_name}', strtotime(\$_POST['{$field_name}']));\n
EOT;
		return $ret;
	}
	/*
	*  @public function getCheckBoxOrRadioYN
	*  @param string $table_name
	*  @param string $field_name
	*/
	public function getCheckBoxOrRadioYN($table_name, $field_name) {    
		$ret = <<<EOT
		\${$table_name}Obj->setVar('{$field_name}', ((\$_REQUEST['{$field_name}'] == 1) ? '1' : '0'));\n
EOT;
		return $ret;
	}
	/*
	*  @public function getUploadImage
	*  @param string $module_name
	*  @param string $table_name
	*  @param string $field_name
	*/
	public function getUploadImage($module_name, $table_name, $field_name) {    
		$ret = <<<EOT
		// Set Var Image
		include_once XOOPS_ROOT_PATH.'/class/uploader.php';
		\$uploaddir = XOOPS_UPLOAD_PATH.'/{$module_name}/images/{$table_name}/';
		\$uploader = new XoopsMediaUploader(\$uploaddir, xoops_getModuleOption('mimetypes', '{$module_name}'),
												       xoops_getModuleOption('maxsize', '{$module_name}'), null, null);
		if (\$uploader->fetchMedia(\$_POST['xoops_upload_file'][0])) {
			\$uploader->setPrefix('{$field_name}_');
			\$uploader->fetchMedia(\$_POST['xoops_upload_file'][0]);
			if (!\$uploader->upload()) {
				\$errors = \$uploader->getErrors();
				redirect_header('javascript:history.go(-1)', 3, \$errors);
			} else {
				\${$table_name}Obj->setVar('{$field_name}', \$uploader->getSavedFileName());
			}
		} else {
			\${$table_name}Obj->setVar('{$field_name}', \$_POST['{$field_name}']);
		}\n
EOT;
		return $ret;
	}
	/*
	*  @public function getUploadFile
	*  @param string $module_name
	*  @param string $table_name
	*  @param string $field_name
	*/
	public function getUploadFile($module_name, $table_name, $field_name) {    
		$ret = <<<EOT
		// Set Var File
		include_once XOOPS_ROOT_PATH.'/class/uploader.php';
		\$uploaddir = XOOPS_UPLOAD_PATH.'/{$module_name}/files/{$table_name}/';
		\$uploader = new XoopsMediaUploader(\$uploaddir, xoops_getModuleOption('mimetypes', '{$module_name}'),
												       xoops_getModuleOption('maxsize', '{$module_name}'), null, null);
		if (\$uploader->fetchMedia(\$_POST['xoops_upload_file'][0])) {
			\$uploader->setPrefix('{$field_name}_') ;
			\$uploader->fetchMedia(\$_POST['xoops_upload_file'][0]);
			if (!\$uploader->upload()) {
				\$errors = \$uploader->getErrors();
				redirect_header('javascript:history.go(-1)', 3, \$errors);
			} else {
				\${$table_name}Obj->setVar('{$field_name}', \$uploader->getSavedFileName());
			}
		}\n
EOT;
		return $ret;
	}	
}