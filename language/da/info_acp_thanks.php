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
* rudi_br:
* Translated into danish and the "Thanks" term, which is "Tak" in danish, changed into "syntes godt om" / "Like"
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
	'ACP_DELTHANKS'						=> 'Slettede gemte syntes godt om',
	'ACP_POSTS'							=> 'Totale indlæg',
	'ACP_POSTSEND'						=> 'Tilbageværende indlæg med syntes godt om',
	'ACP_POSTSTHANKS'					=> 'Total antal indlæg med syntes godt om',
	'ACP_THANKS'						=> 'Syntes godt om indlæg',
	'ACP_THANKS_MOD_VER'				=> 'Extension version: ',
	'ACP_THANKS_TRUNCATE'				=> 'Nulstil listen med syntes godt om',
	'ACP_ALLTHANKS'						=> 'Synten godt om der er taget hensyn til',
	'ACP_THANKSEND'						=> 'Tilbageværende antal syntes godt om der er taget hensyn til',
	'ACP_THANKS_REPUT'					=> 'Rangering Muligheder',
	'ACP_THANKS_REPUT_SETTINGS'			=> 'Rangering Muligheder',
	'ACP_THANKS_REPUT_SETTINGS_EXPLAIN'	=> 'Sæt standard indstillinger for rangering af indlæg, emner og fora, baseret på dette syntes godt om system. <br /> Emne (imdlæg, emne eller forum) med det højeste antal syntes godt om får 100% rangering.',
	'ACP_THANKS_SETTINGS'				=> 'Syntes godty om Indstillinger',
	'ACP_THANKS_SETTINGS_EXPLAIN'		=> 'Standard syntes godt om indlægs indstillinger kan ændres her.',
	'ACP_THANKS_REFRESH'				=> 'Opdater tællere',
	'ACP_UPDATETHANKS'					=> 'Opdater gemte syntes godt om',
	'ACP_USERSEND'						=> 'Tilbageværende brugere som syntes godt om',
	'ACP_USERSTHANKS'					=> 'Total antal brugere som syntes godt om',

	'GRAPHIC_BLOCK_BACK'				=> 'ext/gfksx/thanksforposts/images/rating/reput_block_back.gif',
	'GRAPHIC_BLOCK_RED'					=> 'ext/gfksx/thanksforposts/images/rating/reput_block_red.gif',
	'GRAPHIC_DEFAULT'					=> 'Billeder',
	'GRAPHIC_OPTIONS'					=> 'Billede Muligheder',
	'GRAPHIC_STAR_BACK'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_back.gif',
	'GRAPHIC_STAR_BLUE'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_blue.gif',
	'GRAPHIC_STAR_GOLD'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif',

	'IMG_THANKPOSTS'					=> 'Til syntes godt om indlægget',
	'IMG_REMOVETHANKS'					=> 'Annuller syntes godt om',

	'LOG_CONFIG_THANKS'					=> 'Opdaterede konfigurationen af syntes godt om udvidelsen',

	'REFRESH'							=> 'Opdater',
	'REMOVE_THANKS'						=> 'Fjern syntes godt om',
	'REMOVE_THANKS_EXPLAIN'				=> 'Brugere kan fjerne syntes godt om hvis denne option er slået til.',

	'STEPR'								=> ' - udført, skridt %s',

	'THANKS_COUNTERS_VIEW'				=> 'Syntes godt om tællere',
	'THANKS_COUNTERS_VIEW_EXPLAIN'		=> 'Hvis slået til, vil informations blokken for forfatteren vise antal udstedte/modtagne antal syntes godt om.',
	'THANKS_FORUM_REPUT_VIEW'			=> 'Vis forum syntes godt om',
	'THANKS_GLOBAL_POST'				=> 'Syntes godt om i Globale Meddelelser',
	'THANKS_GLOBAL_POST_EXPLAIN'		=> 'Hvis slået til, vil syntes godt om være slået til i Globale Meddelelser.',
	'THANKS_FORUM_REPUT_VIEW_EXPLAIN'	=> 'Hvis slået til, så vil forum rangering blive vist i forum listen.',
	'THANKS_INFO_PAGE'					=> 'Informations beskeder',
	'THANKS_INFO_PAGE_EXPLAIN'			=> 'Hvis slået til, så vil informations beskeder blive vist efter syntes godt om et indlæg er givet eller fjernet.',
	'THANKS_NOTICE_ON'					=> 'Notifikationer er tilgængelige',
	'THANKS_NOTICE_ON_EXPLAIN'			=> 'Hvis slået til, så er notifikationer tilgængelige og brugeren kan konfigurere notifikationen via din profil.',
	'THANKS_NUMBER'						=> 'Antal syntes godt om fra listen vist i profilen',
	'THANKS_NUMBER_EXPLAIN'				=> 'Maximum antal syntes godt om der vises når man ser en profil. <br /> <strong> Husk at det kan sløve forum ned hvis denne værdi sættes til mere end 250. </strong>',
	'THANKS_NUMBER_DIGITS'				=> 'Antal decimaler i rangeringen',
	'THANKS_NUMBER_DIGITS_EXPLAIN'		=> 'Angiv antal decimaler til rangerings værdien.',
	'THANKS_NUMBER_ROW_REPUT'			=> 'Antal rækker i rangering topscope listen',
	'THANKS_NUMBER_ROW_REPUT_EXPLAIN'	=> 'Angiv antal rækker der skal vises i indlæg, emner og fora rangerings topscore liste.',
	'THANKS_NUMBER_POST'				=> 'Antal syntes godt om der vises i et indlæg',
	'THANKS_NUMBER_POST_EXPLAIN'		=> 'Maximum antal syntes godt om der vises når man læser et indlæg. <br /> <strong> Husk at det kan sløve forum ned hvis denne værdi sættes til mere end 250. </strong>',
	'THANKS_ONLY_FIRST_POST'			=> 'Kun for det første indlæg i et emne',
	'THANKS_ONLY_FIRST_POST_EXPLAIN'	=> 'Hvis slået til, så kan brugere kun syntes godt om det første indlæg i et emne.',
	'THANKS_POST_REPUT_VIEW'			=> 'Vis rangering for indlæg',
	'THANKS_POST_REPUT_VIEW_EXPLAIN'	=> 'Hvis slået til, vises indlægs rangering når de vises i et emne.',
	'THANKS_POSTLIST_VIEW'				=> 'Vis syntes godt om i indlæg',
	'THANKS_POSTLIST_VIEW_EXPLAIN'		=> 'Hvis slået til, vises en liste af brugere der har syntes godt om forfatteren af indlæget. <br/> Bemærk at denne mulighed vil kun gælde hvis administratoren har slået rettigheder til at syntes godt om  for indlæg i det forum.',
	'THANKS_PROFILELIST_VIEW'			=> 'Vis syntes godt om i profiler',
	'THANKS_PROFILELIST_VIEW_EXPLAIN'	=> 'Hvis slået til, så vises en komplet liste af syntes godt om inclusiv antal syntes godt om og hvilke indlæg en bruger har fået syntes godt om fra.',
	'THANKS_REFRESH'					=> 'Opdater syntes godt om tællere',
	'THANKS_REFRESH_EXPLAIN'			=> 'Herkan du opdatere syntes godt om tællere efter en bulk fjernelse af indlæg/emner/brugere, opdeling/sammenlægning af emner, opslag af eller fjernelse af globale meddelelser, slå muligheden til/fra for ’Kun det første indlæg i emnet’, ændre indlæg osv. Dette kan tage noget tid.<br /><strong>Vigtigt: For at det skal virke korrekt, så skal opdater tæller funktionen anvende MySQL version 4.1 eller senere!<br />Bemærk!<br /> - Opdatering vil slette alle syntes godt om for gæste indlæg!<br /> - Opdatering vil slette alle syntes godt om for globale meddelelser, hvis muligheden ’Syntes godt om i globale meddelelser’ er OFF!<br /> - Opdatering vil slette alle syntes godt om for alle indlæg undtagen det første indlæg i et emne, hvis muligheden ’Kun for det første indlæg i et emne’ er ON!</strong>',
	'THANKS_REFRESH_MSG'				=> 'Dette kan tage et par minutter at fuldføre. Alle inkorrekte poster vil blive slettet! <br /> Handlingen kan ikke fortrydes!',
	'THANKS_REFRESHED_MSG'				=> 'Tøllere opdateret',
	'THANKS_REPUT_GRAPHIC'				=> 'Grafisk visning af rangeringen',
	'THANKS_REPUT_GRAPHIC_EXPLAIN'		=> 'Hvis slået til, så vil rangerings værdien vises grafisk ved anvendelse af billederne nedenfor.',
	'THANKS_REPUT_HEIGHT'				=> 'Grafik højde',
	'THANKS_REPUT_HEIGHT_EXPLAIN'		=> 'Angiv højden af skyderen til rangeringen i pixels. <br /> <strong> Bemærk! For at kunne vises korrekt, skal du angive højden til det samme som højden af det efterfølgende billede! </strong>',
	'THANKS_REPUT_IMAGE'				=> 'Hoved billedet for skyderen',
	'THANKS_REPUT_IMAGE_DEFAULT'		=> '<strong>Grafisk forhåndsvisning</strong>',
	'THANKS_REPUT_IMAGE_DEFAULT_EXPLAIN' => 'Selve billedet og stien til vissedet vises her. Billede størrelsen er 15x15 pixels. <br /> Du kan tegne dine egne billeder til forgrunden og baggrunden. <strong>Højden og bredden for billederne skal være ens for at sikre en korrekt skalering af grafikken.</strong>',
	'THANKS_REPUT_IMAGE_EXPLAIN'		=> 'Stien - relativ til phpBB rod folder - til grafik skala billedet.',
	'THANKS_REPUT_IMAGE_NOEXIST'		=> 'Hoved billedet til den grafiske skala findes ikke.',
	'THANKS_REPUT_IMAGE_BACK'			=> 'Baggrunds billedet til den grafiske skyder',
	'THANKS_REPUT_IMAGE_BACK_EXPLAIN'	=> 'Stien - relativ til phpBB installations folder - til den grafiske skala baggrunds billede.',
	'THANKS_REPUT_IMAGE_BACK_NOEXIST'	=> 'Baggrunds billedet til den grafiske skala findes ikke.',
	'THANKS_REPUT_LEVEL'				=> 'Antal billeder i den grafiske skala',
	'THANKS_REPUT_LEVEL_EXPLAIN'		=> 'Max antal billeder svarer til 100% af værdien af rangerings skalaen i grafikken.',
	'THANKS_TIME_VIEW'					=> 'Syntes godt om tid',
	'THANKS_TIME_VIEW_EXPLAIN'			=> 'Hvis slået til, vil indlæg vise tiden for syntes godt om.',
	'THANKS_TOP_NUMBER'					=> 'Antal brugere i top listen',
	'THANKS_TOP_NUMBER_EXPLAIN'			=> 'Angiv antal brugere der skal vises i indexets topliste. 0 - off displaying toplist.',
	'THANKS_TOPIC_REPUT_VIEW'			=> 'Vis emne rangering',
	'THANKS_TOPIC_REPUT_VIEW_EXPLAIN'	=> 'Hvis slået til, så bliver rangering vist når man kikker i et forum.',
	'TRUNCATE'							=> 'Nulstil',
	'TRUNCATE_THANKS'					=> 'Nulstil syntes godt om listen',
	'TRUNCATE_THANKS_EXPLAIN'			=> 'Denne procedure nulstiller alle syntes godt om tællere fuldstændigt (fjerner alle udstedte syntes godt om). <br /> Handlingen kan ikke fortrydes!',
	'TRUNCATE_THANKS_MSG'				=> 'Syntes godt om tællere nulstillet.',
	'REFRESH_THANKS_CONFIRM'			=> 'Vil du virkelig opdatere syntes godt om tællere?',
	'TRUNCATE_THANKS_CONFIRM'			=> 'Vil du virkelig nulstille syntes godt om tællere?',
	'TRUNCATE_NO_THANKS'				=> 'Operationen afbrudt',
	'ALLOW_THANKS_PM_ON'				=> 'Notificer mig med et PM hvis noget syntes godt om mit indlæg',
	'ALLOW_THANKS_EMAIL_ON'				=> 'Notificer mig med en e-mail hvis noget syntes godt om mit indlæg',
]);
