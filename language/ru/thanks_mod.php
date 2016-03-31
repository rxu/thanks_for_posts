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
	'CLEAR_LIST_THANKS'			=> 'Очистить список благодарностей',
	'CLEAR_LIST_THANKS_CONFIRM'	=> 'Вы действительно хотите очистить список благодарностей пользователя?',
	'CLEAR_LIST_THANKS_GIVE'	=> 'Cписок благодарностей, выданных пользователем, очищен.',
	'CLEAR_LIST_THANKS_POST'	=> 'Список благодарностей в сообщении очищен.',
	'CLEAR_LIST_THANKS_RECEIVE'	=> 'Список благодарностей, полученных пользователем, очищен.',

	'DISABLE_REMOVE_THANKS'		=> 'Удаление благодарностей отключено администратором.',

	'GIVEN'						=> 'Благодарил&nbsp;(а)',
	'GLOBAL_INCORRECT_THANKS'	=> 'Вы не можете благодарить в важных темах, не имеющих привязки к конкретному форуму.',
	'GRATITUDES'				=> 'Благодарности',

	'INCORRECT_THANKS'			=> 'Некорректные параметры запрошенного действия',

	'JUMP_TO_FORUM'				=> 'Перейти в форум',
	'JUMP_TO_TOPIC'				=> 'Перейти в тему',

	'FOR_MESSAGE'				=> ' за сообщение',
	'FURTHER_THANKS'     	    => ' и ещё один',
	'FURTHER_THANKS_PL'         => ' и ещё %d',

	'NO_VIEW_USERS_THANKS'		=> 'У вас нет доступа к просмотру списка благодарностей.',

	'NOTIFICATION_TYPE_THANKS'	=> 'Вас поблагодарили за сообщение',

	'NOTIFICATION_THANKS_GIVE'	=> array(
		1 => '<strong>Получена благодарность</strong> от пользователя %1$s за сообщение:',
		2 => '<strong>Получены благодарности</strong> от пользователей %1$s за сообщение:',
	),
	'NOTIFICATION_THANKS_REMOVE'=> array(
		1 => '<strong>Удалена благодарность</strong> от пользователя %1$s за сообщение:',
		2 => '<strong>Удалены благодарности</strong> от пользователей %1$s за сообщение:',
	),
	'NOTIFICATION_TYPE_THANKS_GIVE'		=> 'Вас поблагодарили за сообщение',
	'NOTIFICATION_TYPE_THANKS_REMOVE'	=> 'Удалена благодарность за ваше сообщение',

	'RECEIVED'					=> 'Поблагодарили',
	'REMOVE_THANKS'				=> 'Отменить благодарность автору: ',
	'REMOVE_THANKS_CONFIRM'		=> 'Вы действительно хотите удалить благодарность?',
	'REMOVE_THANKS_SHORT'		=> 'Отменить благодарность',
	'REPUT'						=> 'Рейтинг',
	'REPUT_TOPLIST'				=> 'Топлист — %d благодарностей',
	'RATING_LOGIN_EXPLAIN'		=> 'Для просмотра топлиста вы должны быть авторизованы',
	'RATING_NO_VIEW_TOPLIST'	=> 'Вы не авторизованы для просмотра топлиста',
	'RATING_VIEW_TOPLIST_NO'	=> 'Топлист пуст или отключен администратором',
	'RATING_FORUM'				=> 'Форум',
	'RATING_POST'				=> 'Сообщение',
	'RATING_TOP_FORUM'			=> 'Рейтинг форумов',
	'RATING_TOP_POST'			=> 'Рейтинг сообщений',
	'RATING_TOP_TOPIC'			=> 'Рейтинг тем',
	'RATING_TOPIC'				=> 'Тема',
//	'RETURN_POST'				=> 'Вернуться к сообщению',

	'THANK'						=> 'раз.',
	'THANK_POST'				=> 'Поблагодарить за сообщение автора: ',
	'THANK_POST_SHORT'			=> 'Поблагодарить',
	'THANK_FROM'				=> 'от',
	'THANK_TEXT_1'				=> 'За это сообщение автора ',
	'THANK_TEXT_2'				=> ' поблагодарил:',
	'THANK_TEXT_2PL'			=> ' поблагодарили (всего %d):',
	'THANKS'					=> array(
		1	=> '%d раз',
		2	=> '%d раза',
		3	=> '%d раз',
	),
	'THANKS_BACK'				=> 'Вернуться к листу благодарностей',
	'THANKS_INFO_GIVE'			=> 'Вы поблагодарили автора сообщения',
	'THANKS_INFO_REMOVE'		=> 'Вы отменили благодарность автору',
	'THANKS_LIST'				=> 'Показать/Скрыть список',
	'THANKS_PM_MES_GIVE'		=> 'поблагодарил вас за сообщение',
	'THANKS_PM_MES_REMOVE'		=> 'отменил благодарность за сообщение',
	'THANKS_PM_SUBJECT_GIVE'	=> 'Благодарность за сообщение',
	'THANKS_PM_SUBJECT_REMOVE'	=> 'Благодарность за сообщение отменена',
	'THANKS_USER'				=> 'Лист благодарностей',

	'THANKS_INSTALLED'			=> 'Благодарность за сообщение',
	'THANKS_INSTALLED_EXPLAIN' 	=> '<strong>ВНИМАНИЕ!<br />Рекомендуется запускать данную установку только после выполнения инструкции по внесению изменений в код файлов конференции (или выполнения установки с помощью AutoMod)!<br />Также настоятельно рекомендуется включить опцию Отображать все результаты (ниже)!</strong>',
	'THANKS_CUSTOM0_FUNCTION'	=> 'Обновление данных в таблице _thanks',
	'THANKS_CUSTOM1_FUNCTION'	=> 'Проверка удаления модуля',
	'THANKS_CUSTOM2_FUNCTION'	=> 'Проверка обновления кеша',
	'TOPLIST'					=> 'Топлист сообщений',
));
