<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty plugin
 *
 * Type:     modifier<br>
 * Name:     autolink<br>
 * Date:     Jan 3, 2005
 * Purpose:  auto URL link
 * Example:  {$text|autolink}
 * @version  1.0
 * @author   Taeho Kim <dittos@gmail.com>
 * @param string
 * @return string
 */
function smarty_modifier_autolink($string)
{
    return preg_replace("#http://(?:[-0-9a-z_.@:~\\#%=+?/]|&amp;)+#i", '<a href="\0">\0</a>', $string);
}

/* vim: set expandtab: */

?>