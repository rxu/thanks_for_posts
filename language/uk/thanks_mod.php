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
	'CLEAR_LIST_THANKS'			=> 'Очистити список подяк',
	'CLEAR_LIST_THANKS_CONFIRM'	=> 'Ви дійсно хочете очистити список подяк користувача?',
	'CLEAR_LIST_THANKS_GIVE'	=> 'Cписок подяк, виданих користувачем, очищений.',
	'CLEAR_LIST_THANKS_POST'	=> 'Список подяк у повідомленні очищений.',
	'CLEAR_LIST_THANKS_RECEIVE'	=> 'Список подяк, отриманих користувачем, очищений.',

	'DISABLE_REMOVE_THANKS'		=> 'Видалення подяк відключено адміністратором.',

	'GIVEN'						=> 'Дякував&nbsp;(ла)',
	'GLOBAL_INCORRECT_THANKS'	=> 'Ви не можете дякувати у важливих темах, що не мають прив\'язки до конкретного форуму.',
	'GRATITUDES'				=> 'Подяки',

	'INCORRECT_THANKS'			=> 'Некоректні параметри запитаної дії',

	'JUMP_TO_FORUM'				=> 'Перейти в форум',
	'JUMP_TO_TOPIC'				=> 'Перейти в тему',

	'FOR_MESSAGE'				=> ' за повідомлення',
	'FURTHER_THANKS'     	    => [
		1 => ' і ще один',
		2 => ' і ще %d',
	],

	'NO_VIEW_USERS_THANKS'		=> 'У вас немає доступу до перегляду списку подяк.',

	'NOTIFICATION_THANKS_GIVE'	=> [
		1 => '<strong>Отримана подяка</strong> від користувача %1$s за повідомлення:',
		2 => '<strong>Отримані подяки</strong> від користувачів %1$s за повідомлення:',
	],
	'NOTIFICATION_THANKS_REMOVE'=> [
		1 => '<strong>Вилучена подяка</strong> від користувача %1$s за повідомлення:',
		2 => '<strong>Вилучені подяки</strong> від користувачів %1$s за повідомлення:',
	],
	'NOTIFICATION_TYPE_THANKS_GIVE'		=> 'Вам подякували за повідомлення',
	'NOTIFICATION_TYPE_THANKS_REMOVE'	=> 'Вилучено подяку за ваше повідомлення',

	'RECEIVED'					=> 'Подякували',
	'REMOVE_THANKS'				=> 'Скасувати подяку автору: ',
	'REMOVE_THANKS_CONFIRM'		=> 'Ви дійсно хочете видалити подяку?',
	'REMOVE_THANKS_SHORT'		=> 'Скасувати подяку',
	'REPUT'						=> 'Рейтинг',
	'REPUT_TOPLIST'				=> 'Топ лист подяк',
	'RATING_LOGIN_EXPLAIN'		=> 'Для перегляду топ листа ви повинні бути авторизовані',
	'RATING_NO_VIEW_TOPLIST'	=> 'Ви не авторизовані для перегляду топ листа',
	'RATING_VIEW_TOPLIST_NO'	=> 'Топ лист порожній або відключений адміністратором',
	'RATING_FORUM'				=> 'Форум',
	'RATING_POST'				=> 'Повідомлення',
	'RATING_TOP_FORUM'			=> 'Рейтинг форумів',
	'RATING_TOP_POST'			=> 'Рейтинг повідомлень',
	'RATING_TOP_TOPIC'			=> 'Рейтинг тем',
	'RATING_TOPIC'				=> 'Тема',

	'THANK'						=> 'раз.',
	'THANK_POST'				=> 'Подякувати за повідомлення автора: ',
	'THANK_POST_SHORT'			=> 'Подякувати',
	'THANK_FROM'				=> 'від',
	'THANK_TEXT_1'				=> 'За це повідомлення автора ',
	'THANK_TEXT_2'				=> ' подякував:',
	'THANK_TEXT_2PL'			=> ' подякували (всього %d):',
	'THANKS'					=> [
		1	=> '%d раз',
		2	=> '%d рази',
		3	=> '%d разів',
	],
	'THANKS_BACK'				=> 'Повернутися до листу подяк',
	'THANKS_INFO_GIVE'			=> 'Ви подякували автора повідомлення',
	'THANKS_INFO_REMOVE'		=> 'Ви скасували подяку автору',
	'THANKS_LIST'				=> 'Показати/Приховати список',
	'THANKS_PM_MES_GIVE'		=> 'Дякую за повідомлення',
	'THANKS_PM_MES_REMOVE'		=> 'Відміняю подяку за повідомлення',
	'THANKS_PM_SUBJECT_GIVE'	=> 'Подяка за повідомлення',
	'THANKS_PM_SUBJECT_REMOVE'	=> 'Подяка за повідомлення скасована',
	'THANKS_USER'				=> 'Лист подяк',
	'TOPLIST'					=> 'Топ лист повідомлень',
]);
