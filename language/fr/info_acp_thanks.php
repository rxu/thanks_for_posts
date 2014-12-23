<?php
/**
*
* Thanks For Posts extension for the phpBB Forum Software package.
*
* @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
* French translation by Galixte (http://www.galixte.com)
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

$lang = array_merge($lang, array(
	'ACP_DELTHANKS'						=> 'Remerciements enregistrés supprimés ',
	'ACP_POSTS'							=> 'Nombre de messages ',
	'ACP_POSTSEND'						=> 'Messages remerciés restants ',
	'ACP_POSTSTHANKS'					=> 'Nombre de messages remerciés ',
	'ACP_THANKS'						=> 'Remerciements des messages',
	'ACP_THANKS_MOD_VER'				=> 'Version de l’extension : ',
	'ACP_THANKS_TRUNCATE'				=> 'Vider la liste des remerciements',
	'ACP_ALLTHANKS'						=> 'Remerciements pris en compte ',
	'ACP_THANKSEND'						=> 'Remerciements restants pour être pris en compte :',
	'ACP_THANKS_REPUT'					=> 'Options de classement',
	'ACP_THANKS_REPUT_SETTINGS'			=> 'Options de classement',
	'ACP_THANKS_REPUT_SETTINGS_EXPLAIN'	=> 'Appliquez les paramètres par défaut du classement des messages, des sujets et des forums, basés sur le système des remerciements. <br /> L’objet (message, sujet, ou forum) qui a le plus grand nombre de remerciements obtient la note de 100%.',
	'ACP_THANKS_SETTINGS'				=> 'Paramètres des remerciements',
	'ACP_THANKS_SETTINGS_EXPLAIN'		=> 'Appliquez les paramètres par défaut des remerciements.',
	'ACP_THANKS_REFRESH'				=> 'Mise à jour des compteurs',
	'ACP_UPDATETHANKS'					=> 'Remerciements enregistrés mis à jour ',
	'ACP_USERSEND'						=> 'Utilisateurs restants qui ont remercié ',
	'ACP_USERSTHANKS'					=> 'Nombre d’utilisateurs ayant remercié ',

	'GRAPHIC_BLOCK_BACK'				=> 'ext/gfksx/ThanksForPosts/images/rating/reput_block_back.gif',
	'GRAPHIC_BLOCK_RED'					=> 'ext/gfksx/ThanksForPosts/images/rating/reput_block_red.gif',
	'GRAPHIC_DEFAULT'					=> 'Images',
	'GRAPHIC_OPTIONS'					=> 'Options graphiques',
	'GRAPHIC_STAR_BACK'					=> 'ext/gfksx/ThanksForPosts/images/rating/reput_star_back.gif',
	'GRAPHIC_STAR_BLUE'					=> 'ext/gfksx/ThanksForPosts/images/rating/reput_star_blue.gif',
	'GRAPHIC_STAR_GOLD'					=> 'ext/gfksx/ThanksForPosts/images/rating/reput_star_gold.gif',

	'IMG_THANKPOSTS'					=> 'Pour remercier le message',
	'IMG_REMOVETHANKS'					=> 'Annuler le remerciements',

	'LOG_CONFIG_THANKS'					=> 'Configuration mise à jour de l’extension Remerciements des messages',

	'REFRESH'							=> 'Rafraîchir',
	'REMOVE_THANKS'						=> 'Retirer les remerciements ',
	'REMOVE_THANKS_EXPLAIN'				=> 'Les utilisateurs peuvent retirer leurs remerciements si cette option est activée.',

	'STEPR'								=> ' - éxécuté, étape %s',

	'THANKS_COUNTERS_VIEW'				=> 'Compteur des remerciements ',
	'THANKS_COUNTERS_VIEW_EXPLAIN'		=> 'Si cette option est activée, l’information du bloc à propos de l’auteur indiquera le nombre de remerciements émis / reçus.',
	'THANKS_FORUM_REPUT_VIEW'			=> 'Afficher le classement des forums ',
	'THANKS_FORUM_REPUT_VIEW_COLUMN'	=> 'Afficher le classement des forums dans une colonne ',
	'THANKS_FORUM_REPUT_VIEW_COLUMN_EXPLAIN' => 'Si cette option est activée, le classement des forums sera affiché dans une colonne dans la liste des forums. <br /> Note : cette option sera uniquement effective pour le style prosilver et si l’option ci-dessus est activée.',
	'THANKS_GLOBAL_POST'				=> 'Remerciements dans les annonces globales ',
	'THANKS_GLOBAL_POST_EXPLAIN'		=> 'Si cette option est activée, les remerciements dans les annonces globales seront possibles.',
	'THANKS_FORUM_REPUT_VIEW_EXPLAIN'	=> 'Si cette option est activée, le classement des forums sera affiché dans la liste des forums.',
	'THANKS_INFO_PAGE'					=> 'Les messages d’information(s) ',
	'THANKS_INFO_PAGE_EXPLAIN'			=> 'Si cette option est activée, les messages d’information(s) seront affichés après avoir ajouté / retiré un remerciement pour le message.',
	'THANKS_NOTICE_ON'					=> 'Avis disponibles',
	'THANKS_NOTICE_ON_EXPLAIN'			=> 'Si cette option est activée, les avis sont disponibles et l’utilisateur peut configurer la notification depuis son profil.',
	'THANKS_NUMBER'						=> 'Nombre de remerciements affiché depuis la liste affichée dans le profil ',
	'THANKS_NUMBER_EXPLAIN'				=> 'Nombre maximum de remerciements affiché lorsque l’on visualise un profil. <br /> <strong> Rappelez-vous, un ralentissement sera constaté si cette valeur est paramétrée sur 250. </strong>',
	'THANKS_NUMBER_DIGITS'				=> 'Nombre de décimales pour le classement ',
	'THANKS_NUMBER_DIGITS_EXPLAIN'		=> 'Spécifiez le nombre de décimales pour la valeur du classement.',
	'THANKS_NUMBER_ROW_REPUT'			=> 'Nombre de lignes dans le Top du classement ',
	'THANKS_NUMBER_ROW_REPUT_EXPLAIN'	=> 'Spécifiez le nombre de ligne à afficher dans les messages, les sujets et les forums de la liste du Top du classement.',
	'THANKS_NUMBER_POST'				=> 'Nombre de remerciements listés dans un message ',
	'THANKS_NUMBER_POST_EXPLAIN'		=> 'Nombre maximum de remerciements affiché lorsque l’on visualise un message. <br /> <strong> Rappelez-vous, un ralentissement sera constaté si cette valeur est paramétrée sur 250. </strong>',
	'THANKS_ONLY_FIRST_POST'			=> 'Uniquement pour le premier message du sujet ',
	'THANKS_ONLY_FIRST_POST_EXPLAIN'	=> 'Si cette option est activée, les utilisateurs peuvent remercier uniquement le premier message du sujet.',
	'THANKS_POST_REPUT_VIEW'			=> 'Afficher le classement des messages ',
	'THANKS_POST_REPUT_VIEW_EXPLAIN'	=> 'Si cette option est activée, le classement des messages sera affiché lorsque l’on visualise un sujet.',
	'THANKS_POSTLIST_VIEW'				=> 'Lister les remerciement dans un message ',
	'THANKS_POSTLIST_VIEW_EXPLAIN'		=> 'Si cette option est activée, une liste des utilisateurs qui ont remercié l’auteur du message sera affichée. <br/> Note : cette option sera uniquement effective si l’administrateur a activé les permissions de remercier dans ce forum.',
	'THANKS_PROFILELIST_VIEW'			=> 'Lister les remerciements dans le profil ',
	'THANKS_PROFILELIST_VIEW_EXPLAIN'	=> 'Si cette option est activée, une liste complète des remerciements sera affichée (incluant le nombre de remerciements et pour quel message l’utilisateur a été remercié).',
	'THANKS_REFRESH'					=> 'Mettre à jour les compteurs des remerciements',
	'THANKS_REFRESH_EXPLAIN'			=> 'Ici vous pouvez mettre à jour les compteurs des remerciements après avoir : exécuté un retrait de masse des messages / sujets / utilisateurs, divisé / fusionné des sujets, configuré / retiré des annonces globales, activé / désactivé l’option “Uniquement pour le premier message du sujet”, changé les propriétaires des messages etc ... Cela peut prendre un certain temps.<br /><strong>Important : Afin que la mise à jour des compteurs fonctionne correctement vous aurez besoin d’utiliser MySQL en version 4.1 ou plus récente !<br />Attention !<br /> - La mise à jour va écraser tous les remerciements des messages des invités !<br /> - La mise à jour va écraser tous les remerciements des annonces globales, si l’option “Remerciements dans les annonces globales” est désactivée !<br /> - La mise à jour va écraser tous les remerciements des messages des sujets exceptés les premiers messages des sujets, si l’option “Uniquement pour le premier message du sujet” est activée !</strong>',
	'THANKS_REFRESH_MSG'				=> 'Cela peut prendre quelques minutes. Tous les remerciements incorrects seront supprimés ! <br /> Cette action est irréversible !',
	'THANKS_REFRESHED_MSG'				=> 'Compteurs mis à jour',
	'THANKS_REPUT_GRAPHIC'				=> 'Affichage graphique du classement ',
	'THANKS_REPUT_GRAPHIC_EXPLAIN'		=> 'Si cette option est activée, la valeur du classement sera affichée graphiquement, en utilisant les images ci-dessous.',
	'THANKS_REPUT_HEIGHT'				=> 'Hauteur des graphiques ',
	'THANKS_REPUT_HEIGHT_EXPLAIN'		=> 'Spécifiez la hauteur du curseur pour le classement en pixels. <br /> <strong> Attention ! Pour afficher correctement, vous devez indiquer la hauteur égale à la hauteur de l’image suivante ! </strong>',
	'THANKS_REPUT_IMAGE'				=> 'Image principale pour le curseur ',
	'THANKS_REPUT_IMAGE_DEFAULT'		=> '<strong>Aperçu des graphiques </strong>',
	'THANKS_REPUT_IMAGE_DEFAULT_EXPLAIN' => 'L’image elle-même et le chemin de l’image peuvent être vu ici. La taille de l’image est de 15x15 pixels. <br /> Vous pouvez dessiner vos propres images pour le premier plan et l’arrière plan. Pour cela vous pouvez utiliser le fichier reput_star_.psd dans le dossier contrib. <strong>La hauteur et la largeur de l’image doivent être les mêmes pour assurer la construction correcte de l’échelle graphique.</strong>',
	'THANKS_REPUT_IMAGE_EXPLAIN'		=> 'Le chemin - par rapport au dossier racine de phpBB - pour l’image de l’échelle graphique.',
	'THANKS_REPUT_IMAGE_NOEXIST'		=> 'Image principale de l’échelle graphique introuvable.',
	'THANKS_REPUT_IMAGE_BACK'			=> 'Image d’arrière plan pour le curseur ',
	'THANKS_REPUT_IMAGE_BACK_EXPLAIN'	=> 'Le chemin - par rapport au dossier racine de phpBB - pour l’image d’arrière plan de l’échelle graphique.',
	'THANKS_REPUT_IMAGE_BACK_NOEXIST'	=> 'Image d’arrière plan de l’échelle graphique introuvable.',
	'THANKS_REPUT_LEVEL'				=> 'Nombre d’images dans l’échelle graphique ',
	'THANKS_REPUT_LEVEL_EXPLAIN'		=> 'Le nombre maximal d’images correspondant à 100% de la valeur de l’échelle du classement dans le graphique.',
	'THANKS_TIME_VIEW'					=> 'Heure du remerciement ',
	'THANKS_TIME_VIEW_EXPLAIN'			=> 'Si cette option est activée, le message affichera l’heure du remerciement.',
	'THANKS_TOP_NUMBER'					=> 'Nombre d’utilisateurs dans la liste du Top du classement ',
	'THANKS_TOP_NUMBER_EXPLAIN'			=> 'Spécifiez le nombre d’utilisateurs à afficher dans la liste du Top du classement sur l’index. 0 - désactive l’affichage du Top du classement.',
	'THANKS_TOPIC_REPUT_VIEW'			=> 'Afficher le classement des sujets ',
	'THANKS_TOPIC_REPUT_VIEW_COLUMN'	=> 'Afficher le classement des sujets dans une colonne ',
	'THANKS_TOPIC_REPUT_VIEW_COLUMN_EXPLAIN' => 'Si cette option est activée, le classement des sujets sera affiché dans une colonne lorsque l’on visualise un forum. <br /> Note : cette option sera uniquement effective pour le style prosilver et si l’option ci-dessus est activée.',
	'THANKS_TOPIC_REPUT_VIEW_EXPLAIN'	=> 'Si cette option est activée, le classement des sujets sera affiché lorsque l’on visualise un forum.',
	'TRUNCATE'							=> 'Effacer',
	'TRUNCATE_THANKS'					=> 'Effacer la liste des remerciements',
	'TRUNCATE_THANKS_EXPLAIN'			=> 'Cette action efface entièrement tous les compteurs de remerciements (retire tous les remerciements émis). <br /> Cette action est irréversible !',
	'TRUNCATE_THANKS_MSG'				=> 'Compteurs de remerciements effacés.',
	'REFRESH_THANKS_CONFIRM'			=> 'Voulez-vous vraiment mettre à jour les compteurs de remerciements ?',
	'TRUNCATE_THANKS_CONFIRM'			=> 'Voulez-vous vraiment effacer les compteurs de remerciements ?',
	'TRUNCATE_NO_THANKS'				=> 'Opération annulée',
	'ALLOW_THANKS_PM_ON'				=> 'Notifier moi par message privé si quelqu’un remercie mon message',
	'ALLOW_THANKS_EMAIL_ON'				=> 'Notifier moi par email si quelqu’un remercie mon message',
));
