<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty truncate modifier plugin
 *
 * Type:     modifier<br>
 * Name:     truncate<br>
 * Purpose:  Truncate a string to a certain length if necessary,
 *           optionally splitting in the middle of a word, and
 *           appending the $etc string.
 * @link http://smarty.php.net/manual/en/language.modifier.truncate.php
 *          truncate (Smarty online manual)
 * @param string
 * @param integer
 * @param string
 * @param boolean
 * @return string
 */
function smarty_modifier_truncate($string, $length = 80)
{
	if ($length == 0 || (strlen($string) <= $length)) return $string;
    $string = substr($string, 0, $length);
    preg_match('/^([\x00-\x7e]|.{2})*/', $string, $m);
	return $m[0].'...';
}

/* vim: set expandtab: */

?>
