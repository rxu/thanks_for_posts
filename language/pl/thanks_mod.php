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
	'CLEAR_LIST_THANKS'			=> 'Wyczyść listę podziękowań',
	'CLEAR_LIST_THANKS_CONFIRM'	=> 'Czy na pewno chcesz wyczyścić listę podziękowań użytkownika?',
	'CLEAR_LIST_THANKS_GIVE'	=> 'Lista podziękowań wystawionych przez użytkownika została wyczyszczona.',
	'CLEAR_LIST_THANKS_POST'	=> 'Lista podziękowań w wiadomości została wyczyszczona.',
	'CLEAR_LIST_THANKS_RECEIVE'	=> 'Lista podziękowań otrzymanych przez użytkownika została wyczyszczona.',

	'DISABLE_REMOVE_THANKS'		=> 'Usuwanie podziękowań zostało wyłączone przez administratora',

	'GIVEN'						=> 'Podziękował',
	'GLOBAL_INCORRECT_THANKS'	=> 'Nie możesz podziękować za Ogłoszenie globalne, które nie ma odniesienia do konkretnego forum.',
	'GRATITUDES'				=> 'Lista podziękowań',

	'INCORRECT_THANKS'			=> 'Nieprawidłowe podziękowanie',

	'JUMP_TO_FORUM'				=> 'Przejdź do forum',
	'JUMP_TO_TOPIC'				=> 'Przejdź do tematu',

	'FOR_MESSAGE'				=> ' za post',
	'FURTHER_THANKS'			=> [
		1 => ' i jeszcze jeden użytkownik',
		2 => ' i %d kolejnych użytkowników',
	],

	'NO_VIEW_USERS_THANKS'		=> 'Nie masz uprawnień do przeglądania listy podziękowań.',

	'NOTIFICATION_THANKS_GIVE'	=> [
		1 => '%1$s <strong>podziękował</strong> za ten post:',
		2 => '%1$s <strong>podziękowali</strong> za ten post:',
	],
	'NOTIFICATION_THANKS_REMOVE'=> [
		1 => '<strong>Usunięto podziękowanie</strong> od %1$s za post:',
		2 => '<strong>Usunięto podziękowania</strong> od %1$s za post:',
	],
	'NOTIFICATION_TYPE_THANKS_GIVE'	=> 'Ktoś dziękuje za twój post',
	'NOTIFICATION_TYPE_THANKS_REMOVE'	=> 'Ktoś usunął podziękowanie za twój post',

	'RECEIVED'					=> 'Otrzymał&nbsp;podziękowanie',
	'REMOVE_THANKS'				=> 'Usuń swoje podziękowanie: ',
	'REMOVE_THANKS_CONFIRM'		=> 'Czy na pewno chcesz usunąć swoje podziękowanie?',
	'REMOVE_THANKS_SHORT'		=> 'Usuń podziękowanie',
	'REPUT'						=> 'Ocena',
	'REPUT_TOPLIST'				=> 'Toplista podziękowań — %d',
	'RATING_LOGIN_EXPLAIN'		=> 'Nie masz uprawnień do przeglądania toplisty.',
	'RATING_NO_VIEW_TOPLIST'	=> 'Nie masz uprawnień do przeglądania toplisty.',
	'RATING_VIEW_TOPLIST_NO'	=> 'Toplista jest pusta lub została wyłączona przez administratora',
	'RATING_FORUM'				=> 'Forum',
	'RATING_POST'				=> 'Post',
	'RATING_TOP_FORUM'			=> 'Ocena forów',
	'RATING_TOP_POST'			=> 'Ocena postów',
	'RATING_TOP_TOPIC'			=> 'Ocena tematów',
	'RATING_TOPIC'				=> 'Temat',

	'THANK'						=> 'raz',
	'THANK_FROM'				=> 'od',
	'THANK_TEXT_1'				=> 'Użytkownicy, którzy podziękowali autorowi ',
	'THANK_TEXT_2'				=> ', za post: ',
	'THANK_TEXT_2PL'			=> ', za post (łącznie %d):',
	'THANK_POST'				=> 'Podziękuj autorowi za ten post: ',
	'THANK_POST_SHORT'			=> 'Podziękuj',
	'THANKS'					=> [
		1	=> '%d raz',
		2	=> '%d razy',
	],
	'THANKS_BACK'				=> 'Powrót',
	'THANKS_INFO_GIVE'			=> 'Właśnie podziękowałeś za post.',
	'THANKS_INFO_REMOVE'		=> 'Właśnie usunąłeś swoje podziękowanie.',
	'THANKS_LIST'				=> 'Pokaż/ukryj listę',
	'THANKS_PM_MES_GIVE'		=> 'podziękował ci za post',
	'THANKS_PM_MES_REMOVE'		=> 'usunął podziękowanie za post',
	'THANKS_PM_SUBJECT_GIVE'	=> 'Podziękowanie za post',
	'THANKS_PM_SUBJECT_REMOVE'	=> 'Usunięte podziękowanie za post',
	'THANKS_USER'				=> 'Lista podziękowań',
	'TOPLIST'					=> 'Toplista postów',
]);
