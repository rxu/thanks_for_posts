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
	'CLEAR_LIST_THANKS'			=> 'Teşekkür Listesini Temizle',
	'CLEAR_LIST_THANKS_CONFIRM'	=> 'Kullanıcı Teşekkür Listesini gerçekten silmek istiyor musunuz?',
	'CLEAR_LIST_THANKS_GIVE'	=> 'Kullanıcı tarafından verilen teşekkürlerin listesi temizlendi.',
	'CLEAR_LIST_THANKS_POST'	=> 'Mesajdaki teşekkür listesi silindi.',
	'CLEAR_LIST_THANKS_RECEIVE'	=> 'Kullanıcı tarafından alınan teşekkürlerin listesi temizlendi.',

	'DISABLE_REMOVE_THANKS'		=> 'Teşekkürleri silme yönetici tarafından devre dışı bırakıldı',

	'GIVEN'						=> 'Edilen teşekkür&nbsp;',
	'GLOBAL_INCORRECT_THANKS'	=> 'Belirli bir foruma referansı olmayan Genel Duyuru için teşekkür edemezsiniz.',
	'GRATITUDES'				=> 'Teşekkür Listesi',

	'INCORRECT_THANKS'			=> 'Geçersiz teşekkür',

	'JUMP_TO_FORUM'				=> 'Foruma git',
	'JUMP_TO_TOPIC'				=> 'Konuya git',

	'FOR_MESSAGE'				=> ' mesaj için',
	'FURTHER_THANKS'     	    => [
		1 => ' ve bir kullanıcı için',
		2 => ' ve %d kullanıcı için',
	],

	'NO_VIEW_USERS_THANKS'		=> 'Teşekkürler Listesini görüntüleme izniniz yok.',

	'NOTIFICATION_THANKS_GIVE'	=> [
		1 => 'Mesaj için %1$s kişisinden <strong>teşekkür aldı</strong>:',
		2 => 'Mesaj için %1$s kişilerden <strong>teşekkür aldı</strong>:',
	],
	'NOTIFICATION_THANKS_REMOVE'=> [
		1 => 'Mesajdan %1$s kişisinin <strong>teşekkürü kaldırıldı</strong>:',
		2 => 'Mesajdan %1$s kişisinin <strong>teşekkürü kaldırıldı</strong>:',
	],
	'NOTIFICATION_TYPE_THANKS_GIVE'		=> 'Birisi mesajınız için teşekkür ediyor',
	'NOTIFICATION_TYPE_THANKS_REMOVE'	=> 'Birisi mesajınızdan için teşekkürü kaldırdı',

	'RECEIVED'					=> 'Alınan teşekkür&nbsp;',
	'REMOVE_THANKS'				=> 'Teşekkürleri kaldır: ',
	'REMOVE_THANKS_CONFIRM'		=> 'Teşekkürlerinizi kaldırmak istediğinizden emin misiniz?',
	'REMOVE_THANKS_SHORT'		=> 'Teşekkürleri kaldır',
	'REPUT'						=> 'Değerlendirme',
	'REPUT_TOPLIST'				=> 'Teşekkürler Toplisti — %d',
	'RATING_LOGIN_EXPLAIN'		=> 'Toplisti görüntüleme yetkiniz yok.',
	'RATING_NO_VIEW_TOPLIST'	=> 'Toplisti görüntüleme yetkiniz yok.',
	'RATING_VIEW_TOPLIST_NO'	=> 'Toplist yönetici tarafından boş veya devre dışı',
	'RATING_FORUM'				=> 'Forum',
	'RATING_POST'				=> 'Mesaj',
	'RATING_TOP_FORUM'			=> 'Forumların reytingleri',
	'RATING_TOP_POST'			=> 'Mesajların reytingleri',
	'RATING_TOP_TOPIC'			=> 'Konuların reytingleri',
	'RATING_TOPIC'				=> 'Konu',

	'THANK'						=> 'time',
	'THANK_FROM'				=> 'from',
	'THANK_TEXT_1'				=> 'Bu kullanıcılar yazara teşekkür etti ',
	'THANK_TEXT_2'				=> ' mesaj için: ',
	'THANK_TEXT_2PL'			=> ' mesaj için (toplam %d):',
	'THANK_POST'				=> 'Mesaj yazarına teşekkür et: ',
	'THANK_POST_SHORT'			=> 'Teşekkür et',
	'THANKS'					=> [
		1	=> '%d',
		2	=> '%d',
	],
	'THANKS_BACK'				=> 'Geri dön',
	'THANKS_INFO_GIVE'			=> 'Mesaja teşekkür ettin.',
	'THANKS_INFO_REMOVE'		=> 'Mesajdan teşekkürü kaldırdın.',
	'THANKS_LIST'				=> 'Listeyi Görüntüle/ Kapat',
	'THANKS_PM_MES_GIVE'		=> 'mesajınız için teşekkür etti',
	'THANKS_PM_MES_REMOVE'		=> 'mesajınızdan teşekkürü kaldırdı',
	'THANKS_PM_SUBJECT_GIVE'	=> 'Mesaj için teşekkür',
	'THANKS_PM_SUBJECT_REMOVE'	=> 'Mesajdan teşekkürü kaldır',
	'THANKS_USER'				=> 'Teşekkür listesi',
	'TOPLIST'					=> 'Mesaj toplisti',
]);
