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
	'ACP_DELTHANKS'						=> 'Eliminar gracias',
	'ACP_POSTS'							=> 'Mensajes totales',
	'ACP_POSTSEND'						=> 'Mensajes con agradecimientos',
	'ACP_POSTSTHANKS'					=> 'Mensajes totales con agradecimientos',
	'ACP_THANKS'						=> 'Thanks for posts',
	'ACP_THANKS_MOD_VER'				=> 'Versión de Extensión: ',
	'ACP_THANKS_TRUNCATE'				=> 'Limpiar la lista de gracias',
	'ACP_ALLTHANKS'						=> 'Agradecimientos que se han tenido en cuenta',
	'ACP_THANKSEND'						=> 'Agradecimientos que quedan por tener en cuenta',
	'ACP_THANKS_REPUT'					=> 'Opciones de valoración',
	'ACP_THANKS_REPUT_SETTINGS'			=> 'Opciones de valoración',
	'ACP_THANKS_REPUT_SETTINGS_EXPLAIN'	=> 'Aquí se puede establecer la configuración predeterminada para la valoración de mensajes, los temas y foros, basado en el sistema de Gracias. <br /> Asunto (correo, temas y foros), que cuenta con el mayor número total de agradecimiento, se toma como calificación del 100%.',
	'ACP_THANKS_SETTINGS'				=> 'Configuración de gracias',
	'ACP_THANKS_SETTINGS_EXPLAIN'		=> 'Aqui puede ajustar valores personalziados para Thanks for posts.',
	'ACP_THANKS_REFRESH'				=> 'Actualizar contadores',
	'ACP_UPDATETHANKS'					=> 'Registro de agradecimientos actualizado',
	'ACP_USERSEND'						=> 'Sigue los usuarios que agredecieron',
	'ACP_USERSTHANKS'					=> 'Usuarios totales que agradecieron',

	'GRAPHIC_BLOCK_BACK'				=> 'ext/gfksx/thanksforposts/images/rating/reput_block_back.gif',
	'GRAPHIC_BLOCK_RED'					=> 'ext/gfksx/thanksforposts/images/rating/reput_block_red.gif',
	'GRAPHIC_DEFAULT'					=> 'Imágenes',
	'GRAPHIC_OPTIONS'					=> 'Opciones gráficas',
	'GRAPHIC_STAR_BACK'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_back.gif',
	'GRAPHIC_STAR_BLUE'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_blue.gif',
	'GRAPHIC_STAR_GOLD'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif',

	'IMG_THANKPOSTS'					=> 'Para agradecer por mensaje',
	'IMG_REMOVETHANKS'					=> 'Para retirar agradecimiento',

	'LOG_CONFIG_THANKS'					=> 'Configuración de Thanks for Post actualizada',

	'REFRESH'							=> 'Refrescar',
	'REMOVE_THANKS'						=> 'Eliminar gracias',
	'REMOVE_THANKS_EXPLAIN'				=> 'Si los usuarios pueden eliminar gracias',

	'STEPR'								=> ' - ejecutado el paso , %s',

	'THANKS_COUNTERS_VIEW'				=> 'Contadores de agradecimiento',
	'THANKS_COUNTERS_VIEW_EXPLAIN'		=> 'Si se activa, el bloque de información sobre el autor mostrará el número de gracias dadas y recibidas',
	'THANKS_FORUM_REPUT_VIEW'			=> 'Mostrar calificación en los foros',
	'THANKS_GLOBAL_POST'				=> 'Agradecimiento en Anuncio Global',
	'THANKS_GLOBAL_POST_EXPLAIN'		=> 'Si está activado, el AGradecimiento en Anuncio Globar estará activado.',
	'THANKS_FORUM_REPUT_VIEW_EXPLAIN'	=> 'Si está activado, se mostrará la calificación en la lista de foros',
	'THANKS_INFO_PAGE'					=> 'Imformación',
	'THANKS_INFO_PAGE_EXPLAIN'			=> 'Si se activa, después de la emisión y cancelación de gracias muestra mensajes de información',
	'THANKS_NOTICE_ON'					=> 'Avisos disponibles',
	'THANKS_NOTICE_ON_EXPLAIN'			=> 'Si está activado,están disponibles los avisos y el usuario puede configurar la notificación a través de su perfil.',
	'THANKS_NUMBER'						=> 'Número de agradecimientos en la lista de perfil',
	'THANKS_NUMBER_EXPLAIN'				=> 'Número máximo de gratitud que aparecera en el prifl. <br /> <strong> Recuerde que el consumo se notará si este valor se establece en más de 250. </strong>',
	'THANKS_NUMBER_DIGITS'				=> 'El número de decimales para votar',
	'THANKS_NUMBER_DIGITS_EXPLAIN'		=> 'Especifique el número de decimales para la calificación de valor',
	'THANKS_NUMBER_ROW_REPUT'			=> 'El número de filas en el Top para votar',
	'THANKS_NUMBER_ROW_REPUT_EXPLAIN'	=> 'Especifique el número de filas que se mostraran en en la claficación de  número de mensajes de Top, los temas y foros',
	'THANKS_NUMBER_POST'				=> 'Número de gracias en la lista en los mensajes',
	'THANKS_NUMBER_POST_EXPLAIN'		=> 'Número máximo de gracia mostrdo cuando se ve un tema. <br /> <strong> Recuerde que la carga del servidor  se notará si este valor se establece en más de 250. </strong>',
	'THANKS_ONLY_FIRST_POST'			=> 'Sólo en el primer mensaje del tema',
	'THANKS_ONLY_FIRST_POST_EXPLAIN'	=> 'Si está activado, se puede dar las gracias sólo el primer mensaje del tema',
	'THANKS_POST_REPUT_VIEW'			=> 'Mostrar mensajes de valoración',
	'THANKS_POST_REPUT_VIEW_EXPLAIN'	=> 'Si está activado, se mostrará el valor de clasificación para los puestos al visualizar un tema',
	'THANKS_POSTLIST_VIEW'				=> 'Lista de gracias en el mensaje',
	'THANKS_POSTLIST_VIEW_EXPLAIN'		=> 'Si está activado,  se mostrará la lista de usuarios que han dado las gracias al autor del tema. <br/>  Tenga en cuenta que esta opción sería efectiva si el administrador ha habilitado el permiso para dar gracias por el mensaje en ese foro.',
	'THANKS_PROFILELIST_VIEW'			=> 'Lista de gracias en el perfil',
	'THANKS_PROFILELIST_VIEW_EXPLAIN'	=> 'Si esta opción está activada, completa información de agradecimiento, incluyendo el número de agradecimiento y cuando un usuario que ha recibido  agradecimientos ,se mostraran.',
	'THANKS_REFRESH'					=> 'Actualizar contadores de gracias',
	'THANKS_REFRESH_EXPLAIN'			=> 'Aquí usted puede actualizar los contadores de gracias después de la eliminación de mensajes / temas / usuarios. Esto puede tomar algún tiempo.',
	'THANKS_REFRESH_MSG'				=> 'El cache de actualizaciones puede tardar unos minutos. Todas las entradas incorrectas de agradecimientos sera borradas! <br /> Esta acción no es reversible!',
	'THANKS_REFRESHED_MSG'				=> 'Contadores de actualización',
	'THANKS_REPUT_GRAPHIC'				=> 'Representación gráfica de la calificación',
	'THANKS_REPUT_GRAPHIC_EXPLAIN'		=> 'Si está activado, el valor nominal se mostrará gráficamente utilizando la siguiente imagen',
	'THANKS_REPUT_HEIGHT'				=> 'Altura de graficos',
	'THANKS_REPUT_HEIGHT_EXPLAIN'		=> 'Especificar la altura de la barra de desplazamiento para la clasificación en píxeles. <br /> <strong> ¡Atención! Para ver correctamente debe indicar la altura, igual a la altura de la imagen siguiente! </strong>',
	'THANKS_REPUT_IMAGE'				=> 'La imagen principal para el control deslizante',
	'THANKS_REPUT_IMAGE_DEFAULT'		=> 'Ejemplos de imágenes gráficas',
	'THANKS_REPUT_IMAGE_DEFAULT_EXPLAIN' => 'Aquí puede ver la propia imagen y la ruta a la imagen para la prosilver estilo. Imagen tamaños 15x15 píxeles. <br /> Usted puede dibujar sus propias imágenes - primer plano y fondo. <strong> La altura y la anchura de la imagen debe ser la misma para la correcta construcción de la escala gráfica.</strong>',
	'THANKS_REPUT_IMAGE_EXPLAIN'		=> 'La ruta de acceso relativa a la carpeta raíz de la imagen de phpBB  elegidos para la escala gráfica.',
	'THANKS_REPUT_IMAGE_NOEXIST'		=> 'La imagen grafica a escala no existe',
	'THANKS_REPUT_IMAGE_BACK'			=> 'La imagen de fondo de la barra',
	'THANKS_REPUT_IMAGE_BACK_EXPLAIN'	=> 'La ruta de acceso relativa a la raíz del phpBB de  una imagen de fondo, elegida para la escala gráfica.',
	'THANKS_REPUT_IMAGE_BACK_NOEXIST'	=> 'La image de fondo a escala grafica no existe',
	'THANKS_REPUT_LEVEL'				=> 'Número de imágenes en una escala gráfica',
	'THANKS_REPUT_LEVEL_EXPLAIN'		=> 'El número máximo de imágenes que corresponde a 100% del valor de la escala de calificación en el gráfico',
	'THANKS_TIME_VIEW'					=> 'Fecha de las gracias',
	'THANKS_TIME_VIEW_EXPLAIN'			=> 'Si se activa, en el mensaje se mostrará la fecha de las  gracias',
	'THANKS_TOP_NUMBER'					=> 'Número de usuarios en el Top',
	'THANKS_TOP_NUMBER_EXPLAIN'			=> 'Especifique el número de usuarios para mostrar en el Top. 0 - Para desactivar la lista TOP.',
	'THANKS_TOPIC_REPUT_VIEW'			=> 'Mostrar valoración de tema',
	'THANKS_TOPIC_REPUT_VIEW_EXPLAIN'	=> 'Si se incluye, se mostrará la calificación para el tema durante la visualización de un foro ',
	'TRUNCATE'							=> 'Limpiar',
	'TRUNCATE_THANKS'					=> 'Limpiar la lista de gracias',
	'TRUNCATE_THANKS_EXPLAIN'			=> 'Este procedimiento limpia los conadores de gracias (elimina todos las gracias publicadas). <br /> La acción no es reversible!',
	'TRUNCATE_THANKS_MSG'				=> 'Contadores de gracias limpiados.',
	'REFRESH_THANKS_CONFIRM'			=> '¿Realmente desea actualizar los contadores de Gracias?',
	'TRUNCATE_THANKS_CONFIRM'			=> '¿Realmente desea limpiar el contador de Gracias?',
	'TRUNCATE_NO_THANKS'				=> 'Operación cancelada',
	'ALLOW_THANKS_PM_ON'				=> 'Notificar por MP si se agradece cualquiera de mis mensajes',
	'ALLOW_THANKS_EMAIL_ON'				=> 'Notificar por email si se agradece cualquiera de mis mensajes',
]);
