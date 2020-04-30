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
	'CLEAR_LIST_THANKS'			=> 'Die Liste der Danksagungen löschen',
	'CLEAR_LIST_THANKS_CONFIRM'	=> 'Möchten Sie wirklich die Liste der Danksagungen des Benutzers löschen?',
	'CLEAR_LIST_THANKS_GIVE'	=> 'Die Liste der Danksagungen des Benutzers wurde gelöscht',
	'CLEAR_LIST_THANKS_POST'	=> 'Die Liste der Danksagungen im Beitrag wurde gelöscht.',
	'CLEAR_LIST_THANKS_RECEIVE'	=> 'Die Liste der Danksagungen, die der Benutzer erhalten hat, wurde gelöscht.',

	'DISABLE_REMOVE_THANKS'		=> 'Das Löschen von Danksagungen wurde vom Administrator deaktiviert.',

	'GIVEN'						=> 'Hat sich bedankt',
	'GLOBAL_INCORRECT_THANKS'	=> 'Sie können sich nicht für eine globale Ankündigung bedanken, wenn diese nicht in einem Forum zu finden ist.',
	'GRATITUDES'				=> 'Liste der Danksagungen',

	'INCORRECT_THANKS'			=> 'Ungültige Danksagung',

	'JUMP_TO_FORUM'				=> 'Zum Forum wechseln',
	'JUMP_TO_TOPIC'				=> 'Zum Thema wechseln',

	'FOR_MESSAGE'				=> ' für den Beitrag',
	'FURTHER_THANKS'     	    => [
		1 => ' und ein weiterer Benutzer',
		2 => ' und %d weitere Benutzer',
	],

	'NO_VIEW_USERS_THANKS'		=> 'Sie haben keine Berechtigung, die Liste der Danksagungen zu sehen.',

	'NOTIFICATION_THANKS_GIVE'	=> [
		1 => '<strong>Danksagung erhalten</strong> von %1$s für den Beitrag:',
		2 => '<strong>Danksagungen erhalten</strong> von %1$s für den Beitrag:',
	],
	'NOTIFICATION_THANKS_REMOVE'=> [
		1 => '<strong>Danksagung entfernt</strong> von %1$s für den Beitrag:',
		2 => '<strong>Danksagungen entfernt</strong> von %1$s für den Beitrag:',
	],
	'NOTIFICATION_TYPE_THANKS_GIVE'		=> 'Jemand hat sich für Ihren Beitrag bedankt.',
	'NOTIFICATION_TYPE_THANKS_REMOVE'	=> 'Jemand hat seine Danksagung für Ihren Beitrag entfernt.',

	'RECEIVED'					=> 'Danksagung erhalten',
	'REMOVE_THANKS'				=> 'Danksagung entfernen: ',
	'REMOVE_THANKS_CONFIRM'		=> 'Möchten Sie wirklich Ihre Danksagung entfernen?',
	'REMOVE_THANKS_SHORT'		=> 'Danksagung entfernen',
	'REPUT'						=> 'Bewertung',
	'REPUT_TOPLIST'				=> 'Danksagungen Topliste — %d',
	'RATING_LOGIN_EXPLAIN'		=> 'Sie sind nicht berechtigt, die Topliste zu sehen.',
	'RATING_NO_VIEW_TOPLIST'	=> 'Sie sind nicht berechtigt, die Topliste zu sehen.',
	'RATING_VIEW_TOPLIST_NO'	=> 'Die Topliste ist leer oder wurde durch den Administrator deaktiviert.',
	'RATING_FORUM'				=> 'Forum',
	'RATING_POST'				=> 'Beitrag',
	'RATING_TOP_FORUM'			=> 'Forenbewertung',
	'RATING_TOP_POST'			=> 'Beitragsbewertung',
	'RATING_TOP_TOPIC'			=> 'Themenbewertung',
	'RATING_TOPIC'				=> 'Thema',

	'THANK'						=> 'Mal',
	'THANK_FROM'				=> 'von',
	'THANK_TEXT_1'				=> 'Folgende Benutzer bedankten sich beim Autor ',
	'THANK_TEXT_2'				=> ' für den Beitrag: ',
	'THANK_TEXT_2PL'			=> ' für den Beitrag (Insgesamt %d):',
	'THANK_POST'				=> 'Bedanken Sie sich beim Autor des Beitrags: ',
	'THANK_POST_SHORT'			=> 'Danke',
	'THANKS'					=> [
		1	=> '%d Mal',
		2	=> '%d Mal',
	],
	'THANKS_BACK'				=> 'Zurück',
	'THANKS_INFO_GIVE'			=> 'Sie haben sich für den Beitrag bedankt.',
	'THANKS_INFO_REMOVE'		=> 'Sie haben Ihre Danksagung entfernt.',
	'THANKS_LIST'				=> 'Liste anzeigen/schließen',
	'THANKS_PM_MES_GIVE'		=> 'hat sich für den Beitrag bedankt',
	'THANKS_PM_MES_REMOVE'		=> 'hat seine Danksagung für den Beitrag entfernt',
	'THANKS_PM_SUBJECT_GIVE'	=> 'Danksagung für den Beitrag',
	'THANKS_PM_SUBJECT_REMOVE'	=> 'Danksagung entfernt für den Beitrag',
	'THANKS_USER'				=> 'Liste der Danksagungen',
	'TOPLIST'					=> 'Beitragstopliste',
]);
