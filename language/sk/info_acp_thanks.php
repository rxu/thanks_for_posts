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
	'ACP_DELTHANKS'						=> 'Vymazané zaznamenané poďakovania',
	'ACP_POSTS'							=> 'Celkom príspevkov',
	'ACP_POSTSEND'						=> 'Zostávajúce príspevky s poďakovaním',
	'ACP_POSTSTHANKS'					=> 'Celkom príspevkov s poďakovaním',
	'ACP_THANKS'						=> 'Poďakovania za príspevky',
	'ACP_THANKS_MOD_VER'				=> 'Verzia rozšírenia',
	'ACP_THANKS_TRUNCATE'				=> 'Vymazať zoznam poďakovaní',
	'ACP_ALLTHANKS'						=> 'Poďakovania zobraté v úvahu',
	'ACP_THANKSEND'						=> 'Poďakovania, ktoré zostávajú zobrať v úvahu',
	'ACP_THANKS_REPUT'					=> 'Voľby hodnotenia',
	'ACP_THANKS_REPUT_SETTINGS'			=> 'Voľby hodnotenia',
	'ACP_THANKS_REPUT_SETTINGS_EXPLAIN'	=> 'Tu môžete nastaviť predvolené nastavenia pre hodnotenia príspevkov, tém a fór na základe systému poďakovania.<br /> Predmet (príspevok, téma aleboo fórum) s najväčším celkovým počtom poďakovaní bude mať 100 % hodnotenie.',
	'ACP_THANKS_SETTINGS'				=> 'Nastavenie poďakovaní',
	'ACP_THANKS_SETTINGS_EXPLAIN'		=> 'Predvolené nastavenia poďakovaní za príspevky môžu byť zmenené tu.',
	'ACP_THANKS_REFRESH'				=> 'Aktualizovať počítadlá',
	'ACP_UPDATETHANKS'					=> 'Aktualizované zaznamenané poďakovania',
	'ACP_USERSEND'						=> 'Zostávajuci užívatelia, ktorí poďakovali',
	'ACP_USERSTHANKS'					=> 'Celkom užívateľov, ktoří poďakovali',

	'GRAPHIC_BLOCK_BACK'				=> 'ext/gfksx/thanksforposts/images/rating/reput_block_back.gif',
	'GRAPHIC_BLOCK_RED'					=> 'ext/gfksx/thanksforposts/images/rating/reput_block_red.gif',
	'GRAPHIC_DEFAULT'					=> 'Obrázky',
	'GRAPHIC_OPTIONS'					=> 'Voľby grafiky',
	'GRAPHIC_STAR_BACK'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_back.gif',
	'GRAPHIC_STAR_BLUE'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_blue.gif',
	'GRAPHIC_STAR_GOLD'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif',

	'IMG_THANKPOSTS'					=> 'Poďakovanie za príspevok',
	'IMG_REMOVETHANKS'					=> 'Zrušenie poďakovania',

	'LOG_CONFIG_THANKS'					=> 'Aktualizovaná konfigurácia rozšírenia "Ďakujeme za príspevok"',

	'REFRESH'							=> 'Obnoviť',
	'REMOVE_THANKS'						=> 'Odobrať poďakovanie',
	'REMOVE_THANKS_EXPLAIN'				=> 'Pokiaľ je táto možnosť povolená, užívatelia môžu odobrať poďakovanie.',

	'STEPR'								=> ' - spustené, krok %s',

	'THANKS_COUNTERS_VIEW'				=> 'Počítadlá poďakovaní',
	'THANKS_COUNTERS_VIEW_EXPLAIN'		=> 'Pokiaľ je táto možnosť povolená, bude sa u autora zobrazovať blok informácií s vydanými a obdržanými poďakovaniami.',
	'THANKS_FORUM_REPUT_VIEW'			=> 'Zobraziť hodnotenia fór',
	'THANKS_GLOBAL_POST'				=> 'Poďakovania v globálnych oznámeniach',
	'THANKS_GLOBAL_POST_EXPLAIN'		=> 'Povolí poďakovania v globálnych oznámeniach',
	'THANKS_FORUM_REPUT_VIEW_EXPLAIN'	=> 'Pokiaľ je táto voľba povolená, v zozname fór se bude zobrazovať hodnotenie fór.',
	'THANKS_INFO_PAGE'					=> 'Informatívne správy',
	'THANKS_INFO_PAGE_EXPLAIN'			=> 'Pokiaľ je táto možnosť povolená, po udelení /odobratí poďakovania sa zobrazí informatívna správa.',
	'THANKS_NOTICE_ON'					=> 'Upozornenia sú dostupné',
	'THANKS_NOTICE_ON_EXPLAIN'			=> 'Pokiaľ je táto možnosť povolená, upozornenia sú dostupné a užívateľ ich môže konfigurovať cez svoj profil.',
	'THANKS_NUMBER'						=> 'Počet poďakovaní zo zoznamu zobrazených v profile',
	'THANKS_NUMBER_EXPLAIN'				=> 'Maximálny počet poďakovaní zobrazený pri prezeraní profilu. <br/> <strong> Pamätajte, že nastavenie hodnoty nad 250 bude znamenať spomalenie. </strong>',
	'THANKS_NUMBER_DIGITS'				=> 'Počet desatinných miest pre hodnotenia',
	'THANKS_NUMBER_DIGITS_EXPLAIN'		=> 'Uveďte počet desatinných miest pre hodnotu hodnotení.',
	'THANKS_NUMBER_ROW_REPUT'			=> 'Počet riadkov hodnotení v topliste',
	'THANKS_NUMBER_ROW_REPUT_EXPLAIN'	=> 'Uveďte počet riadkov v zobrazení v topliste príspevkov, tém a fór.',
	'THANKS_NUMBER_POST'				=> 'Počet poďakovaní zobrazený v príspevku',
	'THANKS_NUMBER_POST_EXPLAIN'		=> 'Maximálny počet poďakovaní zobrazených pri prezeraní príspevku. <br/> <strong> Pamätajte, že nastavenie hodnoty nad 250 bude znamenať spomalenie. </strong>',
	'THANKS_ONLY_FIRST_POST'			=> 'Poďakovať iba za prvný príspevok v téme',
	'THANKS_ONLY_FIRST_POST_EXPLAIN'	=> 'Pokiaľ je táto možnosť povolená, užívatelia môžu poďakovať iba za prvý príspevok v téme.',
	'THANKS_POST_REPUT_VIEW'			=> 'Ukazovať hodnotenie príspevku',
	'THANKS_POST_REPUT_VIEW_EXPLAIN'	=> 'Pokiaľ je táto možnosť povolená, pri zobrazovaní témy bude zobrazené hodnotenie príspevku.',
	'THANKS_POSTLIST_VIEW'				=> 'Zobraziť poďakovania v príspevku',
	'THANKS_POSTLIST_VIEW_EXPLAIN'		=> 'Pokiaľ je táto možnosť povolená, bude zobrazený zoznam užívateľov, ktorí poďakovali autorovi za zobrazený príspevok. <br/>Táto voľba bude mať vplyv iba keď administrátor povolil oprávnenia k udeleniu poďakovaní za príspevok v danom fóre.',
	'THANKS_PROFILELIST_VIEW'			=> 'Zobraziť poďakovania v profile',
	'THANKS_PROFILELIST_VIEW_EXPLAIN'	=> 'Pokiaľ je táto možnosť povolená, bude zobrazený úplný zoznam poďakovaní vrátane počtu poďakovaní a za ktoré prispevky bolo uživateľovi paďakované.',
	'THANKS_REFRESH'					=> 'Obnoviť počítadlá poďakovaní',
	'THANKS_REFRESH_EXPLAIN'			=> 'Tu môžete aktualizovať počítadlá poďakovaní po hromadnom odstránení príspevkov / tém / užívateľov, rozdelení / spojení tém, nastavení / odstránení globálneho oznámenia, povolenie / zakázanie voľby "Iba prvý príspevok v téme", zmene vlastníkov príspevku a podobne. Toto môže nejaký čas trvať.<br/><strong>Dôležité : Aby funkcia obnovenia počítadiel fungovala správne, je potrebné mať verziue MySQL 4.1 alebo vyššiu!<br/>Upozornenie !<br/> - Obnovenie vymaže všetky poďakovania príspevkov od hostí !<br /> - Obnovenie vymaže všetky poďakovania v globálnych oznámeniach ak je voľba `Poďakovania v globálnych oznámeniach` vypnutá !<br/> - Obnovenie odstráni všetky poďakovania s výnimkou poďakovania za prvý príspevok ak je zapnutá volba `Poďakovať iba za prvý príspevok v téme`!</strong>',
	'THANKS_REFRESH_MSG'				=> 'Toto môže trvať niekoľko minút. Všetky nesprávne poďakovania budu vymazané <br/> Akcie je nenávratné !',
	'THANKS_REFRESHED_MSG'				=> 'Počítadlá aktualizované',
	'THANKS_REPUT_GRAPHIC'				=> 'Grafické zobrazenie hodnotení',
	'THANKS_REPUT_GRAPHIC_EXPLAIN'		=> 'Pokiaľ je táto možnosť povolená, hodnotenie bude zobrazené graficky s použitím obrázkov nižšie.',
	'THANKS_REPUT_HEIGHT'				=> 'Výška stupnice',
	'THANKS_REPUT_HEIGHT_EXPLAIN'		=> 'Uveďte výšku stupnice v pixeloch.<br/><strong>Pozor ! Aby sa stupnica v grafike zobrazovala správne, mali by ste uviesť uvést výšku zhodnú s výškou následujúceho obrázku ! </strong>',
	'THANKS_REPUT_IMAGE'				=> 'Hlavný obrázok pre stupnicu',
	'THANKS_REPUT_IMAGE_DEFAULT'		=> '<strong>Náhľad grafiky</strong>',
	'THANKS_REPUT_IMAGE_DEFAULT_EXPLAIN' => 'Tu môžete vidieť samostatný obrázok a cestu k obrázku. Jeho veľkosť je 15 x 15 pixelox. <br/> Môžete si nakresliť vlastné obrázky pre popredia a pozadie. K tomu môžete využiť súbor "reput_star_.psd" v adresary "contrib". <strong>Výška a šírka obrázku by mala byť rovnaká pre zaistenie správnej konštrukcie stupnice v grafike.</strong>',
	'THANKS_REPUT_IMAGE_EXPLAIN'		=> 'Cesta (relatívna ku koreňovému adresářu phpBB) k obrázku na stupnici v grafike.',
	'THANKS_REPUT_IMAGE_NOEXIST'		=> 'Hlavný obrázok pre stupnicu nebol nájdený.',
	'THANKS_REPUT_IMAGE_BACK'			=> 'Obrázok na pozadie stupnice v grafike',
	'THANKS_REPUT_IMAGE_BACK_EXPLAIN'	=> 'Cesta (relatívna ku koreňovému adresářu phpBB) k obrázku na pozadie stupnice v grafike.',
	'THANKS_REPUT_IMAGE_BACK_NOEXIST'	=> 'Obrázok na pozadie stupnice nebol nájdený.',
	'THANKS_REPUT_LEVEL'				=> 'Počet obrázkov v stupnici',
	'THANKS_REPUT_LEVEL_EXPLAIN'		=> 'Maximálny počet obrázkov zodpovedajúci 100 % hodnoty hodnotiacej stupnice v grafike',
	'THANKS_TIME_VIEW'					=> 'Čas poďakovania',
	'THANKS_TIME_VIEW_EXPLAIN'			=> 'Pokiaľ je táto možnosť povolená, bude sa u poďakovania zobrazovať čas.',
	'THANKS_TOP_NUMBER'					=> 'Počet užívateľov v topliste',
	'THANKS_TOP_NUMBER_EXPLAIN'			=> 'Uveďte počet užívateľov, ktorí sa majú zobraziť v topliste. 0 - vypnúť zobrazenie topliste.',
	'THANKS_TOPIC_REPUT_VIEW'			=> 'Zobraziť hodnotenie tém',
	'THANKS_TOPIC_REPUT_VIEW_EXPLAIN'	=> 'Pokiaľ je táto možnosť povolená, bude sa pri zobrazení fóra zobrazovať hodnotenie tém.',
	'TRUNCATE'							=> 'Vymazať',
	'TRUNCATE_THANKS'					=> 'Vymazať zoznam poďakovaní',
	'TRUNCATE_THANKS_EXPLAIN'			=> 'Táto procedúra úplne vymaže všetky počítadlá poďakovaní (odstráni všetky udelené poďakovania). <br /> Akcia je nenávratná !',
	'TRUNCATE_THANKS_MSG'				=> 'Počítadlá poďakovaní boli vymazané.',
	'REFRESH_THANKS_CONFIRM'			=> 'Naozaj chcete obnoviť počítadlá poďakovaní ?',
	'TRUNCATE_THANKS_CONFIRM'			=> 'Naozaj chcete vymazať počítadlá poďakovaní ?',
	'TRUNCATE_NO_THANKS'				=> 'Operácia bola zrušená',
	'ALLOW_THANKS_PM_ON'				=> 'Oznámiť mi súkromnou správou, pokiaľ niekto poďakuje za môj príspevok',
	'ALLOW_THANKS_EMAIL_ON'				=> 'Oznámiť mi e-mailom, pokiaľ niekto poďakuje za môj príspevok',
]);
