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
	'ACP_DELTHANKS'						=> 'Vymazaná zaznamemaná poděkování',
	'ACP_POSTS'							=> 'Celkem příspěvků',
	'ACP_POSTSEND'						=> 'Zbývající příspěvky s poděkováními',
	'ACP_POSTSTHANKS'					=> 'Celkem příspěvků s poděkováními',
	'ACP_THANKS'						=> 'Poděkování za příspěvky',
	'ACP_THANKS_MOD_VER'				=> 'Verze rozšíření',
	'ACP_THANKS_TRUNCATE'				=> 'Vymazat seznam poděkování',
	'ACP_ALLTHANKS'						=> 'Poděkování vzatá v úvahu',
	'ACP_THANKSEND'						=> 'Poděkování, která zbývá vzít v úvahu',
	'ACP_THANKS_REPUT'					=> 'Volby hodnocení',
	'ACP_THANKS_REPUT_SETTINGS'			=> 'Volby hodnocení',
	'ACP_THANKS_REPUT_SETTINGS_EXPLAIN'	=> 'Zde můžete nastavit výchozí nastavení pro hodnocení příspěvků, témat a fór na základě systému poděkování.<br /> Předmět (příspěvek, téma nebo fórum) s největším počtem poděkování bude mít 100 % hodnocení.',
	'ACP_THANKS_SETTINGS'				=> 'Nastavení poděkování',
	'ACP_THANKS_SETTINGS_EXPLAIN'		=> 'Výchozí nastavení poděkování za příspěvky mohou být změněna zde.',
	'ACP_THANKS_REFRESH'				=> 'Aktualizovat počítadla',
	'ACP_UPDATETHANKS'					=> 'Aktualizována zaznamemaná poděkování',
	'ACP_USERSEND'						=> 'Zbývající uživatelé, kteří poděkovali',
	'ACP_USERSTHANKS'					=> 'Celkem uživatelů, kteří poděkovai',

	'GRAPHIC_BLOCK_BACK'				=> 'ext/gfksx/thanksforposts/images/rating/reput_block_back.gif',
	'GRAPHIC_BLOCK_RED'					=> 'ext/gfksx/thanksforposts/images/rating/reput_block_red.gif',
	'GRAPHIC_DEFAULT'					=> 'Obrázky',
	'GRAPHIC_OPTIONS'					=> 'Volby grafiky',
	'GRAPHIC_STAR_BACK'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_back.gif',
	'GRAPHIC_STAR_BLUE'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_blue.gif',
	'GRAPHIC_STAR_GOLD'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif',

	'IMG_THANKPOSTS'					=> 'Pro poděkování za příspěvek',
	'IMG_REMOVETHANKS'					=> 'Zrušení poděkování',

	'LOG_CONFIG_THANKS'					=> 'Aktualizována konfigurace rozšíření Thanks for post',

	'REFRESH'							=> 'Obnovit',
	'REMOVE_THANKS'						=> 'Odebrat poděkování',
	'REMOVE_THANKS_EXPLAIN'				=> 'Pokud je tato možnost povolena, uživatelé mohou odebrat poděkování.',

	'STEPR'								=> ' - spuštěno, krok %s',

	'THANKS_COUNTERS_VIEW'				=> 'Počítadla poděkování',
	'THANKS_COUNTERS_VIEW_EXPLAIN'		=> 'Pokud je povoleno, bude ze u autora zobrazovat blok informací s udělenými a obdrženými poděkováními.',
	'THANKS_FORUM_REPUT_VIEW'			=> 'Zobrazit hodnocení fór',
	'THANKS_GLOBAL_POST'				=> 'Poděkování v globálních oznámeních',
	'THANKS_GLOBAL_POST_EXPLAIN'		=> 'Povolí poděkování v globálních oznámeních.',
	'THANKS_FORUM_REPUT_VIEW_EXPLAIN'	=> 'Pokud je povoleno, v seznamu fór se bude zobrazovat hodnocení fór.',
	'THANKS_INFO_PAGE'					=> 'Informativní zprávy',
	'THANKS_INFO_PAGE_EXPLAIN'			=> 'Pokud je povoleno, po udělení/odebrání poděkování se zobrazí informativní zpráva.',
	'THANKS_NOTICE_ON'					=> 'Upozornění jsou dostupná',
	'THANKS_NOTICE_ON_EXPLAIN'			=> 'Pokud je povoleno, upozornění jsou dostupná a uživatel může konfigurovat upozornění přes svůj profil.',
	'THANKS_NUMBER'						=> 'Počet poděkování ze seznamu zobrazených v profilu',
	'THANKS_NUMBER_EXPLAIN'				=> 'Maximální počet poděkovaní zobrazený při prohlížení profilu. <br /> <strong> Pamatujte, že nastavení hodnoty přes 250 bude znamenat zpomalení. </strong>',
	'THANKS_NUMBER_DIGITS'				=> 'Počet desetinných míst pro hodnocení',
	'THANKS_NUMBER_DIGITS_EXPLAIN'		=> 'Uveďte počet desetinných míst pro hodnotu hodnocení.',
	'THANKS_NUMBER_ROW_REPUT'			=> 'Počet řádků hodnocení v toplistu',
	'THANKS_NUMBER_ROW_REPUT_EXPLAIN'	=> 'Uveďte počet řádku ke zobrazení v toplistu příspěvků, témat a fór.',
	'THANKS_NUMBER_POST'				=> 'Počet poděkování zobrazený v příspěvku',
	'THANKS_NUMBER_POST_EXPLAIN'		=> 'Maximální počet poděkování zobrazených při prohlížení příspěvku. <br /> <strong> Pamatujte, že nastavení hodnoty přes 250 bude znamenat zpomalení. </strong>',
	'THANKS_ONLY_FIRST_POST'			=> 'Děkovat pouze za první příspěvek v tématu',
	'THANKS_ONLY_FIRST_POST_EXPLAIN'	=> 'Pokud je povoleno, uživatelé mohou děkovat pouze za první příspěvek v tématu.',
	'THANKS_POST_REPUT_VIEW'			=> 'Ukazovat hodnocení příspěvků',
	'THANKS_POST_REPUT_VIEW_EXPLAIN'	=> 'Pokud je povoleno, při zobrazování tématu bude zobrazeno hodnocení příspěvků.',
	'THANKS_POSTLIST_VIEW'				=> 'Vypsat poděkování v příspěvku',
	'THANKS_POSTLIST_VIEW_EXPLAIN'		=> 'Pokud je povoleno, bude zobrazen seznam uživatelů, kteří poděkovali autorovi za zobrazený příspěvek. <br/>Tato volba bude mít vliv jen pokud administrátor povolil oprávnění k udělení poděkování za příspěvku v daném fóru.',
	'THANKS_PROFILELIST_VIEW'			=> 'Zobrazit poděkování v profilu',
	'THANKS_PROFILELIST_VIEW_EXPLAIN'	=> 'Pokud je povoleno, bude zobrazen úplný seznam poděkování včetně počtu poděkování a za které příspěvky bylo uživateli poděkováno.',
	'THANKS_REFRESH'					=> 'Obnovit počítadla poděkování',
	'THANKS_REFRESH_EXPLAIN'			=> 'Tady můžete aktualizovat počítadla poděkování po hromadném odstranění příspěvků/témat/uživatelů, rozdělení/spojení témat, nastavení/odstranění globálního oznámení, povolení/zakázání volby "Pouze první příspěvek v tématu", změně vlastníků příspěvků atd. Toto může nějaký čas trvat.<br /><strong>Důležité: Aby funkce obnovení počítadel fungovala správně, je třeba verze MySQL 4.1 nebo vyšší!<br />Upozornění!<br /> - Obnovení vymaže všechna poděkování příspěvkům od hostů!<br /> - Obnovení vymaže všechna poděkování v globálních oznámeních pokud je volba `Poděkování v globálních oznámeních` vypnuta!<br /> - Obnovení odstraní všechna poděkování s výjimou poděkování za první příspěvek pokud je zapnuta volba `Děkovat pouze za první příspěvek v tématu`!</strong>',
	'THANKS_REFRESH_MSG'				=> 'Toto může trvat několik minut. Všechna nesprávná poděkování budou vymazána! <br /> Akce je nevratná!',
	'THANKS_REFRESHED_MSG'				=> 'Počítadla aktualizována',
	'THANKS_REPUT_GRAPHIC'				=> 'Grafické zobrazení hodnocení',
	'THANKS_REPUT_GRAPHIC_EXPLAIN'		=> 'Pokud je povoleno, hodnocení bude zobrazeno graficky s použitím obrázků níže.',
	'THANKS_REPUT_HEIGHT'				=> 'Výška stupnice',
	'THANKS_REPUT_HEIGHT_EXPLAIN'		=> 'Uveďte výšku stupnici v pixelech.<br /><strong>Pozor! Aby se stupnice zobrazovala správně, měli byste uvést výšku shodnou s výškou následujícího obrázku! </strong>',
	'THANKS_REPUT_IMAGE'				=> 'Hlavní obrázek pro stupnici',
	'THANKS_REPUT_IMAGE_DEFAULT'		=> '<strong>Náhled grafiky</strong>',
	'THANKS_REPUT_IMAGE_DEFAULT_EXPLAIN' => 'Zde můžete vidět obrázek sám a cestu k obrázku. Jeho velikost je 15x15 pixelů. <br /> Můžete si nakreslit vlastní obrázky pro popředí a pozadí. K tomu můžete využíít soubor reput_star_.psd v adresáři contrib. <strong>Výška a šítka obrázku by měla být stejná pro zajištění správné konstrukce grafické stupnice.</strong>',
	'THANKS_REPUT_IMAGE_EXPLAIN'		=> 'Cesta (relativní ke kořenovému adresáři phpBB) k obrázku na grafické stupnici.',
	'THANKS_REPUT_IMAGE_NOEXIST'		=> 'Hlavní obrázek pro grafickou stupnici nebyl nalezen.',
	'THANKS_REPUT_IMAGE_BACK'			=> 'Obrázek na pozadí grafické stupnice',
	'THANKS_REPUT_IMAGE_BACK_EXPLAIN'	=> 'Cesta (relativní ke kořenovému adresáři phpBB) k obrázku na pozadí grafické stupnice.',
	'THANKS_REPUT_IMAGE_BACK_NOEXIST'	=> 'Obrázek na pozadí grafické stupnice nebyl nalezen.',
	'THANKS_REPUT_LEVEL'				=> 'Počet obrázků v grafické stupnici',
	'THANKS_REPUT_LEVEL_EXPLAIN'		=> 'Nejvyšší počet obrázků, který odpovídá 100 % hodnocení na grafické stupnici.',
	'THANKS_TIME_VIEW'					=> 'Čas poděkování',
	'THANKS_TIME_VIEW_EXPLAIN'			=> 'Pokud je povoleno, bude se u poděkování zobrazovat čas.',
	'THANKS_TOP_NUMBER'					=> 'Počet uživatelů v toplistu',
	'THANKS_TOP_NUMBER_EXPLAIN'			=> 'Uveďte počet uživatelů, kteří mají zobrazit v toplistu. 0 - vypnout zobrazení toplistu.',
	'THANKS_TOPIC_REPUT_VIEW'			=> 'Zobrazit hodnocení témat',
	'THANKS_TOPIC_REPUT_VIEW_EXPLAIN'	=> 'Pokud je povoleno, bude při zobrazení fóra zobrazeno hodnocení témat.',
	'TRUNCATE'							=> 'Vymazat',
	'TRUNCATE_THANKS'					=> 'Vymazat seznam poděkování',
	'TRUNCATE_THANKS_EXPLAIN'			=> 'Tato procedura úplně vymaže všechna počítadla poděkování (odstraní všechna udělená poděkování). <br /> Akce je nevratná!',
	'TRUNCATE_THANKS_MSG'				=> 'Počítadla poděkování vymazána.',
	'REFRESH_THANKS_CONFIRM'			=> 'Opravdu chcete obnovit počítadla poděkování?',
	'TRUNCATE_THANKS_CONFIRM'			=> 'Opravdu chcete vymazat počítadla poděkování?',
	'TRUNCATE_NO_THANKS'				=> 'Operace zrušena',
	'ALLOW_THANKS_PM_ON'				=> 'Oznámit mi soukromou zprávou, pokud někdo poděkuje za můj příspěvek',
	'ALLOW_THANKS_EMAIL_ON'				=> 'Oznámit mi e-mailem, pokud někdo poděkuje za můj příspěvek',
]);
