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
	'ACP_DELTHANKS'						=> 'Obrisanih zapisa zahvala',
	'ACP_POSTS'							=> 'Ukupno postova',
	'ACP_POSTSEND'						=> 'Preostalo postova sa zahvalama',
	'ACP_POSTSTHANKS'					=> 'Ukupno postova sa zahvalama',
	'ACP_THANKS'						=> 'Zahvale na postovima',
	'ACP_THANKS_MOD_VER'				=> 'Verzija ekstenzije: ',
	'ACP_THANKS_TRUNCATE'				=> 'Brisanje liste zahvala',
	'ACP_ALLTHANKS'						=> 'Prihvaćenih zahvala na račun korisnika',
	'ACP_THANKSEND'						=> 'Preostale zahvale koje treba prihvatiti na račun',
	'ACP_THANKS_REPUT'					=> 'Opcije ocjena',
	'ACP_THANKS_REPUT_SETTINGS'			=> 'Opcije ocjena',
	'ACP_THANKS_REPUT_SETTINGS_EXPLAIN'	=> 'Podesi zadana podešenja za ocjene postova, tema i foruma baziranih na ovom sustavu zahvala. <br /> Predmet (post, tema ili forum) koja ima najveći ukupni broj zahvala dobiva ocjenu 100%.',
	'ACP_THANKS_SETTINGS'				=> 'Podešenja Zahvala',
	'ACP_THANKS_SETTINGS_EXPLAIN'		=> 'Zadana podešenja Zahvala na postovima mogu se ovdje izmijeniti.',
	'ACP_THANKS_REFRESH'				=> 'Ažuriraj brojače',
	'ACP_UPDATETHANKS'					=> 'Ažurirani zapisi zahvala',
	'ACP_USERSEND'						=> 'Preostali korisnici koji su zahvalili',
	'ACP_USERSTHANKS'					=> 'Ukupni korisnici koji su zahvalili',
	'GRAPHIC_BLOCK_BACK'				=> 'ext/gfksx/thanksforposts/images/rating/reput_block_back.gif',
	'GRAPHIC_BLOCK_RED'					=> 'ext/gfksx/thanksforposts/images/rating/reput_block_red.gif',
	'GRAPHIC_DEFAULT'					=> 'Slike',
	'GRAPHIC_OPTIONS'					=> 'Opcije grafike',
	'GRAPHIC_STAR_BACK'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_back.gif',
	'GRAPHIC_STAR_BLUE'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_blue.gif',
	'GRAPHIC_STAR_GOLD'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif',
	'IMG_THANKPOSTS'					=> 'Za zahvalu na postu',
	'IMG_REMOVETHANKS'					=> 'Poništi zahvale',
	'LOG_CONFIG_THANKS'					=> 'Ažurirana je konfiguracija ekstenzije Zahvale na postovima',
	'REFRESH'							=> 'Osvježi',
	'REMOVE_THANKS'						=> 'Ukloni zahvale',
	'REMOVE_THANKS_EXPLAIN'				=> 'Korisnici mogu uklanjati zahvale ako je ova opcija omogućena.',
	'STEPR'								=> ' - izvršeno, korak %s',
	'THANKS_COUNTERS_VIEW'				=> 'Brojači zahvala',
	'THANKS_COUNTERS_VIEW_EXPLAIN'		=> 'Ako je omogućeno, biti će prikazan blok s informacijama o autoru koji je izdao/primio zahvale.',
	'THANKS_FORUM_REPUT_VIEW'			=> 'Prikaži ocjene foruma',
	'THANKS_GLOBAL_POST'				=> 'Zahvale u globalnim obavijestima',
	'THANKS_GLOBAL_POST_EXPLAIN'		=> 'Ako je omogućena, biti će moguće zahvaliti u globalnim obavijestima.',
	'THANKS_FORUM_REPUT_VIEW_EXPLAIN'	=> 'Ako je omogućena, ocjene foruma biti će prikazane u listi foruma.',
	'THANKS_INFO_PAGE'					=> 'Informativne poruke',
	'THANKS_INFO_PAGE_EXPLAIN'			=> 'Ako je omogućeno, biti će prikazane informativne poruke nakon zahvale/uklanjanja zahvale na post.',
	'THANKS_NOTICE_ON'					=> 'Omogućene su obavijesti',
	'THANKS_NOTICE_ON_EXPLAIN'			=> 'Ako je omogućeno, omogućene su bilješke i korisnik može podesiti obavještavanja putem svog profila.',
	'THANKS_NUMBER'						=> 'Broj zahvala iz liste prikazanih u profilu.',
	'THANKS_NUMBER_EXPLAIN'				=> 'Maksimalni broj zahvala prikazanih pri pregledu profila. <br /> <strong> Biti će primjetnog usporavanja pregleda ako je ova vrijednost podešena na preko 250. </strong>',
	'THANKS_NUMBER_DIGITS'				=> 'Broj decimalnih mjesta u ocjenama.',
	'THANKS_NUMBER_DIGITS_EXPLAIN'		=> 'Odredi broj decimalnih mjesta pri prikazu vrijednosti ocjena.',
	'THANKS_NUMBER_ROW_REPUT'			=> 'Broj redaka u toplisti ocjena',
	'THANKS_NUMBER_ROW_REPUT_EXPLAIN'	=> 'Određuje broj redaka pri prikazu u topliste ocjena postova, tema i foruma.',
	'THANKS_NUMBER_POST'				=> 'Broj zahvala prikazanih u postu',
	'THANKS_NUMBER_POST_EXPLAIN'		=> 'Maksimalni broj zahvala prikazanih kod pregleda posta. <br /> <strong> Biti će primjetnog usporavanja pregleda ako je ova vrijednost podešena na preko 250. </strong>',
	'THANKS_ONLY_FIRST_POST'			=> 'Samo na prvom postu u temi',
	'THANKS_ONLY_FIRST_POST_EXPLAIN'	=> 'Ako je omogućeno, korisnik može zahvaliti samo prvom postu u temi.',
	'THANKS_POST_REPUT_VIEW'			=> 'Prikaži ocjene postova',
	'THANKS_POST_REPUT_VIEW_EXPLAIN'	=> 'Ako je omogućeno, ocjene postova biti će prikazane pri pregledu teme.',
	'THANKS_POSTLIST_VIEW'				=> 'Lista zahvala u postu',
	'THANKS_POSTLIST_VIEW_EXPLAIN'		=> 'Ako je omogućeno, biti će prikazana lista korisnika koji su zahvalili autoru posta. <br/> Ova opcija će biti u funkciji samo ako je administrator omogućio ovlasti za davanje zahvala u tom forumu.',
	'THANKS_PROFILELIST_VIEW'			=> 'Lista zahvala u profilu',
	'THANKS_PROFILELIST_VIEW_EXPLAIN'	=> 'Ako je omogućeno, biti će prikazana potpuna lista zahvala uključujući broj zahvala i koji su postovi i korisnici bili pohvaljeni.',
	'THANKS_REFRESH'					=> 'Ažuriraj brojače zahvala',
	'THANKS_REFRESH_EXPLAIN'			=> 'Ovdje možeš ažurirati brojače zahvala nakon masovnog uklanjanja postova/tema/korisnika, razdvajanja/spajanja tema, postavljanja/uklanjanja globalnih obavijesti, omogućavanja/onemogućavanja opcije "Samo na prvom postu u temi", promjene autora postova itd. Izvršavanje ovoga može potrajati neko vrijeme.<br /><strong>Važno: Kako bi se ispravno izvršilo, funkcija ažuriranja brojača treba mySQL 4.1 ili više!<br />Pažnja!<br /> - Ažuriranje će obrisati sve zahvale na postovima gostiju!<br /> - Ažuriranje će obrisati sve zahvale na globalnim obavijestima ako je opcija `Zahvale u globalnim obavijestima` postavljena na OFF!<br /> - Ažuriranje će obrisati sve zahvale na svim pozicijama osim u prvom postu teme ako je opcija `Samo u prvom postu u temi` podešena na ON!</strong>',
	'THANKS_REFRESH_MSG'				=> 'Izvršavanje će potrajati nekoliko minuta. Sve neispravne zahvale biti će obrisane! <br /> Ova akcija se ne može poništiti!',
	'THANKS_REFRESHED_MSG'				=> 'Brojači su ažurirani',
	'THANKS_REPUT_GRAPHIC'				=> 'Grafički prikaz ocjena',
	'THANKS_REPUT_GRAPHIC_EXPLAIN'		=> 'Ako je omogućeno, vrijednost ocjene biti će prikazana grafički, koristeći slike ispod.',
	'THANKS_REPUT_HEIGHT'				=> 'Visina grafike',
	'THANKS_REPUT_HEIGHT_EXPLAIN'		=> 'Određuje visinu klizača za ocjenjivanje u pixelima. <br /> <strong> Pažnja! Kako bi se ispravno prikazivalo, trebali bi postaviti visinu jednaku visini pripadajuće slike! </strong>',
	'THANKS_REPUT_IMAGE'				=> 'Glavna slika klizača',
	'THANKS_REPUT_IMAGE_DEFAULT'		=> '<strong>Grafički prikaz</strong>',
	'THANKS_REPUT_IMAGE_DEFAULT_EXPLAIN' => 'Sama slika i putanja do nje vidljiva je ovdje. Veličina slike je 15x15 pixela. <br /> Možeš nacrtati svoje vlastite slike za prednji i stražnji dio prikaza, možete koristiti datoteku reput_star-psd u mapi contrib u ovu svrhu. <strong>Visina i širina slike trebale bi biti iste kako bi se osigurao pravilan prikaz u mjerilu.</strong>',
	'THANKS_REPUT_IMAGE_EXPLAIN'		=> 'Putanja - relativna prema root mapi phpBB-a - prema slici grafičke skale.',
	'THANKS_REPUT_IMAGE_NOEXIST'		=> 'Glavna slika grafičke skale nije pronađena.',
	'THANKS_REPUT_IMAGE_BACK'			=> 'Stražnja slika klizača',
	'THANKS_REPUT_IMAGE_BACK_EXPLAIN'	=> 'Putanja - relativna prema root mapi phpBB-a - prema stražnjoj slici grafičke skale.',
	'THANKS_REPUT_IMAGE_BACK_NOEXIST'	=> 'Stražnja slika grafičke skale nije pronađena..',
	'THANKS_REPUT_LEVEL'				=> 'Broj slika u grafičkoj skali',
	'THANKS_REPUT_LEVEL_EXPLAIN'		=> 'Maksimalni broj slika koji odgovara 100%-noj vrijednosti ocjene u grafici.',
	'THANKS_TIME_VIEW'					=> 'Vrijeme zahvale',
	'THANKS_TIME_VIEW_EXPLAIN'			=> 'Ako je omogućeno, u postu će biti prikazano vrijeme zahvale.',
	'THANKS_TOP_NUMBER'					=> 'Broj korisnika u toplisti',
	'THANKS_TOP_NUMBER_EXPLAIN'			=> 'Određuje broj korisnika prikazanih u toplisti na indexnoj stranici. 0 - ne prikazuje toplistu.',
	'THANKS_TOPIC_REPUT_VIEW'			=> 'Prikaz ocjene teme',
	'THANKS_TOPIC_REPUT_VIEW_EXPLAIN'	=> 'Ako je omogućeno, ocjena teme biti će prikazana pri pregledu foruma.',
	'TRUNCATE'							=> 'Obriši',
	'TRUNCATE_THANKS'					=> 'Obriši listu zahvala',
	'TRUNCATE_THANKS_EXPLAIN'			=> 'Procedura potpuno briše sve brojače zahvala (uklanja sve dane zahvale). <br /> Ova akcija se ne može poništiti!',
	'TRUNCATE_THANKS_MSG'				=> 'Brojači zahvala su obrisani.',
	'REFRESH_THANKS_CONFIRM'			=> 'Da li zaista želiš ažurirati brojače zahvala?',
	'TRUNCATE_THANKS_CONFIRM'			=> 'Da li zaista želiš obrisati brojače zahvala?',
	'TRUNCATE_NO_THANKS'				=> 'Operacija poništena',
	'ALLOW_THANKS_PM_ON'				=> 'Obavijesti me u PP ako mi netko zahvali na postu',
	'ALLOW_THANKS_EMAIL_ON'				=> 'Obavijesti me na e-mail ako mi netko zahvali na postu',
]);
