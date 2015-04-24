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
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'CLEAR_LIST_THANKS'			=> 'Vider la liste des remerciements',
	'CLEAR_LIST_THANKS_CONFIRM'	=> 'Voulez-vous vraiment effacer la liste des remerciements de l’utilisateur ?',
	'CLEAR_LIST_THANKS_GIVE'	=> 'La liste des remerciements de l’utilisateur a été effacée.',
	'CLEAR_LIST_THANKS_POST'	=> 'La liste de remerciements dans le message a été effacée.',
	'CLEAR_LIST_THANKS_RECEIVE'	=> 'La liste des merci obtenus par l’utilisateur a été effacée.',

	'DISABLE_REMOVE_THANKS'		=> 'La suppression des remerciements a été désactivée par l’administrateur',

	'GIVEN'						=> 'A remercié',
	'GLOBAL_INCORRECT_THANKS'	=> 'Vous ne pouvez pas remercier une annonce globale qui n’est pas liée à un forum en particulier.',
	'GRATITUDES'				=> 'Liste des remerciements',

	'INCORRECT_THANKS'			=> 'Remerciement invalide',

	'JUMP_TO_FORUM'				=> 'Aller au forum',
	'JUMP_TO_TOPIC'				=> 'Aller au sujet',

	'FOR_MESSAGE'				=> ' pour le message',
	'FURTHER_THANKS'     	    => ' et un autre utilisateur',
	'FURTHER_THANKS_PL'         => ' et %d autres utilisateurs',

	'NO_VIEW_USERS_THANKS'		=> 'Vous n’êtes pas autorisé à voir la liste des remerciements.',

	'NOTIFICATION_THANKS_GIVE'	=> array(
		1 => '<strong>Remerciement reçu</strong> de %1$s pour le message :',
		2 => '<strong>Remerciements reçus</strong> de %1$s pour le message :',
	),
	'NOTIFICATION_THANKS_REMOVE'=> array(
		1 => '<strong>Remerciement retiré</strong> de %1$s pour le message :',
		2 => '<strong>Remerciements retirés</strong> de %1$s pour le message :',
	),
	'NOTIFICATION_TYPE_THANKS_GIVE'		=> 'Quelqu’un vous a remercié pour votre message',
	'NOTIFICATION_TYPE_THANKS_REMOVE'	=> 'Quelqu’un a retiré son remerciement pour votre message',

	'RECEIVED'					=> 'A été remercié',
	'REMOVE_THANKS'				=> 'Retirer vos remerciements à l’auteur : ',
	'REMOVE_THANKS_CONFIRM'		=> 'Êtes-vous sûr(e) de vouloir retirer vos remerciements à l’auteur pour son message ?',
	'REMOVE_THANKS_SHORT'		=> 'Remerciement(s) retiré(s)',
	'REPUT'						=> 'Classement',
	'REPUT_TOPLIST'				=> 'Top %d des remerciements',
	'RETING_LOGIN_EXPLAIN'		=> 'Vous n’êtes pas autorisé à voir le Top du classement.',
	'RATING_NO_VIEW_TOPLIST'	=> 'Vous n’êtes pas autorisé à voir le Top du classement.',
	'RATING_VIEW_TOPLIST_NO'	=> 'La liste du Top du classement est vide ou désactivée par l’administrateur.',
	'RATING_FORUM'				=> 'Forum',
	'RATING_POST'				=> 'Message',
	'RATING_TOP_FORUM'			=> 'Classement des forums',
	'RATING_TOP_POST'			=> 'Classement des messages',
	'RATING_TOP_TOPIC'			=> 'Classement des sujets',
	'RATING_TOPIC'				=> 'Sujet',
//	'RETURN_POST'				=> 'Retour',

	'THANK'						=> 'Heure',
	'THANK_FROM'				=> 'de',
	'THANK_TEXT_1'				=> 'Ces utilisateurs ont remercié l’auteur ',
	'THANK_TEXT_2'				=> ' pour son message : ',
	'THANK_TEXT_2PL'			=> ' pour son message (total %d) :',
	'THANK_POST'				=> 'Remercier pour ce message l’auteur : ',
	'THANK_POST_SHORT'			=> 'Remerciements',
	'THANKS'					=> array(
		1	=> '%d fois',
		2	=> '%d fois',
	),
	'THANKS_BACK'				=> 'Retour',
	'THANKS_INFO_GIVE'			=> 'Vous venez de remercier l’auteur pour son message.',
	'THANKS_INFO_REMOVE'		=> 'Vous venez de retirer vos remerciements à l’auteur pour son message.',
	'THANKS_LIST'				=> 'Voir / Fermer la liste',
	'THANKS_PM_MES_GIVE'		=> 'vous a remercié pour le message',
	'THANKS_PM_MES_REMOVE'		=> 'a retiré son remerciement pour le message',
	'THANKS_PM_SUBJECT_GIVE'	=> 'Remerciement pour le message',
	'THANKS_PM_SUBJECT_REMOVE'	=> 'Remerciement retiré pour le message',
	'THANKS_USER'				=> 'Liste des remerciements',

	'THANKS_INSTALLED'			=> 'Remerciements pour le message',
	'THANKS_INSTALLED_EXPLAIN'  => '<strong>ATTENTION !<br />Il est fortement conseillé de lancer l’installation après avoir suivi l’instruction sur les changements du code dans les fichiers (ou d’effectuer l’installation à l’aide d’AutoMod) ! <br />Il est également fortement recommandé de sélectionner Oui pour afficher les résultats complets (ci-dessous) !</strong>',
	'THANKS_CUSTOM0_FUNCTION'	=> 'Mettre à jour les valeurs de la table de la basse de données : _thanks',
	'THANKS_CUSTOM1_FUNCTION'	=> 'Vérifier que l’extension est retirée',
	'THANKS_CUSTOM2_FUNCTION'	=> 'Vérifier la mise à jour du cache',
	'TOPLIST'					=> 'Top du classement des messages',
));
