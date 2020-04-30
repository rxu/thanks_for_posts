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

$lang = array_merge($lang, [
	'ACP_DELTHANKS'						=> 'Видалено врахованих подяк',
	'ACP_POSTS'							=> 'Всього повідомлень',
	'ACP_POSTSEND'						=> 'Залишилося повідомлень з подяками',
	'ACP_POSTSTHANKS'					=> 'Було повідомлень з подяками',
	'ACP_THANKS'						=> 'Подяки',
	'ACP_THANKS_MOD_VER'				=> 'Версія МОДа: ',
	'ACP_THANKS_TRUNCATE'				=> 'Очищення списку подяк',
	'ACP_ALLTHANKS'						=> 'Було враховано подяк',
	'ACP_THANKSEND'						=> 'Залишилося враховано подяк',
	'ACP_THANKS_REPUT'					=> 'Налаштування рейтинга',
	'ACP_THANKS_REPUT_SETTINGS'			=> 'Налаштування рейтинга',
	'ACP_THANKS_REPUT_SETTINGS_EXPLAIN'	=> 'Тут ви можете встановити значення налаштувань рейтингу для повідомлень, тем і форумів, заснованого на системі ДЯКУЮ. Об\'єкт (повідомлення, тема або форум), що має найбільшу сумарну кількість подяк, приймається за 100% рейтингу.',
	'ACP_THANKS_SETTINGS'				=> 'Налаштування конфігурації',
	'ACP_THANKS_SETTINGS_EXPLAIN'		=> 'Тут ви можете встановити значення налаштувань функцій подяк за повідомлення.',
	'ACP_THANKS_REFRESH'				=> 'Оновлення лічильників',
	'ACP_UPDATETHANKS'					=> 'Оновлено врахованих подяк',
	'ACP_USERSEND'						=> 'Залишилося подякувавших користувачів',
	'ACP_USERSTHANKS'					=> 'Було подякувавших користувачів',

	'GRAPHIC_BLOCK_BACK'				=> 'ext/gfksx/thanksforposts/images/rating/reput_block_back.gif',
	'GRAPHIC_BLOCK_RED'					=> 'ext/gfksx/thanksforposts/images/rating/reput_block_red.gif',
	'GRAPHIC_DEFAULT'					=> 'Приклади зображень',
	'GRAPHIC_OPTIONS'					=> 'Налаштування графіки',
	'GRAPHIC_STAR_BACK'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_back.gif',
	'GRAPHIC_STAR_BLUE'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_blue.gif',
	'GRAPHIC_STAR_GOLD'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif',

	'IMG_THANKPOSTS'					=> 'Подякувати за повідомлення',
	'IMG_REMOVETHANKS'					=> 'Видалити подяку',

	'LOG_CONFIG_THANKS'					=> 'Оновлена ​​конфігурація МОДа Дякую за повідомлення',
	'REFRESH'							=> 'Оновити',
	'REMOVE_THANKS'						=> 'Видалення подяк',
	'REMOVE_THANKS_EXPLAIN'				=> 'Якщо включено, користувач може скасувати видану подяку.',

	'STEPR'								=> ' - виконання, крок %s',

	'THANKS_COUNTERS_VIEW'				=> 'Лічильники подяк',
	'THANKS_COUNTERS_VIEW_EXPLAIN'		=> 'Якщо включено, в блоці інформації про автора буде відображатися кількість виданих/отриманих подяк.',
	'THANKS_FORUM_REPUT_VIEW'			=> 'Відображення рейтингу для форумів',
	'THANKS_FORUM_REPUT_VIEW_EXPLAIN'	=> 'Якщо включено, в списку форумів буде відображений рейтинг форума.',
	'THANKS_GLOBAL_POST'				=> 'Подяки у важливих темах',
	'THANKS_GLOBAL_POST_EXPLAIN'		=> 'Якщо включено, подяки дозволені у важливих темах.',
	'THANKS_INFO_PAGE'					=> 'Інформаційні повідомлення',
	'THANKS_INFO_PAGE_EXPLAIN'			=> 'Якщо включено, після видачі/скасування подяки виводиться інформаційне повідомлення.',
	'THANKS_NOTICE_ON'					=> 'Сповіщення доступні.',
	'THANKS_NOTICE_ON_EXPLAIN'			=> 'Якщо включено, зауваження містяться і користувач може налаштовувати повідомлення в особистому розділі.',
	'THANKS_NUMBER'						=> 'Число подяк в списках профілю',
	'THANKS_NUMBER_EXPLAIN'				=> 'Максимальне число подяк, що відображається в списках в профілі.<br /><strong>Увага! Встановлення значення більш 250 може уповільнити роботу конференції.</strong>',
	'THANKS_NUMBER_DIGITS'				=> 'Число десяткових розрядів для рейтингу',
	'THANKS_NUMBER_DIGITS_EXPLAIN'		=> 'Вкажіть число десяткових розрядів після коми для значення рейтингу.',
	'THANKS_NUMBER_ROW_REPUT'			=> 'Число рядків у топ листі для рейтингу',
	'THANKS_NUMBER_ROW_REPUT_EXPLAIN'	=> 'Вкажіть число рядків для виведення топ листа рейтингу повідомлень, тем і форумів.',
	'THANKS_NUMBER_POST'				=> 'Число подяк в списку в повідомленні',
	'THANKS_NUMBER_POST_EXPLAIN'		=> 'Максимальне число подяк, що відображається у списку в пості.<br /><strongУвага! Встановлення значення більш 250 може уповільнити роботу конференції.</strong>',
	'THANKS_ONLY_FIRST_POST'			=> 'Подяка тільки за перше повідомлення в темі',
	'THANKS_ONLY_FIRST_POST_EXPLAIN'	=> 'Якщо включено, користувач може оголосити подяку тільки за перше повідомлення в темі.',
	'THANKS_POST_REPUT_VIEW'			=> 'Відображення рейтингу для повідомлень',
	'THANKS_POST_REPUT_VIEW_EXPLAIN'	=> 'Якщо включено, при перегляді тем буде відображено значення рейтингу для повідомлень.',
	'THANKS_POSTLIST_VIEW'				=> 'Список подяк у повідомленні',
	'THANKS_POSTLIST_VIEW_EXPLAIN'		=> 'Якщо включено, в повідомленні буде відображатися список користувачів, подякував авторам за повідомлення.<br />Врахуйте, що дана опція буде ефективна, якщо у форумі дозволено право дякувати за повідомлення.',
	'THANKS_PROFILELIST_VIEW'			=> 'Списки подяк в профілі',
	'THANKS_PROFILELIST_VIEW_EXPLAIN'	=> 'Якщо включено, при перегляді профілю користувача будуть відображатися списки виданих та отриманих подяк.',
	'THANKS_REFRESH'					=> 'Оновлення лічильників подяк',
	'THANKS_REFRESH_EXPLAIN'			=> 'Оновлення лічильників подяк після масового видалення постів/тем /користувачів, об\'єднання/поділу тим, установки/зняття для теми опції важлива, включення/вимикання опції "Подяка тільки за перше повідомлення в темі", заміни автора поста і т.п. <br /><strong>Важливо: Для коректної роботи функції оновлення лічильників потрібно MySQL версії 4.1 або вище! <br /> Увага! <br /> - При оновленні будуть видалені всі подяки в гостьових постах! <br /> - При оновленні будуть видалені всі подяки у важливих темах , якщо опція `Подяки у важливих темах` відключена! <br /> - При оновленні будуть видалені всі подяки з усіх постів, крім перших в темах, якщо опція `Подяка тільки за перше повідомлення в темі` включена!</strong>',
	'THANKS_REFRESH_MSG'				=> 'Виконання оновлення може зайняти деякий час. Всі некоректні записи подяк будуть видалені! <br /> Дію не можна буде повернути назад!',
	'THANKS_REFRESHED_MSG'				=> 'Лічильники подяк оновлені',
	'THANKS_REPUT_GRAPHIC'				=> 'Графічне відображення рейтингу',
	'THANKS_REPUT_GRAPHIC_EXPLAIN'		=> 'Якщо включено, значення рейтингу буде відображатися графічно за допомогою зображень, зазначених нижче.',
	'THANKS_REPUT_HEIGHT'				=> 'Висота графіки',
	'THANKS_REPUT_HEIGHT_EXPLAIN'		=> 'Вкажіть висоту графічної шкали для рейтингу в пікселах.<br /> <strong>Увага! Для коректного відображення необхідно вказувати висоту, рівну висоті зазначених нижче зображень!</strong>',
	'THANKS_REPUT_IMAGE'				=> 'Основне зображення для графічної шкали',
	'THANKS_REPUT_IMAGE_DEFAULT'		=> '<strong>Приклади графічних зображень</strong>',
	'THANKS_REPUT_IMAGE_DEFAULT_EXPLAIN' => 'Тут ви можете бачити саме зображення і шлях до файлу зображення. Розміри зображень 15х15 пікселів. <br />Ви можете намалювати власні зображення - основне і фонове. <strong>Висота і ширина зображення повинні бути однаковими для коректної побудови графічної шкали.</strong>',
	'THANKS_REPUT_IMAGE_EXPLAIN'		=> 'Шлях щодо кореневої папки phpBB до основного зображення, вибраного для графічної шкали.',
	'THANKS_REPUT_IMAGE_NOEXIST'		=> 'Файл основного зображення для графічної шкали відсутня',
	'THANKS_REPUT_IMAGE_BACK'			=> 'Фонове зображення для графічної шкали',
	'THANKS_REPUT_IMAGE_BACK_EXPLAIN'	=> 'Шлях щодо кореневої папки phpBB до фонового зображення, вибраного для графічної шкали.',
	'THANKS_REPUT_IMAGE_BACK_NOEXIST'	=> 'Файл фонового зображення для графічної шкали відсутня',
	'THANKS_REPUT_LEVEL'				=> 'Кількість зображень в графічній шкалою',
	'THANKS_REPUT_LEVEL_EXPLAIN'		=> 'Максимальне число зображень, що відповідає 100% значенню рейтингу в графічній шкалою.',
	'THANKS_TIME_VIEW'					=> 'Час подяки',
	'THANKS_TIME_VIEW_EXPLAIN'			=> 'Якщо включено, в повідомленні буде відображатися час подяки.',
	'THANKS_TOP_NUMBER'					=> 'Число користувачів в топ листі',
	'THANKS_TOP_NUMBER_EXPLAIN'			=> 'Вкажіть число користувачів для виведення в топ-листі на головній сторінці. 0 - відключає висновок топ листа.',
	'THANKS_TOPIC_REPUT_VIEW'			=> 'Рейтинг для тем',
	'THANKS_TOPIC_REPUT_VIEW_EXPLAIN'	=> 'Якщо включено, у списку тем буде відображатися рейтинг для тем.',
	'TRUNCATE'							=> 'Очистити',
	'TRUNCATE_THANKS'					=> 'Повне очищення списку подяк',
	'TRUNCATE_THANKS_EXPLAIN'			=> 'Дана процедура повністю очищає всі лічильники подяк (видаляє всі видані подяки).<br /> Дію не можна буде повернути!',
	'TRUNCATE_THANKS_MSG'				=> 'Лічильники подяк очищені.',
	'REFRESH_THANKS_CONFIRM'			=> 'Ви дійсно хочете оновити лічильники подяк?',
	'TRUNCATE_THANKS_CONFIRM'			=> 'Ви дійсно хочете очистити лічильники подяк?',
	'TRUNCATE_NO_THANKS'				=> 'Дія скасована',
	'ALLOW_THANKS_PM_ON'				=> 'Отримувати повідомлення про подяках в ПП',
	'ALLOW_THANKS_EMAIL_ON'				=> 'Отримувати повідомлення про подяках на Email',
]);
