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
 * @version         $Id: sql_file.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class SqlFile extends TDMCreateFile
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
	*  @param string $table
	*  @param string $tables
	*  @param string $filename
	*/
	public function write($module, $tables, $filename) {    
		$this->setModule($module);
		$this->setTables($tables);
		$this->setFileName($filename);			
	}
	
	/*
	*  @public function getHeaderSqlComments
	*  @param string $module_name
	*/
	public function getHeaderSqlComments($module_name) 
	{   
		$date = date('D M d, Y');
		$time = date('G:i');
		$server_name = $_SERVER['SERVER_NAME'];
		$server_version = mysql_get_server_info();
		$php_version = phpversion();
		// Header Sql Comments
		$ret = <<<SQL
# SQL Dump for {$module_name} module
# PhpMyAdmin Version: 4.0.4
# http://www.phpmyadmin.net
#
# Host: {$server_name}
# Generated on: {$date} to {$time}
# Server version: {$server_version}
# PHP Version: {$php_version}\n
SQL;
		return $ret;
	}	
	
	/*
	*  @public function getHeadDatabaseTable
	*  @param string $module_dirname
	*  @param string $table_name
	*  @param integer $nb_fields
	*
	*  Unused IF NOT EXISTS
	*/
	public function getHeadDatabaseTable($module_dirname, $table_name, $nb_fields) 
	{    
		$ret = <<<SQL

#
# Structure table for `{$module_dirname}_{$table_name}` {$nb_fields}
#
		
CREATE TABLE `{$module_dirname}_{$table_name}` (\n
SQL;
		return $ret;
	}
	
	/*
	*  @public function getDatabaseTables
	*  @param string $module_dirname
	*/
	public function getDatabaseTables($module_dirname) 
	{    
		$ret = null;
		$tables = $this->getTables();
		foreach(array_keys($tables) as $t) 
		{
			$table_id = $tables[$t]->getVar('table_id');
			$table_name = $tables[$t]->getVar('table_name');
			$table_autoincrement = $tables[$t]->getVar('table_autoincrement');
			$nb_fields = $tables[$t]->getVar('table_nbfields');					
			$ret .= $this->getDatabaseFields($module_dirname, $table_id, $table_name, $table_autoincrement, $nb_fields);
		}		
		return $ret;
	}
	
	/*
	*  @public function getDatabaseFields
	*  @param string $module_dirname
	*  @param string $table_name
	*  @param boolean $table_autoincrement
	*  @param integer $nb_fields
	*/
	public function getDatabaseFields($module_dirname, $table_id, $table_name, $table_autoincrement, $nb_fields) 
	{    		
		$ret = null; $j = 0; $comma = array(); $row = array();
        $fields = $this->getTableFields($table_id);		
		foreach(array_keys($fields) as $f) 
		{
			// Creation of database table  
			$ret = $this->getHeadDatabaseTable($module_dirname, $table_name, $nb_fields);
			$field_name = $fields[$f]->getVar('field_name');
			$field_type = $fields[$f]->getVar('field_type');
			$field_value = $fields[$f]->getVar('field_value');
			$field_attribute = $fields[$f]->getVar('field_attribute');
			$field_null = $fields[$f]->getVar('field_null');
			$field_default = $fields[$f]->getVar('field_default');
			$field_key = $fields[$f]->getVar('field_key');
			if ( !empty($field_name) )
			{								
				switch( $field_type ) {
					case 'TEXT':
					case 'TINYTEXT':
					case 'MEDIUMTEXT':
					case 'LONGTEXT':
					case 'DATE':	
					case 'DATETIME':
					case 'TIMESTAMP':
						$type = $field_type;
						$default = null;
                    break;					
					default:
						$type = $field_type.'('.$field_value.')';
						$default = "DEFAULT '{$field_default}'";
					break;
				}	
				if ( ($f == 0) && ($table_autoincrement == 1) ) {
					$row[] = $this->getFieldRow($field_name, $type, $field_attribute, $field_null, null, 'AUTO_INCREMENT');					
					$comma[$j] = '  PRIMARY KEY (`'.$field_name.'`)';//$this->getKey(1, $field_name);
					$j++;
				} else {
					if ( $field_key == 'UNIQUE' || $field_key == 'INDEX' || $field_key == 'FULLTEXT')
					{
						switch( $field_key ) {					
							case 'UNIQUE':
								$row[] = $this->getFieldRow($field_name, $type, $field_attribute, $field_null, $default);
								$comma[$j] = '  KEY `'.$field_name.'` (`'.$field_name.'`)';//$this->getKey(2, $field_name);
								$j++;
							break;
							case 'INDEX':
								$row[] = $this->getFieldRow($field_name, $type, $field_attribute, $field_null, $default);
								$comma[$j] = '  INDEX (`'.$field_name.'`)';//$this->getKey(3, $field_name);
								$j++;
							break;
							case 'FULLTEXT':
								$row[] = $this->getFieldRow($field_name, $type, $field_attribute, $field_null, $default);
								$comma[$j] = '  FULLTEXT KEY `'.$field_name.'` (`'.$field_name.'`)';//$this->getKey(4, $field_name);
								$j++;
							break;											
						}	
					} else {
						$row[] = $this->getFieldRow($field_name, $type, $field_attribute, $field_null, $default);
					}										
				}								
			}
		}
		for ($i=0; $i < $j; $i++) {
			if ( $i != $j - 1 ) {
				$row[] = $comma[$i].',';
			} else {
				$row[] = $comma[$i];
			}
		}
       // echo $key."================= KEY ========================= </br>";
		$ret .= implode("\n", $row);
		//$ret .= $key;
		//$row[] = $this->getCommaCicle($j, $comma);		
		unset($j);
		$ret .= $this->getFootDatabaseTable();
		return $ret;
	}
	/*
	*  @private function getFootDatabaseTable
	*  @param null
	*/
	private function getFootDatabaseTable() {    
		$ret = <<<SQL
\n) ENGINE=MyISAM;\n
SQL;
		return $ret;
	}
	/*
	*  @private function getFieldRow
	*  @param string $field_name
	*  @param string $field_type_value
	*  @param string $field_attribute
	*  @param string $field_null
	*  @param string $field_default
	*  @param string $autoincrement
	*/
	private function getFieldRow($field_name, $field_type_value, $field_attribute = null, $field_null = null, $field_default = null, $autoincrement = null) {    
		$ret_autoincrement = <<<SQL
  `{$field_name}` {$field_type_value} {$field_attribute} {$field_null} {$autoincrement},
SQL;
		$ret_field_attribute = <<<SQL
  `{$field_name}` {$field_type_value} {$field_attribute} {$field_null} {$field_default},
SQL;
		$ret_no_field_attribute = <<<SQL
  `{$field_name}` {$field_type_value} {$field_null} {$field_default},
SQL;
		$ret_short = <<<SQL
  `{$field_name}` {$field_type_value},
SQL;
		if($autoincrement != null) {
			$ret = $ret_autoincrement;
		} elseif($field_attribute != null) {
			$ret = $ret_field_attribute;
		} elseif($field_attribute == null) {
			$ret = $ret_no_field_attribute;
		} else {
			$ret = $ret_short;
		}
		return $ret;
	}
	/*
	*  @private function getKey
	*  @param integer $key
	*  @param array $field_name
	*/
	private function getKey($key, $field_name) {    
		switch( $key ) {
			case 1:
				$ret = <<<SQL
	PRIMARY KEY (`$field_name`)
SQL;
			break;
			case 2: // UNIQUE KEY
				$ret = <<<SQL
	KEY `$field_name` (`$field_name`)
SQL;
			break;
			case 3:
				$ret = <<<SQL
	INDEX (`$field_name`)
SQL;
			break;
			case 4:
				$ret = <<<SQL
	FULLTEXT KEY `$field_name` (`$field_name`)
SQL;
			break;
		}
		return $ret;
	}	
		
	/*
	*  @private function getComma
	*  @param array $array
	*  @param string $comma
	*/
	private function getComma($array = array(), $comma = null) {    
		$ret = <<<SQL
			{$array}{$comma}
SQL;
		return $ret;
	}	
	/*
	*  @private function getCommaCicle
	*  @param integer $index
	*/
	private function getCommaCicle($index, $comma = array()) {    
		// Comma issue
		$ret = '';			
		for ($i = 1; $i <= $index; $i++)
		{
			if ( $i != $index - 1 ) {
				$ret .= $this->getComma(isset($comma[$i]), ','). "\n";
			} else {
				$ret .= $this->getComma(isset($comma[$i])). "\n";
			}
		}
		return $ret;
	}	
	
	/*
	*  @public function render
	*  @param null
	*/
	public function render() {    
		$module = $this->getModule();		
		$filename = $this->getFileName();
		$module_name = strtolower($module->getVar('mod_name'));
        $module_dirname = strtolower($module->getVar('mod_name'));		
		$content = $this->getHeaderSqlComments($module_name);
		$content .= $this->getDatabaseTables($module_dirname);
		$this->tdmcfile->create($module_dirname, 'sql', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);
		return $this->tdmcfile->renderFile();
	}
}