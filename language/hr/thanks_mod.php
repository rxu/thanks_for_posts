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
	'FURTHER_THANKS'     	    => ' i još jedan korisnik',
	'FURTHER_THANKS_PL'         => ' i još %d korisnika',
	'NO_VIEW_USERS_THANKS'		=> 'Nemaš ovlasti vidjeti Listu zahvala.',
	'NOTIFICATION_THANKS_GIVE'	=> array(
		1 => '<strong>Primljena zahvala</strong> od %1$s za post:',
		2 => '<strong>Primljene zahvale</strong> od %1$s za post:',
	),
	'NOTIFICATION_THANKS_REMOVE'=> array(
		1 => '<strong>Uklonjena zahvala</strong> od %1$s za post:',
		2 => '<strong>Uklonjene zahvale</strong> od %1$s za post:',
	),
	'NOTIFICATION_TYPE_THANKS_GIVE'		=> 'Someone thanks you for a post',
	'NOTIFICATION_TYPE_THANKS_REMOVE'	=> 'Someone removed thanks for your post',
	'RECEIVED'					=> 'Been&nbsp;thanked',
	'REMOVE_THANKS'				=> 'Remove your thanks: ',
	'REMOVE_THANKS_CONFIRM'		=> 'Are you sure you want to remove your thanks?',
	'REMOVE_THANKS_SHORT'		=> 'Remove thanks',
	'REPUT'						=> 'Rating',
	'REPUT_TOPLIST'				=> 'Thanks Toplist — %d',
	'RETING_LOGIN_EXPLAIN'		=> 'You are not authorised to view the toplist.',
	'RATING_NO_VIEW_TOPLIST'	=> 'You are not authorised to view the toplist.',
	'RATING_VIEW_TOPLIST_NO'	=> 'Toplist is empty or disabled by administrator',
	'RATING_FORUM'				=> 'Forum',
	'RATING_POST'				=> 'Post',
	'RATING_TOP_FORUM'			=> 'Rating forums',
	'RATING_TOP_POST'			=> 'Rating posts',
	'RATING_TOP_TOPIC'			=> 'Rating topics',
	'RATING_TOPIC'				=> 'Topic',
	'RETURN_POST'				=> 'Return',
	'THANK'						=> 'time',
	'THANK_FROM'				=> 'from',
	'THANK_TEXT_1'				=> 'These users thanked the author ',
	'THANK_TEXT_2'				=> ' for the post: ',
	'THANK_TEXT_2PL'			=> ' for the post (total %d):',
	'THANK_POST'				=> 'Say Thanks to the author of the post: ',
	'THANK_POST_SHORT'			=> 'Thanks',
	'THANKS'					=> array(
		1	=> '%d time',
		2	=> '%d times',
	),
	'THANKS_BACK'				=> 'Return',
	'THANKS_INFO_GIVE'			=> 'You have just thanked for the post.',
	'THANKS_INFO_REMOVE'		=> 'You have just removed your thank.',
	'THANKS_LIST'				=> 'View/Close list',
	'THANKS_PM_MES_GIVE'		=> 'has thanked you for the post',
	'THANKS_PM_MES_REMOVE'		=> 'has removed thank for the post',
	'THANKS_PM_SUBJECT_GIVE'	=> 'Thank for the post',
	'THANKS_PM_SUBJECT_REMOVE'	=> 'Removed thank for the post',
	'THANKS_USER'				=> 'List of thanks',
	'THANKS_INSTALLED'			=> 'Thanks for the post',
	'THANKS_INSTALLED_EXPLAIN'  => '<strong>CAUTION!<br />You are strongly advised to only run this installation after following the instruction on code changes to the files (or perform the installation using AutoMod)! <br />It is also strongly recommended to select Yes to Display Full Results (below)!</strong>',
	'THANKS_CUSTOM0_FUNCTION'	=> 'Update values for the _thanks table',
	'THANKS_CUSTOM1_FUNCTION'	=> 'Check remove module',
	'THANKS_CUSTOM2_FUNCTION'	=> 'Check refrech cache',
	'TOPLIST'					=> 'Posts toplist',
));
