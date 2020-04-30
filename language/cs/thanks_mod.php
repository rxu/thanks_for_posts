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
	'CLEAR_LIST_THANKS'			=> 'Vymazat seznam poděkování',
	'CLEAR_LIST_THANKS_CONFIRM'	=> 'Opravdu chcete uživatelův seznam poděkování?',
	'CLEAR_LIST_THANKS_GIVE'	=> 'Seznam poděkování udělených uživatelem byl vymazán.',
	'CLEAR_LIST_THANKS_POST'	=> 'Seznam poděkování v příspěvku byl vymazán.',
	'CLEAR_LIST_THANKS_RECEIVE'	=> 'Seznam poděkování obdržených uživatelem byl vymazán.',

	'DISABLE_REMOVE_THANKS'		=> 'Mazání poděkování bylo administrátorem zakázáno',

	'GIVEN'						=> 'Dal&nbsp;poděkování',
	'GLOBAL_INCORRECT_THANKS'	=> 'Nemůžete dát poděkování globálnímu oznámení, které nemá vztah ke konkrétnímu fóru.',
	'GRATITUDES'				=> 'Poděkování',

	'INCORRECT_THANKS'			=> 'Neplatné poděkování',

	'JUMP_TO_FORUM'				=> 'Přejdi na fórum',
	'JUMP_TO_TOPIC'				=> 'Přejdi na vlákno',

	'FOR_MESSAGE'				=> ' za příspěvěk',
	'FURTHER_THANKS'     	    => [
		1 => ' a jeden další uživatel',
		2 => ' a %d dalších uživatelů',
	],

	'NO_VIEW_USERS_THANKS'		=> 'Nemáte oprávnění zobrazit seznam poděkování.',

	'NOTIFICATION_THANKS_GIVE'	=> [
		1 => '<strong>Obdrženo poděkování </strong> od %1$s za příspěvek:',
		2 => '<strong>Obdržena poděkování</strong> od %1$s za příspěvek:',
	],
	'NOTIFICATION_THANKS_REMOVE'=> [
		1 => '<strong>Odebráno poděkování</strong> od %1$s za příspěvěk:',
		2 => '<strong>Odebrána poděkování</strong> od %1$s za příspěvek:',
	],
	'NOTIFICATION_TYPE_THANKS_GIVE'		=> 'Někdo poděkoval za váš příspěvek',
	'NOTIFICATION_TYPE_THANKS_REMOVE'	=> 'Někdo odebral poděkování za váš příspěvek',

	'RECEIVED'					=> 'Dostal&nbsp;poděkování',
	'REMOVE_THANKS'				=> 'Odebrat poděkování: ',
	'REMOVE_THANKS_CONFIRM'		=> 'Opravdu chcete odebrat poděkování?',
	'REMOVE_THANKS_SHORT'		=> 'Odebrat poděkování',
	'REPUT'						=> 'Hodnocení',
	'REPUT_TOPLIST'				=> 'Toplist — %d',
	'RATING_LOGIN_EXPLAIN'		=> 'Nemáte oprávnění zobrazit toplist.',
	'RATING_NO_VIEW_TOPLIST'	=> 'Nemáte oprávnění zobrazit toplist.',
	'RATING_VIEW_TOPLIST_NO'	=> 'Toplist je prázdný nebo zakázaný administrátorem',
	'RATING_FORUM'				=> 'Fórum',
	'RATING_POST'				=> 'Příspěvek',
	'RATING_TOP_FORUM'			=> 'Fóra s nejvíce poděkováními',
	'RATING_TOP_POST'			=> 'Příspěvky s nejvíce poděkováními',
	'RATING_TOP_TOPIC'			=> 'Témata s nejvíce poděkováními',
	'RATING_TOPIC'				=> 'Téma',

	'THANK'						=> 'krát',
	'THANK_FROM'				=> 'od',
	'THANK_TEXT_1'				=> 'Tito uživatelé poděkovali autorovi ',
	'THANK_TEXT_2'				=> ' za příspěvek: ',
	'THANK_TEXT_2PL'			=> ' za příspěvky (celkem %d):',
	'THANK_POST'				=> 'Poděkujte autorovi příspěvku: ',
	'THANK_POST_SHORT'			=> 'Poděkujte',
	'THANKS'					=> [
		1	=> '%d poděkování',
		2	=> '%d poděkování',
	],
	'THANKS_BACK'				=> 'Zpět',
	'THANKS_INFO_GIVE'			=> 'Poděkoval jste za tuto zprávu.',
	'THANKS_INFO_REMOVE'		=> 'Odebral jste poděkování.',
	'THANKS_LIST'				=> 'Zobraz/zavři přehled',
	'THANKS_PM_MES_GIVE'		=> 'vám poděkoval za příspěvek',
	'THANKS_PM_MES_REMOVE'		=> 'odebral poděkování za příspěvek',
	'THANKS_PM_SUBJECT_GIVE'	=> 'Poděkování za příspěvek',
	'THANKS_PM_SUBJECT_REMOVE'	=> 'Odebrané poděkování za příspěvek',
	'THANKS_USER'				=> 'Seznam poděkování',
	'TOPLIST'					=> 'Toplist',
]);
