<?php
/**
 * XOOPS simple form
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         kernel
 * @subpackage      form
 * @since           2.0.0
 * @author          Kazumi Ono (AKA onokazu) http://www.myweb.ne.jp/, http://jp.xoops.org/
 * @version         $Id: simpleform.php 12403 2014-03-25 15:14:13Z timgno $
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

require_once 'htmlform.php';

/**
 * base class
 */
xoops_load('XoopsForm');

/**
 * Form that will output as a simple HTML form with minimum formatting
 */
class TDMCreateSimpleForm extends XoopsForm
{
    /**
     * htmlform
     *
     * @var mixed
     */
    private $htmlform = null;	
	
	/**
     * create HTML to output the form with minimal formatting
     *
     * @return string
     */
    function render()
    {
		$this->htmlform = TDMCreateHtmlForm::getInstance();
		$this->htmlform->getInitForm($this->getName(), $this->getAction(), $this->getMethod(), $this->getExtra());
		$ret = $this->htmlform->getHeaderForm($this->getTitle());        
		$ret .= $this->htmlform->getOpenForm();
        foreach ($this->getElements() as $ele) {
            if (!$ele->isHidden()) {
                $ret .= $this->htmlform->getContentForm($ele->getClass(), $ele->getCaption(), $ele->render());
            } else {
                $ret .= $ele->render() . NWLINE;
            }
        }
        $ret .= $this->htmlform->getCloseForm();
        return $ret;
    }
}