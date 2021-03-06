<?php
/**
 * XOOPS form radio compo
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright   The XOOPS project http://www.xoops.org/
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package     tdmcreate
 * @since       1.91
 * @author      Kazumi Ono (AKA onokazu) http://www.myweb.ne.jp/, http://jp.xoops.org/
 * @author      Taiwen Jiang <phppp@users.sourceforge.net>
 * @version     $Id: TDMCreateFormRadio.php 12360 2014-12-06 13:18:22Z timgno $
 */
class TDMCreateFormRadio extends XoopsFormElement
{
    /**
     * Array of Options
     *
     * @var array
     * @access private
     */
    private $_options = array();

    /**
     * Pre-selected value
     *
     * @var integer
     * @access private
     */
    private $_id = null;
	
	/**
     * Pre-selected value
     *
     * @var string
     * @access private
     */
    private $_value = null;
	
	/**
     * Checked for selection
     *
     * @var boolean
     * @access private
     */
    private $checked;

    /**
     * HTML to seperate the elements
     *
     * @var string
     * @access private
     */
    private $_delimeter;
	
	/**
     * Column number for rendering
     *
     * @var int
     * @access public
     */
    public $columns;
    
    /**
     * Constructor
     *
     * @param string $caption   Caption
     * @param string $name      "name" attribute
	 * @param integer $id      "id" attribute
     * @param string $value     Pre-selected value
     * @param string $delimeter
     */
    function TDMCreateFormRadio($caption, $name, $value = null, $checked = false, $delimeter = '&nbsp;')
    {
        $this->setCaption($caption);
        $this->setName($name);
        if (isset($value)) {
            $this->setValue($value);
        }
        $this->checked = $checked;
		$this->_delimeter = $delimeter;
    }    
	
	/**
     * Get the "value" attribute
     *
     * @param  bool   $encode To sanitizer the text?
     * @return string
     */
    function getValue($encode = false)
    {
        return ($encode && $this->_value !== null) ? htmlspecialchars($this->_value, ENT_QUOTES) : $this->_value;
    }

    /**
     * Set the pre-selected value
     *
     * @param  $value string
     */
    function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * Add an option
     *
     * @param string $value "value" attribute - This gets submitted as form-data.
     * @param string $name  "name" attribute - This is displayed. If empty, we use the "value" instead.
     */
    function addOption($value, $name = '')
    {
        if ($name != '') {
            $this->_options[$value] = $name;
        } else {
            $this->_options[$value] = $value;
        }
    }

    /**
     * Adds multiple options
     *
     * @param array $options Associative array of value->name pairs.
     */
    function addOptionArray($options)
    {
        if (is_array($options)) {
            foreach ($options as $k => $v) {
                $this->addOption($k, $v);
            }
        }
    }

    /**
     * Get an array with all the options
     *
     * @param bool|int $encode To sanitizer the text? potential values: 0 - skip; 1 - only for value; 2 - for both value and name
     *
     * @return array Associative array of value->name pairs
     */
    function getOptions($encode = false)
    {
        if (! $encode) {
            return $this->_options;
        }
        $value = array();
        foreach ($this->_options as $val => $name) {
            $value[$encode ? htmlspecialchars($val, ENT_QUOTES) : $val] = ($encode > 1) ? htmlspecialchars($name, ENT_QUOTES) : $name;
        }

        return $value;
    }

    /**
     * Get the delimiter of this group
     *
     * @param  bool   $encode To sanitizer the text?
     * @return string The delimiter
     */
    function getDelimeter($encode = false)
    {
        return $encode ? htmlspecialchars(str_replace('&nbsp;', ' ', $this->_delimeter)) : $this->_delimeter;
    }

    /**
     * Prepare HTML for output
     *
     * @return string HTML
     */
    function render()
    {
        $ret = '';
        $ele_name = $this->getName();
        $ele_value = $this->getValue();
        $ele_options = $this->getOptions();
        $ele_extra = $this->getExtra();
        $ele_delimeter = empty($this->columns) ? $this->getDelimeter() : '';
        if (! empty($this->columns)) {
            $ret .= '<table><tr>';
        }      
        $i = 0;
        foreach ($ele_options as $value => $name) {
            if (! empty($this->columns)) {
                if ($i % $this->columns == 0) {
                    $ret .= '<tr>';
                }
                $ret .= '<td>';
            }
			if (isset($ele_value) && $value == $ele_value) {
                $check = " checked='checked'";
            }
            if ($this->checked) {			
				$ret .= "<input type='radio' name='{$ele_name}' id='{$ele_name}{$ele_value}' value='{$value}{$check}'";
            } else {				
				$ret .= "<input type='radio' name='{$ele_name}' id='{$ele_name}{$ele_value}' value='{$value}'";		
            }				
            $ret .= $ele_extra . " />" . "<label name='xolb_{$ele_name}' for='" . $ele_name . $ele_value. "'>" . $name . "</label>" . $ele_delimeter ;            
			if (! empty($this->columns)) {
                $ret .= '</td>';
                if (++ $i % $this->columns == 0) {
                    $ret .= '</tr>';
                }
            }
		}
		if (! empty($this->columns)) {
            if ($span = $i % $this->columns) {
                $ret .= '<td colspan="' . ($this->columns - $span) . '"></td></tr>';
            }
            $ret .= '</table>';
        }
        return $ret;
    }
}