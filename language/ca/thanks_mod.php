<?php
/**
 *
 * Thanks For Posts.
 * Adds the ability to thank the author and to use per posts/topics/forum rating system based on the count of thanks.
 * An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, rxu, https://www.phpbbguru.net
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	$lang = [];
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
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'CLEAR_LIST_THANKS'			=> 'Esborrar la llista d\'agraïments',
	'CLEAR_LIST_THANKS_CONFIRM'	=> 'Realment vols esborrar la llista d\'agraïments de l\'usuari?',
	'CLEAR_LIST_THANKS_GIVE'	=> 'S\'ha esborrat la llista d\'agraïments fets per l\'usuari.',
	'CLEAR_LIST_THANKS_POST'	=> 'S\'ha esborrat la lista d\'agraïments del missatge.',
	'CLEAR_LIST_THANKS_RECEIVE'	=> 'S\'ha esborrat la llista d\'agraïments obtinguts per l\'usuari.',

	'DISABLE_REMOVE_THANKS'		=> 'L\'administrador ha desactivat l\'opció de retirar els agraïments',

	'GIVEN'						=> 'Gràcies&nbsp;donades',
	'GLOBAL_INCORRECT_THANKS'	=> 'No pots agrair un Anunci Global que no fa referència a cap fòrum en particular.',
	'GRATITUDES'				=> 'Llista d\'agraïments',

	'INCORRECT_THANKS'			=> 'Agraïment invàlid',

	'JUMP_TO_FORUM'				=> 'Vés al fòrum',
	'JUMP_TO_TOPIC'				=> 'Vés al tema',

	'FOR_MESSAGE'				=> ' per missatge',
	'FURTHER_THANKS'     	    => [
		1 => ' i un usuari més',
		2 => ' i %d usuaris més',
	],

	'NO_VIEW_USERS_THANKS'		=> 'No tens permís per veure la llista d\'agraïments.',

	'NOTIFICATION_THANKS_GIVE'	=> [
		1 => '<strong>Agraïment rebut</strong> de %1$s pel missatge:',
		2 => '<strong>Agraïments rebuts</strong> de %1$s pel missatge:',
	],
	'NOTIFICATION_THANKS_REMOVE'=> [
		1 => '<strong>Agraïment cancel·lat</strong> de %1$s pel missatge:',
		2 => '<strong>Agraïments cancel·lats</strong> de %1$s pel missatge:',
	],
	'NOTIFICATION_TYPE_THANKS_GIVE'		=> 'Algú ha agraït un missatge teu',
	'NOTIFICATION_TYPE_THANKS_REMOVE'	=> 'Algú ha cancel·lat un agraïment en un missatge teu',

	'RECEIVED'					=> 'Gràcies&nbsp;rebudes',
	'REMOVE_THANKS'				=> 'Cancel·la el teu agraïment: ',
	'REMOVE_THANKS_CONFIRM'		=> 'Estàs segur de cancel·lar el teu agraïment?',
	'REMOVE_THANKS_SHORT'		=> 'Cancel·la agraïment',
	'REPUT'						=> 'Valoració',
	'REPUT_TOPLIST'				=> 'Més agraïts — %d',
	'RATING_LOGIN_EXPLAIN'		=> 'No tens permís per veure la llista de més agraïts.',
	'RATING_NO_VIEW_TOPLIST'	=> 'No tens permís per veure la llista de més agraïts.',
	'RATING_VIEW_TOPLIST_NO'	=> 'La llista de més agraïts és buida o deshabilitada per l\'administrador',
	'RATING_FORUM'				=> 'Fòrum',
	'RATING_POST'				=> 'Missatge',
	'RATING_TOP_FORUM'			=> 'Valoració de fòrums',
	'RATING_TOP_POST'			=> 'Valoració de missatges',
	'RATING_TOP_TOPIC'			=> 'Valoració de temes',
	'RATING_TOPIC'				=> 'Tema',

	'THANK'						=> 'cop',
	'THANK_FROM'				=> 'de',
	'THANK_TEXT_1'				=> 'Aquests usuaris han agraït l\'autor ',
	'THANK_TEXT_2'				=> ' pel missatge: ',
	'THANK_TEXT_2PL'			=> ' pel missatge (%d en total):',
	'THANK_POST'				=> 'Agraeix l\'autor del missatge: ',
	'THANK_POST_SHORT'			=> 'Gràcies',
	'THANKS'					=> [
		1	=> '%d cop',
		2	=> '%d cops',
	],
	'THANKS_BACK'				=> 'Torna',
	'THANKS_INFO_GIVE'			=> 'Acabes d\'agrair el missatge.',
	'THANKS_INFO_REMOVE'		=> 'Acabes de cancel·lar el teu agraïment.',
	'THANKS_LIST'				=> 'Veure/tancar llista',
	'THANKS_PM_MES_GIVE'		=> 't\'ha agraït pel missatge',
	'THANKS_PM_MES_REMOVE'		=> 'ha cancel·lat el seu agraïment pel missatge',
	'THANKS_PM_SUBJECT_GIVE'	=> 'Gràcies pel missatge',
	'THANKS_PM_SUBJECT_REMOVE'	=> 'Cancel·la l\'agraïment',
	'THANKS_USER'				=> 'Llista d\'agraïments',
	'TOPLIST'					=> 'Llista de més agraïts',
]);
