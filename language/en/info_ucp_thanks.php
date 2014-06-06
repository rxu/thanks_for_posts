<?php
/**
*
* mod_thanks [English]
*
* @author Sergeiy Varzaev (Палыч)  phpbbguru.net varzaev@mail.ru
* @version $Id: info_ucp_thanks.php 135 2012-10-10 10:02:51 Палыч $
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
   exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'ALLOW_THANKS_PM'			=> 'Notify me via PM if someone thanks for my post',
	'ALLOW_THANKS_PM_EXPLAIN'	=> 'You will receive a PM if someone says thank you for any of your posts.',
	'ALLOW_THANKS_EMAIL'		=> 'Notify me via e-mail if someone thanks for my post',
	'ALLOW_THANKS_EMAIL_EXPLAIN'=> 'You will receive an e-mail if someone says thank you for any of your posts.',
));

?>
