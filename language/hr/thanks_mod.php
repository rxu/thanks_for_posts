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
	'CLEAR_LIST_THANKS'			=> 'Brisanje liste zahvala',
	'CLEAR_LIST_THANKS_CONFIRM'	=> 'Zaista želiš obrisati korisničku listu zahvala?',
	'CLEAR_LIST_THANKS_GIVE'	=> 'Lista zahvala izdana korisnicima je obrisana.',
	'CLEAR_LIST_THANKS_POST'	=> 'Lista zahvala u poruci je obrisana.',
	'CLEAR_LIST_THANKS_RECEIVE'	=> 'Lista zahvala dobivena od korisnika je obrisana.',
	'DISABLE_REMOVE_THANKS'		=> 'Brisanje zahvala onemogućeno je od administratora.',
	'GIVEN'						=> 'Ima&nbsp;zahvala',
	'GLOBAL_INCORRECT_THANKS'	=> 'Ne možeš dati zahvalu na globalnu obavijest koja nema referencu na određeni forum.',
	'GRATITUDES'				=> 'Lista zahvala',
	'INCORRECT_THANKS'			=> 'Nevažeća zahvala',
	'JUMP_TO_FORUM'				=> 'Prebaci se na forum',
	'JUMP_TO_TOPIC'				=> 'Prebaci se na temu',
	'FOR_MESSAGE'				=> ' za post',
	'FURTHER_THANKS'     	    => [
		1 => ' i još jedan korisnik',
		2 => ' i još %d korisnika',
	],

	'NO_VIEW_USERS_THANKS'		=> 'Nemaš ovlasti vidjeti Listu zahvala.',
	'NOTIFICATION_THANKS_GIVE'	=> [
		1 => '<strong>Primljena zahvala</strong> od %1$s za post:',
		2 => '<strong>Primljene zahvale</strong> od %1$s za post:',
	],
	'NOTIFICATION_THANKS_REMOVE'=> [
		1 => '<strong>Uklonjena zahvala</strong> od %1$s za post:',
		2 => '<strong>Uklonjene zahvale</strong> od %1$s za post:',
	],
	'NOTIFICATION_TYPE_THANKS_GIVE'		=> 'Netko je zahvalio na tvojem postu',
	'NOTIFICATION_TYPE_THANKS_REMOVE'	=> 'Netko je uklonio zahvalu s tvojeg posta',

	'RECEIVED'					=> '&nbsp;pohvaljen',
	'REMOVE_THANKS'				=> 'Ukloni svoje zahvale: ',
	'REMOVE_THANKS_CONFIRM'		=> 'Zaista želiš ukloniti svoje zahvale?',
	'REMOVE_THANKS_SHORT'		=> 'Ukloni zahvale',
	'REPUT'						=> 'Ocjena',
	'REPUT_TOPLIST'				=> 'Toplista zahvala — %d',
	'RATING_LOGIN_EXPLAIN'		=> 'Nemaš ovlasti vidjeti toplistu.',
	'RATING_NO_VIEW_TOPLIST'	=> 'Nemaš ovlasti vidjeti toplistu.',
	'RATING_VIEW_TOPLIST_NO'	=> 'Toplista je prazna ili onemogućena od administratora',
	'RATING_FORUM'				=> 'Forum',
	'RATING_POST'				=> 'Post',
	'RATING_TOP_FORUM'			=> 'Ocjenjeni forumi',
	'RATING_TOP_POST'			=> 'Ocjenjeni postovi',
	'RATING_TOP_TOPIC'			=> 'Ocjenjene teme',
	'RATING_TOPIC'				=> 'Tema',

	'THANK'						=> 'vrijeme',
	'THANK_FROM'				=> 'od',
	'THANK_TEXT_1'				=> 'Ovi su korisnici zahvalili autoru ',
	'THANK_TEXT_2'				=> ' za post: ',
	'THANK_TEXT_2PL'			=> ' za post (ukupno %d):',
	'THANK_POST'				=> 'Zahvali se autoru posta:  ',
	'THANK_POST_SHORT'			=> 'Hvala',
	'THANKS'					=> [
		1	=> '%d put',
		2	=> '%d puta',
	],
	'THANKS_BACK'				=> 'Povrat',
	'THANKS_INFO_GIVE'			=> 'Upravo si zahvalio na postu.',
	'THANKS_INFO_REMOVE'		=> 'upravo si uklonio zahvalu.',
	'THANKS_LIST'				=> 'Pogledaj/Zatvori listu',
	'THANKS_PM_MES_GIVE'		=> 'zahvaljeno je na tvom postu',
	'THANKS_PM_MES_REMOVE'		=> 'uklonjena je zahvala tvom postu',
	'THANKS_PM_SUBJECT_GIVE'	=> 'Zahvali na postu',
	'THANKS_PM_SUBJECT_REMOVE'	=> 'Ukloni zahvalu s posta',
	'THANKS_USER'				=> 'Lista zahvala',
	'TOPLIST'					=> 'Toplista postova',
]);
