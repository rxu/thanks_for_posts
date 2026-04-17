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
	'ACP_DELTHANKS'						=> 'Usunięte zapisane podziękowania',
	'ACP_POSTS'							=> 'Łączna liczba postów',
	'ACP_POSTSEND'						=> 'Pozostałe posty z podziękowaniami',
	'ACP_POSTSTHANKS'					=> 'Łączna liczba postów z podziękowaniami',
	'ACP_THANKS'						=> 'Podziękowania za posty',
	'ACP_THANKS_MOD_VER'				=> 'Wersja rozszerzenia: ',
	'ACP_THANKS_TRUNCATE'				=> 'Wyczyść listę podziękowań',
	'ACP_ALLTHANKS'						=> 'Podziękowania uwzględnione',
	'ACP_THANKSEND'						=> 'Pozostałe podziękowania do uwzględnienia',
	'ACP_THANKS_REPUT'					=> 'Opcje oceny',
	'ACP_THANKS_REPUT_SETTINGS'			=> 'Opcje oceny',
	'ACP_THANKS_REPUT_SETTINGS_EXPLAIN'	=> 'Ustaw tutaj domyślne opcje oceny postów, tematów i forów, oparte na systemie podziękowań. <br /> Element (post, temat, forum) z największą łączną liczbą podziękowań otrzymuje ocenę 100%.',
	'ACP_THANKS_SETTINGS'				=> 'Ustawienia podziękowań',
	'ACP_THANKS_SETTINGS_EXPLAIN'		=> 'Tutaj możesz zmienić domyślne ustawienia dodatku Thanks for posts.',
	'ACP_THANKS_REFRESH'				=> 'Zaktualizuj liczniki',
	'ACP_UPDATETHANKS'					=> 'Zaktualizowane zapisane podziękowania',
	'ACP_USERSEND'						=> 'Pozostali użytkownicy, którzy dziękowali',
	'ACP_USERSTHANKS'					=> 'Łączna liczba użytkowników, którzy dziękowali',

	'GRAPHIC_BLOCK_BACK'				=> 'ext/gfksx/thanksforposts/images/rating/reput_block_back.gif',
	'GRAPHIC_BLOCK_RED'					=> 'ext/gfksx/thanksforposts/images/rating/reput_block_red.gif',
	'GRAPHIC_DEFAULT'					=> 'Obrazy',
	'GRAPHIC_OPTIONS'					=> 'Opcje grafiki',
	'GRAPHIC_STAR_BACK'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_back.gif',
	'GRAPHIC_STAR_BLUE'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_blue.gif',
	'GRAPHIC_STAR_GOLD'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif',

	'IMG_THANKPOSTS'					=> 'Podziękuj za post',
	'IMG_REMOVETHANKS'					=> 'Anuluj podziękowanie',

	'LOG_CONFIG_THANKS'					=> 'Zaktualizowano konfigurację rozszerzenia Thanks for post',

	'REFRESH'							=> 'Odśwież',
	'REMOVE_THANKS'						=> 'Usuń podziękowania',
	'REMOVE_THANKS_EXPLAIN'				=> 'Użytkownicy mogą usuwać swoje podziękowania, jeśli ta opcja jest włączona.',

	'STEPR'								=> ' - wykonano, krok %s',

	'THANKS_AJAX_ENABLE'				=> 'Włącz Ajax',
	'THANKS_AJAX_ENABLE_EXPLAIN'		=> 'Jeśli włączone, dodawanie i usuwanie podziękowań będzie odbywać się bez przeładowania strony.',
	'THANKS_COUNTERS_VIEW'				=> 'Liczniki podziękowań',
	'THANKS_COUNTERS_VIEW_EXPLAIN'		=> 'Jeśli włączone, blok informacji o autorze pokaże liczbę wysłanych i otrzymanych podziękowań.',
	'THANKS_FORUM_REPUT_VIEW'			=> 'Pokaż ocenę forów',
	'THANKS_GLOBAL_POST'				=> 'Podziękowania w ogłoszeniach globalnych',
	'THANKS_GLOBAL_POST_EXPLAIN'		=> 'Jeśli włączone, będzie można dziękować także w ogłoszeniach globalnych.',
	'THANKS_FORUM_REPUT_VIEW_EXPLAIN'	=> 'Jeśli włączone, ocena forów będzie wyświetlana na liście forów.',
	'THANKS_INFO_PAGE'					=> 'Komunikaty informacyjne',
	'THANKS_INFO_PAGE_EXPLAIN'			=> 'Jeśli włączone, po dodaniu lub usunięciu podziękowania będą wyświetlane komunikaty informacyjne.',
	'THANKS_NOTICE_ON'					=> 'Dostępne powiadomienia',
	'THANKS_NOTICE_ON_EXPLAIN'			=> 'Jeśli włączone, użytkownik może skonfigurować powiadomienia w swoim profilu.',
	'THANKS_NUMBER'						=> 'Liczba podziękowań widoczna w profilu',
	'THANKS_NUMBER_EXPLAIN'				=> 'Maksymalna liczba podziękowań wyświetlanych podczas przeglądania profilu. <br /> <strong> Pamiętaj, że przy wartości większej niż 250 może być zauważalne spowolnienie. </strong>',
	'THANKS_NUMBER_DIGITS'				=> 'Liczba miejsc po przecinku dla oceny',
	'THANKS_NUMBER_DIGITS_EXPLAIN'		=> 'Określ liczbę miejsc po przecinku dla wartości oceny.',
	'THANKS_NUMBER_ROW_REPUT'			=> 'Liczba wierszy w topliscie oceny',
	'THANKS_NUMBER_ROW_REPUT_EXPLAIN'	=> 'Określ liczbę wierszy wyświetlanych w topliscie oceny postów, tematów i forów.',
	'THANKS_NUMBER_POST'				=> 'Liczba podziękowań wyświetlana w poście',
	'THANKS_NUMBER_POST_EXPLAIN'		=> 'Maksymalna liczba podziękowań wyświetlanych podczas przeglądania posta. <br /> <strong> Pamiętaj, że przy wartości większej niż 250 może być zauważalne spowolnienie. </strong>',
	'THANKS_ONLY_FIRST_POST'			=> 'Tylko pierwszy post w temacie',
	'THANKS_ONLY_FIRST_POST_EXPLAIN'	=> 'Jeśli włączone, użytkownicy mogą dziękować tylko za pierwszy post w temacie.',
	'THANKS_POST_REPUT_VIEW'			=> 'Pokaż ocenę postów',
	'THANKS_POST_REPUT_VIEW_EXPLAIN'	=> 'Jeśli włączone, ocena postów będzie wyświetlana podczas przeglądania tematu.',
	'THANKS_POSTLIST_VIEW'				=> 'Lista podziękowań w poście',
	'THANKS_POSTLIST_VIEW_EXPLAIN'		=> 'Jeśli włączone, będzie wyświetlana lista użytkowników, którzy podziękowali autorowi za post. <br/> Pamiętaj, że ta opcja działa tylko wtedy, gdy administrator włączył uprawnienie do dziękowania za post w danym forum.',
	'THANKS_PROFILELIST_VIEW'			=> 'Lista podziękowań w profilu',
	'THANKS_PROFILELIST_VIEW_EXPLAIN'	=> 'Jeśli włączone, podczas przeglądania profilu będzie wyświetlana pełna lista podziękowań, łącznie z liczbą podziękowań i postami, za które użytkownik otrzymał podziękowania.',
	'THANKS_REFRESH'					=> 'Zaktualizuj liczniki podziękowań',
	'THANKS_REFRESH_EXPLAIN'			=> 'Tutaj możesz zaktualizować liczniki podziękowań po masowym usuwaniu postów, tematów lub użytkowników, dzieleniu lub scalaniu tematów, ustawianiu lub usuwaniu Ogłoszenia globalnego, włączaniu lub wyłączaniu opcji „Tylko pierwszy post w temacie”, zmianie właścicieli postów itp. Może to chwilę potrwać.<br /><strong>Ważne: aby działało poprawnie, funkcja odświeżania liczników wymaga MySQL w wersji 4.1 lub nowszej!<br />Uwaga!<br /> - Odświeżanie usunie wszystkie podziękowania za posty gości!<br /> - Odświeżanie usunie wszystkie podziękowania za Ogłoszenia globalne, jeśli opcja „Podziękowania w ogłoszeniach globalnych” jest wyłączona!<br /> - Odświeżanie usunie wszystkie podziękowania za wszystkie posty poza pierwszym postem w temacie, jeśli opcja „Tylko pierwszy post w temacie” jest włączona!</strong>',
	'THANKS_REFRESH_MSG'				=> 'To może potrwać kilka minut. Wszystkie nieprawidłowe wpisy podziękowań zostaną usunięte! <br /> Ta operacja jest nieodwracalna!',
	'THANKS_REFRESHED_MSG'				=> 'Liczniki zaktualizowane',
	'THANKS_REPUT_GRAPHIC'				=> 'Graficzne wyświetlanie oceny',
	'THANKS_REPUT_GRAPHIC_EXPLAIN'		=> 'Jeśli włączone, wartość oceny będzie wyświetlana graficznie za pomocą poniższych obrazów.',
	'THANKS_REPUT_HEIGHT'				=> 'Wysokość grafiki',
	'THANKS_REPUT_HEIGHT_EXPLAIN'		=> 'Określ wysokość suwaka oceny w pikselach. <br /> <strong> Uwaga! Aby wyświetlanie było poprawne, należy podać wysokość równą wysokości poniższego obrazu! </strong>',
	'THANKS_REPUT_IMAGE'				=> 'Główny obraz suwaka',
	'THANKS_REPUT_IMAGE_DEFAULT'		=> '<strong>Podgląd grafiki</strong>',
	'THANKS_REPUT_IMAGE_DEFAULT_EXPLAIN' => 'Tutaj można zobaczyć sam obraz i jego ścieżkę. Rozmiar obrazu to 15x15 pikseli. <br /> Możesz przygotować własne obrazy dla pierwszego planu i tła. <strong>Wysokość i szerokość obrazu powinny być takie same, aby zapewnić poprawne zbudowanie skali graficznej.</strong>',
	'THANKS_REPUT_IMAGE_EXPLAIN'		=> 'Ścieżka - względna wobec katalogu głównego phpBB - do obrazu skali graficznej.',
	'THANKS_REPUT_IMAGE_NOEXIST'		=> 'Nie znaleziono głównego obrazu skali graficznej.',
	'THANKS_REPUT_IMAGE_BACK'			=> 'Obraz tła suwaka',
	'THANKS_REPUT_IMAGE_BACK_EXPLAIN'	=> 'Ścieżka - względna wobec katalogu głównego instalacji phpBB - do obrazu tła skali graficznej.',
	'THANKS_REPUT_IMAGE_BACK_NOEXIST'	=> 'Nie znaleziono obrazu tła skali graficznej.',
	'THANKS_REPUT_LEVEL'				=> 'Liczba obrazów w skali graficznej',
	'THANKS_REPUT_LEVEL_EXPLAIN'		=> 'Maksymalna liczba obrazów odpowiadająca 100% wartości skali oceny w grafice.',
	'THANKS_TIME_VIEW'					=> 'Czas podziękowania',
	'THANKS_TIME_VIEW_EXPLAIN'			=> 'Jeśli włączone, przy poście będzie wyświetlany czas podziękowania.',
	'THANKS_TOP_NUMBER'					=> 'Liczba użytkowników na liście top',
	'THANKS_TOP_NUMBER_EXPLAIN'			=> 'Określ liczbę użytkowników wyświetlanych na topliscie na stronie głównej. 0 - wyłącza wyświetlanie toplisty.',
	'THANKS_TOPIC_REPUT_VIEW'			=> 'Pokaż ocenę tematów',
	'THANKS_TOPIC_REPUT_VIEW_EXPLAIN'	=> 'Jeśli włączone, ocena tematów będzie wyświetlana podczas przeglądania forum.',
	'TRUNCATE'							=> 'Wyczyść',
	'TRUNCATE_THANKS'					=> 'Wyczyść listę podziękowań',
	'TRUNCATE_THANKS_EXPLAIN'			=> 'Ta procedura całkowicie czyści liczniki podziękowań (usuwa wszystkie wystawione podziękowania). <br /> Ta operacja jest nieodwracalna!',
	'TRUNCATE_THANKS_MSG'				=> 'Liczniki podziękowań zostały wyczyszczone.',
	'REFRESH_THANKS_CONFIRM'			=> 'Czy na pewno chcesz odświeżyć liczniki podziękowań?',
	'TRUNCATE_THANKS_CONFIRM'			=> 'Czy na pewno chcesz wyczyścić liczniki podziękowań?',
	'TRUNCATE_NO_THANKS'				=> 'Operacja anulowana',
	'ALLOW_THANKS_PM_ON'				=> 'Powiadamiaj mnie przez PW, gdy ktoś podziękuje za mój post',
	'ALLOW_THANKS_EMAIL_ON'				=> 'Powiadamiaj mnie e-mailem, gdy ktoś podziękuje za mój post',
]);
