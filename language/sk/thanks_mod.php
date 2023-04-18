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
	'CLEAR_LIST_THANKS'			=> 'Vymazať zoznam poďakovaní',
	'CLEAR_LIST_THANKS_CONFIRM'	=> 'Naozaj chcete vymazať zoznam poďakovaní užívateľa ?',
	'CLEAR_LIST_THANKS_GIVE'	=> 'Zoznam poďakovaní udelený používateľom bol vymazaný.',
	'CLEAR_LIST_THANKS_POST'	=> 'Zoznam poďakovaní v správe bol vymazaný.',
	'CLEAR_LIST_THANKS_RECEIVE'	=> 'Zoznam poďakovaní získaný používateľom bol vymazaný..',

	'DISABLE_REMOVE_THANKS'		=> 'Odstránenie poďakovania je zakázané správcom.',

	'GIVEN'						=> 'Dal&nbsp;poďakovanie',
	'GLOBAL_INCORRECT_THANKS'	=> 'Nemôžete poďakovať za globálne oznámenie, ktoré sa netýka konkrétneho fóra.',
	'GRATITUDES'				=> 'Poďakovanie',

	'INCORRECT_THANKS'			=> 'Neplatné poďakovanie',

	'JUMP_TO_FORUM'				=> 'Prejsť na fórum',
	'JUMP_TO_TOPIC'				=> 'Prejsť na tému',

	'FOR_MESSAGE'				=> ' za príspevok',
	'FURTHER_THANKS'     	    => [
		1 => ' a daľší užívateľ',
		2 => ' a %d daľších užívateľov',
	],

	'NO_VIEW_USERS_THANKS'		=> 'Nemáte oprávnenie zobraziť zoznam poďakovaní.',

	'NOTIFICATION_THANKS_GIVE'	=> [
		1 => '<strong>Obdržané poďakovanie</strong> od %1$s za príspevok :',
		2 => '<strong>Obdržané poďakovania</strong> od %1$s za príspevok :',
	],
	'NOTIFICATION_THANKS_REMOVE'=> [
		1 => '<strong>Odobrané poďakovanie</strong> od %1$s za príspevok :',
		2 => '<strong>Odobráné poďakovania</strong> od %1$s za príspevok :',
	],
	'NOTIFICATION_TYPE_THANKS_GIVE'		=> 'Niekto poďakoval za váš príspevok.',
	'NOTIFICATION_TYPE_THANKS_REMOVE'	=> 'Niekto odobral poďakovanie za váš príspevok.',

	'RECEIVED'					=> 'Dostal&nbsp;poďakovanie',
	'REMOVE_THANKS'				=> 'Odobrať poďakovanie : ',
	'REMOVE_THANKS_CONFIRM'		=> 'Naozaj chcete odobrať poďakovanie ?',
	'REMOVE_THANKS_SHORT'		=> 'Odobrať poďakovanie',
	'REPUT'						=> 'Hodnotenie',
	'REPUT_TOPLIST'				=> 'Toplist — %d',
	'RATING_LOGIN_EXPLAIN'		=> 'Pre zobrazenie toplistu musíte byť prihlásený.',
	'RATING_NO_VIEW_TOPLIST'	=> 'Nemáte oprávnenie na zobrazenie toplistu.',
	'RATING_VIEW_TOPLIST_NO'	=> 'Toplist je prázdny alebo zakázaný administrátorom',
	'RATING_FORUM'				=> 'Fórum',
	'RATING_POST'				=> 'Príspevok',
	'RATING_TOP_FORUM'			=> 'Fóra s najviac poďakovaniami',
	'RATING_TOP_POST'			=> 'Príspevky s najviac poďakovaniami',
	'RATING_TOP_TOPIC'			=> 'Témy s najviac poďakovaniami',
	'RATING_TOPIC'				=> 'Téma',

	'THANK'						=> 'krát',
	'THANK_FROM'				=> 'od',
	'THANK_TEXT_1'				=> 'Títo uživatelia poďakovali autorovi ',
	'THANK_TEXT_2'				=> ' za príspevok : ',
	'THANK_TEXT_2PL'			=> ' za príspevky (celkom %d):',
	'THANK_POST'				=> 'Poďakujte autorovi príspevku : ',
	'THANK_POST_SHORT'			=> 'Poďakujte',
	'THANKS'					=> [
		1	=> '%d krát',
		2	=> '%d krát',
	],
	'THANKS_BACK'				=> 'Späť',
	'THANKS_INFO_GIVE'			=> 'Poďakoval ste za túto správu.',
	'THANKS_INFO_REMOVE'		=> 'Odobral ste poďakovanie.',
	'THANKS_LIST'				=> 'Zobraz / zavri prehľad',
	'THANKS_PM_MES_GIVE'		=> 'vám poďakoval za príspevok',
	'THANKS_PM_MES_REMOVE'		=> 'odobral poďakovanie za príspevok',
	'THANKS_PM_SUBJECT_GIVE'	=> 'Poďakovanie za príspevok',
	'THANKS_PM_SUBJECT_REMOVE'	=> 'Odobrané poďakovanie za príspevok',
	'THANKS_USER'				=> 'Zoznam poďakovaní',
	'TOPLIST'					=> 'Toplist',
]);
