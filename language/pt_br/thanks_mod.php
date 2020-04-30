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
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'CLEAR_LIST_THANKS'			=> 'Limpar Lista de Agradecimento',
	'CLEAR_LIST_THANKS_CONFIRM'	=> 'Quer realmente limpar esta lista?',
	'CLEAR_LIST_THANKS_GIVE'	=> 'Lista de agradecimentos foi limpa.',
	'CLEAR_LIST_THANKS_POST'	=> 'Lista de agradecimentos foi limpa.',
	'CLEAR_LIST_THANKS_RECEIVE'	=> 'Lista de agradecimentos foi limpa.',

	'DISABLE_REMOVE_THANKS'		=> 'A exclusão de agradecimento foi desabilitada pelo administrador',

	'GIVEN'						=> 'Agradeceu',
	'GLOBAL_INCORRECT_THANKS'	=> 'Você não pode agradecer um anúncio global sem referência a um fórum em particular',
	'GRATITUDES'				=> 'Lista de agradecimentos',

	'INCORRECT_THANKS'			=> 'Agradecimento inválido',

	'JUMP_TO_FORUM'				=> 'Ir ao forum',
	'JUMP_TO_TOPIC'				=> 'Ir ao tópico',

	'FOR_MESSAGE'				=> ' pelo post',
	'FURTHER_THANKS'     	    => [
		1 => ' e mais um usuário',
		2 => ' e mais %d usuários',
	],

	'NO_VIEW_USERS_THANKS'		=> 'Você não tem autorização para ver a lista de agradecimentos.',

	'NOTIFICATION_THANKS_GIVE'	=> [
		1 => '<strong>Recebeu agradecimento</strong> de %1$s pelo post:',
		2 => '<strong>Recebeu agradecimentos</strong> de %1$s pelo post:',
	],
	'NOTIFICATION_THANKS_REMOVE'=> [
		1 => '<strong>Removido agradecimento</strong> de %1$s pelo post:',
		2 => '<strong>Removidos agradecimentos</strong> de %1$s pelo post:',
	],
	'NOTIFICATION_TYPE_THANKS_GIVE'		=> 'Alguém agradeceu seu post',
	'NOTIFICATION_TYPE_THANKS_REMOVE'	=> 'Alguém removeu o agradecimento pelo seu post',

	'RECEIVED'					=> 'Agradeceram',
	'REMOVE_THANKS'				=> 'Remova seu agradecimento: ',
	'REMOVE_THANKS_CONFIRM'		=> 'Quer realmente remover o agradecimento?',
	'REMOVE_THANKS_SHORT'		=> 'Remova agradecimento',
	'REPUT'						=> 'Rating',
	'REPUT_TOPLIST'				=> 'Toplist — %d',
	'RATING_LOGIN_EXPLAIN'		=> 'Você não tem autorização para ver a toplist.',
	'RATING_NO_VIEW_TOPLIST'	=> 'Você não tem autorização para ver a toplist.',
	'RATING_VIEW_TOPLIST_NO'	=> 'Toplist está vazia ou desabilitade pelo administrador',
	'RATING_FORUM'				=> 'Forum',
	'RATING_POST'				=> 'Post',
	'RATING_TOP_FORUM'			=> 'Rating forums',
	'RATING_TOP_POST'			=> 'Rating posts',
	'RATING_TOP_TOPIC'			=> 'Rating tópicos',
	'RATING_TOPIC'				=> 'Topic',
	'RETURN_POST'				=> 'Voltar',

	'THANK'						=> 'vez',
	'THANK_FROM'				=> 'de',
	'THANK_TEXT_1'				=> 'Estes usuários agradeceram ',
	'THANK_TEXT_2'				=> ' pelo post: ',
	'THANK_TEXT_2PL'			=> ' pelo post (total %d):',
	'THANK_POST'				=> 'Agradeça ao autor pelo post: ',
	'THANK_POST_SHORT'			=> 'Agradeça',
	'THANKS'					=> [
		1	=> '%d vez',
		2	=> '%d vezes',
	],
	'THANKS_BACK'				=> 'Voltar',
	'THANKS_INFO_GIVE'			=> 'Você agradeceu o post.',
	'THANKS_INFO_REMOVE'		=> 'Você removeu seu agradecimento.',
	'THANKS_LIST'				=> 'Ver/fechar lista',
	'THANKS_PM_MES_GIVE'		=> 'agradeceram você pelo post',
	'THANKS_PM_MES_REMOVE'		=> 'removeram o agradecimento pelo post',
	'THANKS_PM_SUBJECT_GIVE'	=> 'Agradecimento pelo seu post',
	'THANKS_PM_SUBJECT_REMOVE'	=> 'Removido agradecimento pelo post',
	'THANKS_USER'				=> 'Lista de agradecimentos',
	'TOPLIST'					=> 'Posts toplist',
]);
