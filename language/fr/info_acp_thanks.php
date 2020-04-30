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
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'ACP_DELTHANKS'						=> 'Nombre de remerciements supprimés',
	'ACP_POSTS'							=> 'Nombre de messages',
	'ACP_POSTSEND'						=> 'Nombre de messages remerciés restants à prendre en compte',
	'ACP_POSTSTHANKS'					=> 'Nombre de messages remerciés',
	'ACP_THANKS'						=> 'Remerciements des messages',
	'ACP_THANKS_MOD_VER'				=> 'Version de l’extension',
	'ACP_THANKS_TRUNCATE'				=> 'Purge de la liste',
	'ACP_ALLTHANKS'						=> 'Nombre de remerciements pris en compte',
	'ACP_THANKSEND'						=> 'Nombre de remerciements restants à prendre en compte',
	'ACP_THANKS_REPUT'					=> 'Options du classement',
	'ACP_THANKS_REPUT_SETTINGS'			=> 'Options du classement',
	'ACP_THANKS_REPUT_SETTINGS_EXPLAIN'	=> 'Sur cette page il est possible de modifier les paramètres par défaut du classement des remerciements pour les messages, les sujets et les forums concernés par ce système.<br />Un message, un sujet, ou un forum ayant le plus grand nombre de remerciements obtient la note de 100%.',
	'ACP_THANKS_SETTINGS'				=> 'Paramètres',
	'ACP_THANKS_SETTINGS_EXPLAIN'		=> 'Sur cette page il est possible de modifier les paramètres par défaut des remerciements.',
	'ACP_THANKS_REFRESH'				=> 'Mise à jour des compteurs',
	'ACP_UPDATETHANKS'					=> 'Nombre de remerciements mis à jour',
	'ACP_USERSEND'						=> 'Nombre d’utilisateurs ayant remercié restants à prendre en compte',
	'ACP_USERSTHANKS'					=> 'Nombre d’utilisateurs ayant remercié',

	'GRAPHIC_BLOCK_BACK'				=> 'ext/gfksx/thanksforposts/images/rating/reput_block_back.gif',
	'GRAPHIC_BLOCK_RED'					=> 'ext/gfksx/thanksforposts/images/rating/reput_block_red.gif',
	'GRAPHIC_DEFAULT'					=> 'Images',
	'GRAPHIC_OPTIONS'					=> 'Options graphiques',
	'GRAPHIC_STAR_BACK'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_back.gif',
	'GRAPHIC_STAR_BLUE'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_blue.gif',
	'GRAPHIC_STAR_GOLD'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif',

	'IMG_THANKPOSTS'					=> 'Pour remercier le message',
	'IMG_REMOVETHANKS'					=> 'Annuler le remerciements',

	'LOG_CONFIG_THANKS'					=> 'Configuration mise à jour de l’extension Remerciements des messages',

	'REFRESH'							=> 'Envoyer',
	'REMOVE_THANKS'						=> 'Supprimer les remerciements',
	'REMOVE_THANKS_EXPLAIN'				=> 'Les utilisateurs peuvent supprimer leurs remerciements si cette option est activée.',

	'STEPR'								=> ' - exécuté(s), étape %s',

	'THANKS_COUNTERS_VIEW'				=> 'Compteur des remerciements',
	'THANKS_COUNTERS_VIEW_EXPLAIN'		=> 'Si cette option est activée, l’information du bloc à propos de l’auteur indiquera le nombre de remerciements émis / reçus.',
	'THANKS_FORUM_REPUT_VIEW'			=> 'Afficher le classement des forums',
	'THANKS_GLOBAL_POST'				=> 'Remerciements dans les annonces globales',
	'THANKS_GLOBAL_POST_EXPLAIN'		=> 'Si cette option est activée, les remerciements dans les annonces globales sont possibles.',
	'THANKS_FORUM_REPUT_VIEW_EXPLAIN'	=> 'Si cette option est activée, le classement des forums est affiché dans la liste des forums.',
	'THANKS_INFO_PAGE'					=> 'Les messages d’informations',
	'THANKS_INFO_PAGE_EXPLAIN'			=> 'Si cette option est activée, les messages d’informations sont affichés après avoir ajouté ou retiré un remerciement pour le message.',
	'THANKS_NOTICE_ON'					=> 'Avis disponibles',
	'THANKS_NOTICE_ON_EXPLAIN'			=> 'Si cette option est activée, les avis sont disponibles et l’utilisateur peut configurer la notification depuis son profil.',
	'THANKS_NUMBER'						=> 'Nombre de remerciements affichés dans la vue du profil',
	'THANKS_NUMBER_EXPLAIN'				=> 'Permet de saisir le nombre maximum de remerciements affichés lorsque l’on visualise un profil.<br /><strong>Merci de noter qu’un ralentissement peut être constaté si cette valeur est paramétrée sur 250.</strong>',
	'THANKS_NUMBER_DIGITS'				=> 'Nombre de décimales pour le classement',
	'THANKS_NUMBER_DIGITS_EXPLAIN'		=> 'Permet de saisir le nombre de décimales pour la valeur du classement.',
	'THANKS_NUMBER_ROW_REPUT'			=> 'Nombre de lignes dans le Top du classement',
	'THANKS_NUMBER_ROW_REPUT_EXPLAIN'	=> 'Permet de saisir le nombre de ligne à afficher dans les messages, les sujets et les forums du Top du classement.',
	'THANKS_NUMBER_POST'				=> 'Nombre de remerciements listés dans un message',
	'THANKS_NUMBER_POST_EXPLAIN'		=> 'Permet de saisir un nombre maximum de remerciements affichés lorsque l’on visualise un message.<br /><strong>Merci de noter qu’un ralentissement peut être constaté si cette valeur est paramétrée sur 250.</strong>',
	'THANKS_ONLY_FIRST_POST'			=> 'Uniquement pour le premier message du sujet',
	'THANKS_ONLY_FIRST_POST_EXPLAIN'	=> 'Si cette option est activée, les utilisateurs peuvent remercier uniquement le premier message du sujet.',
	'THANKS_POST_REPUT_VIEW'			=> 'Afficher le classement des messages',
	'THANKS_POST_REPUT_VIEW_EXPLAIN'	=> 'Si cette option est activée, le classement des messages est affiché lorsque l’on visualise un sujet.',
	'THANKS_POSTLIST_VIEW'				=> 'Lister les remerciements dans un message',
	'THANKS_POSTLIST_VIEW_EXPLAIN'		=> 'Si cette option est activée, une liste des utilisateurs qui ont remercié l’auteur du message est affichée.<br/><strong>Merci de noter que cette option est disponible uniquement si l’administrateur a activé les permissions de remercier dans ce forum.</strong>',
	'THANKS_PROFILELIST_VIEW'			=> 'Lister les remerciements dans le profil',
	'THANKS_PROFILELIST_VIEW_EXPLAIN'	=> 'Si cette option est activée, une liste complète des remerciements est affichée (incluant le nombre de remerciements et pour quel message l’utilisateur a été remercié).',
	'THANKS_REFRESH'					=> 'Mettre à jour les compteurs des remerciements',
	'THANKS_REFRESH_EXPLAIN'			=> 'Sur cette page il est possible de mettre à jour les compteurs des remerciements :<br /> - après avoir exécuté une suppression de masse de messages, de sujets ou d’utilisateurs ;<br /> - après avoir divisé ou fusionné des sujets ;<br /> - après avoir configuré ou retiré des annonces globales ;<br /> - après avoir activé ou désactivé l’option « Uniquement pour le premier message du sujet » ;<br /> - après avoir modifié les propriétaires des messages ;<br /> - etc..<br />Cette action peut mettre un certain temps.<br /><strong>Afin que la mise à jour des compteurs se déroule correctement il est nécessaire d’utiliser un serveur MySQL ayant une version 4.1 ou plus récente !<br />Par ailleurs, merci de noter que :<br /> - la mise à jour va supprimer tous les remerciements des messages des invités !<br /> - la mise à jour va supprimer tous les remerciements des annonces globales, si l’option « Remerciements dans les annonces globales » est désactivée !<br /> - la mise à jour va supprimer tous les remerciements des messages des sujets exceptés les premiers messages des sujets, si l’option « Uniquement pour le premier message du sujet » est activée !</strong>',
	'THANKS_REFRESH_MSG'				=> 'Cela peut prendre quelques minutes. Tous les remerciements incorrects seront supprimés !<br />Cette action est irréversible !',
	'THANKS_REFRESHED_MSG'				=> 'Compteurs mis à jour',
	'THANKS_REPUT_GRAPHIC'				=> 'Affichage graphique du classement',
	'THANKS_REPUT_GRAPHIC_EXPLAIN'		=> 'Si cette option est activée, la valeur du classement est affichée graphiquement, en utilisant les images ci-dessous.',
	'THANKS_REPUT_HEIGHT'				=> 'Hauteur des graphiques',
	'THANKS_REPUT_HEIGHT_EXPLAIN'		=> 'Permet de saisir la hauteur en pixels du curseur pour le classement.<br /><strong>Merci de noter que pour un affichage correct, la hauteur saisie doit être égale à la hauteur de l’image suivante !</strong>',
	'THANKS_REPUT_IMAGE'				=> 'Image principale pour le curseur',
	'THANKS_REPUT_IMAGE_DEFAULT'		=> '<strong>Aperçu des graphiques</strong>',
	'THANKS_REPUT_IMAGE_DEFAULT_EXPLAIN' => 'Permet de définir le nom et le chemin de l’image. La taille de l’image est de 15px x 15px.<br />Il est possible d’utiliser ses propres images pour le premier plan et l’arrière plan. Pour cela il est nécessaire d’utiliser le fichier « reput_star_.psd » dans le dossier « contrib ». <strong>La hauteur et la largeur de l’image doivent être les mêmes pour assurer l’affichage correcte de l’échelle de l’image.</strong>',
	'THANKS_REPUT_IMAGE_EXPLAIN'		=> 'Permet de saisir le chemin par rapport au dossier racine de phpBB pour l’image de l’échelle graphique.',
	'THANKS_REPUT_IMAGE_NOEXIST'		=> 'Image principale de l’échelle graphique introuvable.',
	'THANKS_REPUT_IMAGE_BACK'			=> 'Image d’arrière plan pour le curseur',
	'THANKS_REPUT_IMAGE_BACK_EXPLAIN'	=> 'Permet de saisir le chemin par rapport au dossier racine de phpBB pour l’image d’arrière plan de l’échelle graphique.',
	'THANKS_REPUT_IMAGE_BACK_NOEXIST'	=> 'Image d’arrière plan de l’échelle graphique introuvable.',
	'THANKS_REPUT_LEVEL'				=> 'Nombre d’images dans l’échelle graphique',
	'THANKS_REPUT_LEVEL_EXPLAIN'		=> 'Permet de saisir le nombre maximal d’images affichées pour la valeur correspondante à 100% de l’échelle du classement graphique.',
	'THANKS_TIME_VIEW'					=> 'Heure du remerciement',
	'THANKS_TIME_VIEW_EXPLAIN'			=> 'Si cette option est activée, le message affichera l’heure du remerciement.',
	'THANKS_TOP_NUMBER'					=> 'Nombre d’utilisateurs dans le Top du classement',
	'THANKS_TOP_NUMBER_EXPLAIN'			=> 'Permet de saisir le nombre d’utilisateurs à afficher dans le Top du classement sur l’index. La valeur « 0 » désactive l’affichage du Top du classement.',
	'THANKS_TOPIC_REPUT_VIEW'			=> 'Afficher le classement des sujets',
	'THANKS_TOPIC_REPUT_VIEW_EXPLAIN'	=> 'Si cette option est activée, le classement des sujets est affiché lorsque l’on visualise un forum.',
	'TRUNCATE'							=> 'Envoyer',
	'TRUNCATE_THANKS'					=> 'Purger la liste des remerciements',
	'TRUNCATE_THANKS_EXPLAIN'			=> 'Cette action purge tous les compteurs de remerciements (supprime tous les remerciements).<br />Cette action est irréversible !',
	'TRUNCATE_THANKS_MSG'				=> 'Les compteurs de remerciements ont été purgés.',
	'REFRESH_THANKS_CONFIRM'			=> 'Confirmer la mise à jour les compteurs de remerciements.',
	'TRUNCATE_THANKS_CONFIRM'			=> 'Confirmer la purge des compteurs de remerciements.',
	'TRUNCATE_NO_THANKS'				=> 'L’opération a été annulée.',
	'ALLOW_THANKS_PM_ON'				=> 'Notifier moi par message privé si quelqu’un remercie un de mes messages',
	'ALLOW_THANKS_EMAIL_ON'				=> 'Notifier moi par e-mail si un quelqu’un remercie un de mes messages',
]);
