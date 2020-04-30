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
	'CLEAR_LIST_THANKS'			=> 'Limpiar lista de gracias',
	'CLEAR_LIST_THANKS_CONFIRM'	=> '¿De verdad quieren limpiar la lista gracias a un usuario?',
	'CLEAR_LIST_THANKS_GIVE'	=> 'La lista de gracias ha sido limpiada.',
	'CLEAR_LIST_THANKS_POST'	=> 'La lista de gracias en los mensajes ha sido borrada',
	'CLEAR_LIST_THANKS_RECEIVE'	=> 'La lista de gracias recibidas por un usuario ,ha sido borrada.',

	'DISABLE_REMOVE_THANKS'		=> 'Borrar gracias esta desactivado por el administrador',

	'GIVEN'						=> 'Agradecido ',
	'GLOBAL_INCORRECT_THANKS'	=> 'No se puede dar gracias al Anuncio global que no tiene ninguna relación con el foro en particular.',
	'GRATITUDES'				=> 'Gratitudes',

	'INCORRECT_THANKS'			=> 'Gracias no validas',

	'JUMP_TO_FORUM'				=> 'Ir al foro',
	'JUMP_TO_TOPIC'				=> 'Ir al tema',

	'FOR_MESSAGE'				=> ' por mensaje',
	'FURTHER_THANKS'     	    => [
		1 => ' y otro usario',
		2 => ' y d% usuarios más',
	],

	'NO_VIEW_USERS_THANKS'		=> 'No está autorizado para ver la lista de gracias.',

	'NOTIFICATION_THANKS_GIVE'	=> [
		1 => '<strong>Agradecimiento recibido</strong> de %1$s por el mensaje:',
		2 => '<strong>Agradecimientos recibidos</strong> de %1$s por el mensaje:',
	],
	'NOTIFICATION_THANKS_REMOVE'=> [
		1 => '<strong>Agradecimiento eliminado</strong> de %1$s por el mensaje:',
		2 => '<strong>Agradecimientos eliminados</strong> de %1$s por el mensaje:',
	],
	'NOTIFICATION_TYPE_THANKS_GIVE'		=> 'Alguien le dio las gracias por su mensaje',
	'NOTIFICATION_TYPE_THANKS_REMOVE'	=> 'Alguien elimino el agradecimientos por su mensaje',

	'RECEIVED'					=> 'Agradecimiento recibido',
	'REMOVE_THANKS'				=> 'Eliminar su agradecimiento: ',
	'REMOVE_THANKS_CONFIRM'		=> '¿Está seguro que desea eliminar su agradecimiento?',
	'REMOVE_THANKS_SHORT'		=> 'Eliminar agradecimiento',
	'REPUT'						=> 'Valoreción',
	'REPUT_TOPLIST'				=> 'Lista TOP de agradecimientos — %d',
	'RATING_LOGIN_EXPLAIN'		=> 'No está autorizado para ver la Lista TOP.',
	'RATING_NO_VIEW_TOPLIST'	=> 'No está autorizado para ver la Lista TOP.',
	'RATING_VIEW_TOPLIST_NO'	=> 'Lista TOP desactivada por el Administrador',
	'RATING_FORUM'				=> 'Foro',
	'RATING_POST'				=> 'Mensaje',
	'RATING_TOP_FORUM'			=> 'Valoración de foros',
	'RATING_TOP_POST'			=> 'Valoración de mensajes',
	'RATING_TOP_TOPIC'			=> 'Valoración de temas',
	'RATING_TOPIC'				=> 'Tema',

	'THANK'						=> 'vez',
	'THANK_FROM'				=> 'de',
	'THANK_TEXT_1'				=> 'Estos usuarios agradecierón al autor ',
	'THANK_TEXT_2'				=> ' por el mensaje: ',
	'THANK_TEXT_2PL'			=> ' por el mensaje (total %d):',
	'THANK_POST'				=> 'De las gracias al autor del mensaje: ',
	'THANK_POST_SHORT'			=> 'Gracias',
	'THANKS'					=> [
		1	=> '%d vez',
		2	=> '%d veces',
	],
	'THANKS_BACK'				=> 'Volver',
	'THANKS_INFO_GIVE'			=> 'Acaba de dar gracias por el mensaje.',
	'THANKS_INFO_REMOVE'		=> 'Acaba de eliminar el agradecimiento.',
	'THANKS_LIST'				=> 'Ver/Cerrar lista',
	'THANKS_PM_MES_GIVE'		=> 'Gracias por el mensaje',
	'THANKS_PM_MES_REMOVE'		=> 'Eliminar gracias',
	'THANKS_PM_SUBJECT_GIVE'	=> 'Gracias por el mensaje',
	'THANKS_PM_SUBJECT_REMOVE'	=> 'Eliminar gracias',
	'THANKS_USER'				=> 'Lista de gracias',
	'TOPLIST'					=> 'Lista TOP de mensajes',
]);
