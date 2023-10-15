<?php
/**
*
* Thanks For Posts extension for the phpBB Forum Software package.
*
* @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
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
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'CLEAR_LIST_THANKS'			=> 'Tühejenda tänude loeteleu',
	'CLEAR_LIST_THANKS_CONFIRM'	=> 'Kas sa tõesti tahad kõik tänuavaldused kustudtad? ',
	'CLEAR_LIST_THANKS_GIVE'	=> 'Nimekiri tühejadatud.',
	'CLEAR_LIST_THANKS_POST'	=> 'List of thanks in the message was cleared.',
	'CLEAR_LIST_THANKS_RECEIVE'	=> 'List of thanks obtained by the user was cleared.',

	'DISABLE_REMOVE_THANKS'		=> 'See protseduur on administraatori poolt keelatud',

	'GIVEN'						=> 'Tänanud',
	'GLOBAL_INCORRECT_THANKS'	=> 'You cannot give thanks for a Global Announcement that has no reference to a particular forum.',
	'GRATITUDES'				=> 'Tänunimekiri',

	'INCORRECT_THANKS'			=> 'Vigane',

	'JUMP_TO_FORUM'				=> 'Hüppa foorumisse',
	'JUMP_TO_TOPIC'				=> 'Hüppa teemasse',

	'FOR_MESSAGE'				=> ' postitus',
	'FURTHER_THANKS'     	    => ' and one more user',
	'FURTHER_THANKS_PL'         => ' and %d more users',

	'NO_VIEW_USERS_THANKS'		=> 'You are not authorised to view the Thanks List.',

	'NOTIFICATION_THANKS_GIVE'	=> array(
		1 => '<strong>Received thank</strong> from %1$s for the post:',
		2 => '<strong>Received thanks</strong> from %1$s for the post:',
	),
	'NOTIFICATION_THANKS_REMOVE'=> array(
		1 => '<strong>Removed thank</strong> from %1$s for the post:',
		2 => '<strong>Removed thanks</strong> from %1$s for the post:',
	),
	'NOTIFICATION_TYPE_THANKS_GIVE'		=> 'Someone thanks you for a post',
	'NOTIFICATION_TYPE_THANKS_REMOVE'	=> 'Someone removed thanks for your post',

	'RECEIVED'					=> 'Tänatud',
	'REMOVE_THANKS'				=> 'Võta tänuavaldus tagasi: ',
	'REMOVE_THANKS_CONFIRM'		=> 'Päriselt ka või?! Mitte eriti cool! Oled sa ikka 1000% kindel? ',
	'REMOVE_THANKS_SHORT'		=> 'Võta poolehoiuavaldus tagasi',
	'REPUT'						=> 'Skoor',
	'REPUT_TOPLIST'				=> 'Enimtänatud kasutajad — TOP %d',
	'RETING_LOGIN_EXPLAIN'		=> 'Sul puudub selleks tegevuseks volitus.',
	'RATING_NO_VIEW_TOPLIST'	=> 'Sul puudub vaatamiseks volitus.',
	'RATING_VIEW_TOPLIST_NO'	=> 'Nimekiri on tühi või administraatori poolt välja lülitaud.',
	'RATING_FORUM'				=> 'Foorum',
	'RATING_POST'				=> 'Post',
	'RATING_TOP_FORUM'			=> 'Rating forums',
	'RATING_TOP_POST'			=> 'Rating posts',
	'RATING_TOP_TOPIC'			=> 'Teema reiting.',
	'RATING_TOPIC'				=> 'Teema',
//	'RETURN_POST'				=> 'Tagasi',

	'THANK'						=> 'aeg',
	'THANK_FROM'				=> 'from',
	'THANK_TEXT_1'				=> '<b>⚡ Lahe! </b>',
	'THANK_TEXT_2'				=> ', lase samas vaimus edasi 👍 →',
	'THANK_TEXT_2PL'			=> ', lase samas vaimus edasi (%dx 👍) →',
	'THANK_POST'				=> 'Ütle "Aitäh": ',
	'THANK_POST_SHORT'			=> 'Tänud',
	'THANKS'					=> array(
		1	=> '%d kord',
		2	=> '%d korda',
	),
	'THANKS_BACK'				=> 'Tagasi',
	'THANKS_INFO_GIVE'			=> 'Sa just avaldasid oma poolehoidu.',
	'THANKS_INFO_REMOVE'		=> 'Sinu poolehoiauavaldus on eemaldatud.',
	'THANKS_LIST'				=> 'Kuva/peida nimekiri',
	'THANKS_PM_MES_GIVE'		=> 'has thanked you for the post',
	'THANKS_PM_MES_REMOVE'		=> 'has removed thank for the post',
	'THANKS_PM_SUBJECT_GIVE'	=> 'Thank for the post',
	'THANKS_PM_SUBJECT_REMOVE'	=> 'Removed thank for the post',
	'THANKS_USER'				=> 'Tänamiste nimekiri',

	'THANKS_INSTALLED'			=> 'Thanks for the post',
	'THANKS_INSTALLED_EXPLAIN'  => '<strong>CAUTION!<br />You are strongly advised to only run this installation after following the instruction on code changes to the files (or perform the installation using AutoMod)! <br />It is also strongly recommended to select Yes to Display Full Results (below)!</strong>',
	'THANKS_CUSTOM0_FUNCTION'	=> 'Update values for the _thanks table',
	'THANKS_CUSTOM1_FUNCTION'	=> 'Check remove module',
	'THANKS_CUSTOM2_FUNCTION'	=> 'Check refrech cache',
	'TOPLIST'					=> 'Tänuga postituste toplist',
));
