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
 * @version         $Id: user_rss.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class UserRss extends TDMCreateFile
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
	*  @param mixed $table
	*  @param string $filename
	*/
	public function write($module, $table, $filename) {    
		$this->setModule($module);
		$this->setTable($table);
		$this->setFileName($filename);
	}
	/*
	*  @public function getUserRss
	*  @param string $module_dirname
	*  @param string $language
	*/
	public function getUserRss($module_dirname, $language) 
	{  
		$table = $this->getTable();
		$table_name = $table->getVar('table_name');
		$fields = $this->getTableFields($table->getVar('table_id'));
		foreach(array_keys($fields) as $f) 
		{
			$field_name = $fields[$f]->getVar('field_name');
			$rp_field_name = $field_name;
			if(strpos($field_name, '_')) {       
				$str = strpos($field_name, '_'); 
				if($str !== false){ 
					$rp_field_name = substr($field_name, $str + 1, strlen($field_name));
				} 		
			}
			$lp_field_name = substr($field_name, 0, strpos($field_name, '_'));	
			if($f == 0) {
				$fpif = $field_name;
			}
			if($fields[$f]->getVar('field_main') == 1) {
				$fpmf = $field_name;
			}
			if($fields[$f]->getVar('field_parent') == 1) {
				$fppf = $field_name;
			}
		}	
		
		$ret = <<<EOT
include_once 'header.php';
\${$fppf} = {$module_dirname}_CleanVars(\$_GET, '{$fppf}', 0);
include_once XOOPS_ROOT_PATH.'/class/template.php';
\$items_count = \$xoopsModuleConfig['perpagerss'];

if (function_exists('mb_http_output')) {
    mb_http_output('pass');
}
//header ('Content-Type:text/xml; charset=UTF-8');
\$xoopsModuleConfig["utf8"] = false;

\$tpl = new XoopsTpl();
\$tpl->xoops_setCaching(2); //1 = Cache global, 2 = Cache individual (for template)
\$tpl->xoops_setCacheTime(\$xoopsModuleConfig['timecacherss']*60); // Time of the cache on seconds
\$categories = {$module_dirname}_MygetItemIds('{$module_dirname}_view', '{$module_dirname}');
\$criteria = new CriteriaCompo();
\$criteria->add(new Criteria('cat_status', 0, '!='));
\$criteria->add(new Criteria('{$fppf}', '(' . implode(',', \$categories) . ')','IN'));
if (\${$fppf} != 0){
    \$criteria->add(new Criteria('{$fppf}', \${$fppf}));
    \${$table_name} = \${$table_name}Handler->get(\${$fppf});
    \$title = \$xoopsConfig['sitename'] . ' - ' . \$xoopsModule->getVar('name') . ' - ' . \${$table_name}->getVar('{$fpmf}');
}else{
    \$title = \$xoopsConfig['sitename'] . ' - ' . \$xoopsModule->getVar('name');
}
\$criteria->setLimit(\$xoopsModuleConfig['perpagerss']);
\$criteria->setSort('date');
\$criteria->setOrder('DESC');
\${$table_name}_arr = \${$table_name}Handler->getall(\$criteria);

if (!\$tpl->is_cached('db:rss.tpl', \${$fppf})) {
    \$tpl->assign('channel_title', htmlspecialchars(\$title, ENT_QUOTES));
    \$tpl->assign('channel_link', XOOPS_URL.'/');
    \$tpl->assign('channel_desc', htmlspecialchars(\$xoopsConfig['slogan'], ENT_QUOTES));
    \$tpl->assign('channel_lastbuild', formatTimestamp(time(), 'rss'));
    \$tpl->assign('channel_webmaster', \$xoopsConfig['adminmail']);
    \$tpl->assign('channel_editor', \$xoopsConfig['adminmail']);
    \$tpl->assign('channel_category', 'Event');
    \$tpl->assign('channel_generator', 'XOOPS - ' . htmlspecialchars(\$xoopsModule->getVar('{$fpmf}'), ENT_QUOTES));
    \$tpl->assign('channel_language', _LANGCODE);
    if ( _LANGCODE == 'fr' ) {
        \$tpl->assign('docs', 'http://www.scriptol.fr/rss/RSS-2.0.html');
    } else {
        \$tpl->assign('docs', 'http://cyber.law.harvard.edu/rss/rss.html');
    }
    \$tpl->assign('image_url', XOOPS_URL . \$xoopsModuleConfig['logorss']);
    \$dimention = getimagesize(XOOPS_ROOT_PATH . \$xoopsModuleConfig['logorss']);
    if (empty(\$dimention[0])) {
        \$width = 88;
    } else {
       \$width = (\$dimention[0] > 144) ? 144 : \$dimention[0];
    }
    if (empty(\$dimention[1])) {
        \$height = 31;
    } else {
        \$height = (\$dimention[1] > 400) ? 400 : \$dimention[1];
    }
    \$tpl->assign('image_width', \$width);
    \$tpl->assign('image_height', \$height);
    foreach (array_keys(\${$table_name}_arr) as \$i) {
        \$description = \${$table_name}_arr[\$i]->getVar('description');
        //permet d'afficher uniquement la description courte
        if (strpos(\$description,'[pagebreak]')==false){
            \$description_short = \$description;
        }else{
            \$description_short = substr(\$description,0,strpos(\$description,'[pagebreak]'));
        }
        \$tpl->append('items', array('title' => htmlspecialchars(\${$table_name}_arr[\$i]->getVar('{$fpmf}'), ENT_QUOTES),
                                    'link' => XOOPS_URL . '/modules/{$module_dirname}/singlefile.php?{$fppf}=' . \${$table_name}_arr[\$i]->getVar('{$fppf}') . '&amp;{$fpif}=' . \${$table_name}_arr[\$i]->getVar('{$fpif}'),
                                    'guid' => XOOPS_URL . '/modules/{$module_dirname}/singlefile.php?{$fppf}=' . \${$table_name}_arr[\$i]->getVar('{$fppf}') . '&amp;{$fpif}=' . \${$table_name}_arr[\$i]->getVar('{$fpif}'),
                                    'pubdate' => formatTimestamp(\${$table_name}_arr[\$i]->getVar('date'), 'rss'),
                                    'description' => htmlspecialchars(\$description_short, ENT_QUOTES)));
    }
}
header("Content-Type:text/xml; charset=" . _CHARSET);
\$tpl->display('db:rss.tpl', \${$fppf});
EOT;
		return $ret;
	}
	
	/*
	*  @public function render
	*  @param null
	*/
	public function render() {    
		$module = $this->getModule();
		$filename = $this->getFileName();
		$module_dirname = $module->getVar('mod_dirname');
		$language = $this->getLanguage($module_dirname, 'MA');			
		$content = $this->getHeaderFilesComments($module, $filename);	
		$content .= $this->getUserRss($module_dirname, $language);
		$this->tdmcfile->create($module_dirname, '/', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}