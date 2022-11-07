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
* rudi_br:
* Translated into danish and the "Thanks" term, which is "Tak" in danish, changed into "syntes godt om" / "Like"
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
	'CLEAR_LIST_THANKS'			=> 'Nulstil syntes godt om liste',
	'CLEAR_LIST_THANKS_CONFIRM'	=> 'Vil du virkelig nulstille brugerens syntes godt om liste?',
	'CLEAR_LIST_THANKS_GIVE'	=> 'Syntes godt om listen fra brugeren blev nulstillet.',
	'CLEAR_LIST_THANKS_POST'	=> 'Syntes godt om listen i beskeden blev nulstillet.',
	'CLEAR_LIST_THANKS_RECEIVE'	=> 'Listen af syntes godt om opnået af brugeren blen nulstillet.',

	'DISABLE_REMOVE_THANKS'		=> 'Sletning af syntes godt om er slået fra af administratoren',

	'GIVEN'						=> 'Har&nbsp;syntes godt om',
	'GLOBAL_INCORRECT_THANKS'	=> 'Du kan ikke syntes godt om en Global Meddelelse som ikke refererer til et specifikt forum.',
	'GRATITUDES'				=> 'syntes godt om liste',

	'INCORRECT_THANKS'			=> 'Ugyldigt syntes godt om',

	'JUMP_TO_FORUM'				=> 'Gå til forum',
	'JUMP_TO_TOPIC'				=> 'Gå til topic',

	'FOR_MESSAGE'				=> ' for indlæg',
	'FURTHER_THANKS'     	    => [
		1 => ' og flere brugere',
		2 => ' og %d flere brugere',
	],

	'NO_VIEW_USERS_THANKS'		=> 'Du er ikke autoriseret til at se syntes godt om listen.',

	'NOTIFICATION_THANKS_GIVE'	=> [
		1 => '%1$s <strong>syntes godt om </strong> dit indlæg:',
		2 => '%1$s <strong>syntes godt om</strong> dit indlæg:',
	],
	'NOTIFICATION_THANKS_REMOVE'=> [
		1 => '<strong>Fjernede syntes godt om</strong> fra %1$s for indlæget:',
		2 => '<strong>Fjernede syntes godt om</strong> fra %1$s for indlæget:',
	],
	'NOTIFICATION_TYPE_THANKS_GIVE'		=> 'Nogen syntes godt om dit indlæg',
	'NOTIFICATION_TYPE_THANKS_REMOVE'	=> 'Nogen fjernede en syntes godt omfra dit indlæg',

	'RECEIVED'					=> 'Er blevet&nbsp;syntes godt om',
	'REMOVE_THANKS'				=> 'Fjern dit syntes godt om fra indlæg af: ',
	'REMOVE_THANKS_CONFIRM'		=> 'Er du sikker på at du vil fjerne dit syntes godt om?',
	'REMOVE_THANKS_SHORT'		=> 'Fjern syntes godt om',
	'REPUT'						=> 'Rangering',
	'REPUT_TOPLIST'				=> 'Syntes godt om topscore — %d',
	'RATING_LOGIN_EXPLAIN'		=> 'Du er ikke autoriseret til at se topscore.',
	'RATING_NO_VIEW_TOPLIST'	=> 'Du er ikke autoriseret til at se topscore.',
	'RATING_VIEW_TOPLIST_NO'	=> 'Topscore er slået fra af administratoren',
	'RATING_FORUM'				=> 'Forum',
	'RATING_POST'				=> 'Indlæg',
	'RATING_TOP_FORUM'			=> 'Ragnering forums',
	'RATING_TOP_POST'			=> 'Ragnering indlæg',
	'RATING_TOP_TOPIC'			=> 'Ragnering emner',
	'RATING_TOPIC'				=> 'Emne',

	'THANK'						=> 'tid',
	'THANK_FROM'				=> 'fra',
	'THANK_TEXT_1'				=> 'Disse brugere syntes godt om ',
	'THANK_TEXT_2'				=> '&apos;s indlæg: ',
	'THANK_TEXT_2PL'			=> '&apos;s indlæg (total %d):',
	'THANK_POST'				=> 'Syntes godt om indlæget af: ',
	'THANK_POST_SHORT'			=> 'Syntes godt om',
	'THANKS'					=> [
		1	=> '%d gang',
		2	=> '%d gange',
	],
	'THANKS_BACK'				=> 'Tilbage',
	'THANKS_INFO_GIVE'			=> 'Du har lige syntes godt om indlæget.',
	'THANKS_INFO_REMOVE'		=> 'Du har lige fjernet dit syntes godt om.',
	'THANKS_LIST'				=> 'Se/luk listen',
	'THANKS_PM_MES_GIVE'		=> 'syntes godt om dit indlæg',
	'THANKS_PM_MES_REMOVE'		=> 'har fjernet sit syntes godt om fra indlæget',
	'THANKS_PM_SUBJECT_GIVE'	=> 'Syntes godt om indlæget',
	'THANKS_PM_SUBJECT_REMOVE'	=> 'Fjernede syntes godt om indlæget',
	'THANKS_USER'				=> 'Syntes godt om liste',
	'TOPLIST'					=> 'Syntes godt om topscore',
]);
