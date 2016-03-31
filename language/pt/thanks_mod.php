<?php
/**
*
* Thanks For Posts extension for the phpBB Forum Software package.
*
* @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
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
	'CLEAR_LIST_THANKS'			=> 'Limpar lista de agradecimentos',
	'CLEAR_LIST_THANKS_CONFIRM'	=> 'Tem a certeza que deseja limpar a sua lista de agradecimentos?',
	'CLEAR_LIST_THANKS_GIVE'	=> 'Lista de agradecimentos dados foi limpa.',
	'CLEAR_LIST_THANKS_POST'	=> 'Lista de mensagens de agradecimentos foi limpa.',
	'CLEAR_LIST_THANKS_RECEIVE'	=> 'Lista de agradecimentos recebidos foi limpa.',

	'DISABLE_REMOVE_THANKS'		=> 'A eliminação de agradecimentos foi desativada pelo Administrador',

	'GIVEN'						=> 'Enviou',
	'GLOBAL_INCORRECT_THANKS'	=> 'Não pode agradecer um Anúncio Global porque não tem nenhum fórum específico.',
	'GRATITUDES'				=> 'Agradecimentos',

	'INCORRECT_THANKS'			=> 'Dados incorretos',

	'JUMP_TO_FORUM'				=> 'Ir para o Fórum',
	'JUMP_TO_TOPIC'				=> 'Ir para o Tópico',

	'FOR_MESSAGE'				=> ' pela mensagem',
	'FURTHER_THANKS'     	    => ' e mais um utilizador',
	'FURTHER_THANKS_PL'         => 'em mais %d utilizadores',

	'NO_VIEW_USERS_THANKS'		=> 'Não tem autorização para ver a lista de agradecimentos.',

	'NOTIFICATION_THANKS_GIVE'	=> array(
		1 => '<strong>Agradecimento recebido</strong> de %1$s pela mensagem:',
		2 => '<strong>Agradecimentos recebidos</strong> de %1$s pela mensagem:',
	),
	'NOTIFICATION_THANKS_REMOVE'=> array(
		1 => '<strong>Agradecimento eliminado</strong> de %1$s pela mensagem:',
		2 => '<strong>Agradecimentos eliminados</strong> de %1$s pela mensagem:',
	),
	'NOTIFICATION_TYPE_THANKS_GIVE'		=> 'Alguém agradece pela mensagem',
	'NOTIFICATION_TYPE_THANKS_REMOVE'	=> 'Alguém eliminou o agradecimento da mensagem ',

	'RECEIVED'					=> 'Agradecimiento recebido',
	'REMOVE_THANKS'				=> 'Eliminar o seu agradecimento: ',
	'REMOVE_THANKS_CONFIRM'		=> 'Está seguro que deseja eliminar o seu agradecimento?',
	'REMOVE_THANKS_SHORT'		=> 'Eliminar agradecimento',
	'REPUT'						=> 'Classificação',
	'REPUT_TOPLIST'				=> 'Agradecimentos Toplist — %d',
	'RATING_LOGIN_EXPLAIN'		=> 'Não está autorizado a ver a toplist.',
	'RATING_NO_VIEW_TOPLIST'	=> 'Não está autorizado a ver a toplist.',
	'RATING_VIEW_TOPLIST_NO'	=> 'A Toplist está vazia ou desativada pelo Administrador',
	'RATING_FORUM'				=> 'Forum',
	'RATING_POST'				=> 'Mensagem',
	'RATING_TOP_FORUM'			=> 'Avaliação Fóruns',
	'RATING_TOP_POST'			=> 'Avaliação Mensagens',
	'RATING_TOP_TOPIC'			=> 'Avaliação Tópicos',
	'RATING_TOPIC'				=> 'Tópico',
//	'RETURN_POST'				=> 'Voltar',

	'THANK'						=> 'vez',
	'THANK_FROM'				=> 'de',
	'THANK_TEXT_1'				=> 'Estes utilizadores agradeceram ao autor ',
	'THANK_TEXT_2'				=> ' pela mensagem: ',
	'THANK_TEXT_2PL'			=> ' pela mensagem (total %d):',
	'THANK_POST'				=> 'Agradecer por esta mensagem ao autor: ',
	'THANK_POST_SHORT'			=> 'Obrigado',
	'THANKS'					=> array(
		1	=> '%d vez',
		2	=> '%d vezes',
	),
	'THANKS_BACK'				=> 'Voltar',
	'THANKS_INFO_GIVE'			=> 'Agradeceu ao autor.',
	'THANKS_INFO_REMOVE'		=> 'Retirou agradecimentos ao autor.',
	'THANKS_LIST'				=> 'Ver/ocultar lista',
	'THANKS_PM_MES_GIVE'		=> 'Agradecer pela mensagem',
	'THANKS_PM_MES_REMOVE'		=> 'Retirar agradecimento',
	'THANKS_PM_SUBJECT_GIVE'	=> 'Agradecer pela mensagem',
	'THANKS_PM_SUBJECT_REMOVE'	=> 'Retirar agradecimento',
	'THANKS_USER'				=> 'Lista de agradecimentos',

	'THANKS_INSTALLED'			=> 'Módulo de Agradecimentos',
	'THANKS_INSTALLED_EXPLAIN'  => '<strong>Atenção!<br />Recomendamos que só execute a instalação depois de fazer a modificação do código dos ficheiros (ou executar a instalação usando o AutoMod)! <br /> Também se recomenda que selecione Sim para ver os resultados completos (em baixo)!</strong>',
	'THANKS_CUSTOM0_FUNCTION'	=> 'Atualizar a tabela _thanks',
	'THANKS_CUSTOM1_FUNCTION'	=> 'Verificar remoção do módulo',
	'THANKS_CUSTOM2_FUNCTION'	=> 'Verificar atualização de cache',
	'TOPLIST'					=> 'TOP lista mensagens',
));
