<?php
/**
 *
 * @package PBWoW Extension
 * Spanish translation by TurinTurambar (https://github.com/TurinTurambar)
 *
 * @copyright (c) 2015 PayBas
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
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
	// Extension modules
	'ACP_PBWOW3_CATEGORY'		=> 'PBWoW 3',
	'ACP_PBWOW3_OVERVIEW'		=> 'General',
	'ACP_PBWOW3_CONFIG'			=> 'Configuraci&oacute;n',

	// Common
	'PBWOW_ACTIVE'				=> 'activo',
	'PBWOW_INACTIVE'			=> 'inactivo',
	'PBWOW_DETECTED'			=> 'detectado',
	'PBWOW_NOT_DETECTED'		=> 'no detectado',
	'PBWOW_OBSOLETE'			=> 'ya no se usa',
	'PBWOW_FLUSH'				=> 'Vaciar',
	'PBWOW_FATAL'				=> 'Error fatal! Esto no debi&oacute; suceder nunca.',

	'LOG_PBWOW_CONFIG'			=> '<strong>Configuraci&oacute;n de PBWoW modificada</strong><br />&raquo; %s',


	// OVERVIEW //

	'PBWOW_OVERVIEW_TITLE'				=> 'Resumen de PBWoW Extension',
	'PBWOW_OVERVIEW_TITLE_EXPLAIN'		=> 'Gracias por escoger PBWoW, esperamos le guste.',
	'ACP_PBWOW_INDEX_SETTINGS'			=> 'Informati&oacute;n general',

	'PBWOW_DB_CHECK'					=> 'Prueba de BD de PBWoW',
	'PBWOW_DB_GOOD'						=> 'Tabla de configuraci&oacute;n de PBWoW encontrada (%s)',
	'PBWOW_DB_BAD'						=> 'No se encuentra la tabla de configuraci&oacute;n de PBWoW. Aseg&uacute;rese que la tabla (%s) existe en su base de datos de phpBB.',
	'PBWOW_DB_BAD_EXPLAIN'				=> 'Intenta deshabilitar y habilitar la extensi&oacute;n PBWoW 3. Si eso no funciona, deshabilita la extensi&oacute;n y elimina los datos. Luego intenta habilitarla nuevamente.',

	'PBWOW_VERSION_CHECK'				=> 'Prueba de Versi&oacute;n de PBWoW',
	'PBWOW_LATEST_VERSION'				=> '&Uacute;ltima versi&oacute;n',
	'PBWOW_EXT_VERSION'					=> 'Versi&oacute;n de la Extensi&oacute;n',
	'PBWOW_STYLE_VERSION'				=> 'Versi&oacute;n del Estilo',
	'PBWOW_VERSION_ERROR'				=> 'Imposible determinar la versi&oacute;n!',
	'PBWOW_CHECK_UPDATE'				=> 'Busca en <a href="http://pbwow.com/forum/index.php">PBWoW.com</a> para ver si hay actualizaciones disponibles.',

	'PBWOW_CPF_CHECK'					=> 'Prueba de Campos Personalizados del Perfil',
	//'PBWOW_CPF_CREATE_LOCATION'			=> 'Crear o habilitar este campo via PCA > Usuarios y Grupos > Campos personalizados',
	'PBWOW_CPF_LOAD_LOCATION'			=> 'Habilitar esto mediante PCA > General > Configuraci&oacute;n del Sitio > Caracter&iacute;sticas del Sitio',
	'PBWOW_GAME_EXPLAIN'				=> 'Los campos personalizados para este juego est&aacute;n actualmente deshabilitados.',

	'PBWOW_BNETCHARS_CHECK'				=> 'Informaci&oacute;n de personajes mediante Battle.net API',
	'PBWOW_CHARSDB_GOOD'				=> 'Tabla de personajes de PBWoW encontrada (%s)',
	'PBWOW_CHARSDB_BAD'					=> 'No se encuentra la tabla de personajes de PBWoW. Aseg&uacute;rese que la tabla (%s) existe en su base de datos de phpBB.',
	'PBWOW_CHARSDB_BAD_EXPLAIN'			=> 'La tabla requerida en la base de datos para los Personajes de Battle.net de PBWoW 3 debe haber sido instalada autom&aacute;ticamente cuando se instal&oacute; la extensi&oacute;n PBWoW. Por favor desinst&aacute;lela, elimine los datos, e intente instalarla nuevamente.',
	'PBWOW_CHARSDB_FLUSH'				=> 'Eliminar/limpiar la tabla de personajes',
	'PBWOW_CHARSDB_FLUSH_EXPLAIN'		=> 'Esto eliminar&aacute; toda la informaci&oacute;n de personajes de Battle.net guardada en la BD. Esta ser&aacute; obtenida autom&aacute;ticamente otra vez cuando se necesite.',
	'PBWOW_CURL_BAD'					=> 'Su servidor no permite &quot;cURL&quot;!',
	'PBWOW_CURL_BAD_EXPLAIN'			=> 'Verifique la configuraci&oacute;n de su servidor, o contacte a su proveedor. Deshabilite la Battle.net API hasta que se habilite cURL!',

	'PBWOW_DONATE'						=> 'Donar para PBWoW',
	'PBWOW_DONATE_SHORT'				=> 'Haz una donaci&oacute;n para PBWoW',
	'PBWOW_DONATE_EXPLAIN'				=> 'PBWoW es 100% gratuito. Es un proyecto hobby en el que gasto mi tiempo y dinero, solo por diversi&oacute;n. Si disfrutas usando PBWoW, por favor considera hacer una donaci&oacute;n. Lo apreciar&iacute;a mucho. Pero no est&aacute;s obligado.',


	// LEGACY CHECKS //

	'PBWOW_LEGACY_CHECK'				=> 'Prueba de Antiguedad de PBWoW',

	'PBWOW_LEGACY_CONSTANTS'			=> 'Constantes de Antiguedad de PBWoW',
	'PBWOW_LEGACY_CONSTANTS_EXPLAIN'	=> 'Si se detecta, significa que todav&iacute;a hay MODs (parciales) de PBWoW v1 o v2 activas! Esto pudiera potencialmente llevar a errores. Por ello urgimos fuertemente a desinstalar cualquier MODs (de PBWoW) activo antes de actualizar a la &uacute;ltima versi&oacute;n de phpBB. Puede hacer eso, o instalar una phpBB versi&oacute;n limpia y usar la funcionalidad de actualizar la base de datos del instalador de phpBB.',
	'PBWOW_LEGACY_DATABASE'				=> 'Base(s) de Datos Antigua(s) de PBWoW',
	'PBWOW_LEGACY_DATABASE_EXPLAIN'		=> 'La tabla de configuraci&oacute;n de PBWoW v1 o v2 todav&iacute;a est&aacute; activa. Esto no es problema, ya que PBWoW 3 no interact&uacute;a con ella. Pero puede eliminar la tabla si quiere (y no la est&aacute; usando).',

	'PBWOW_LEGACY_NONE'					=> 'No se encontr&oacute; ninguna traza obvia potencialmente problem&aacute;tica de versiones viejas de PBWoW. Esto es bueno.',


	// CONFIG //

	'PBWOW_CONFIG_TITLE'				=> 'Configuraci&oacute;n de PBWoW',
	'PBWOW_CONFIG_TITLE_EXPLAIN'		=> 'Aqu&iacute; puedes escoger algunas optiones para personalizar tu instalaci&oacute;n de PBWoW.',

	'PBWOW_LOGO'						=> 'Logotipo Personalizado',
	'PBWOW_LOGO_ENABLE'					=> 'Habilitar tu propia imagen de logotipo personalizado',
	'PBWOW_LOGO_ENABLE_EXPLAIN'			=> 'Activar esto te permitir&aacute; usar tu propio logotipo personalizado para todos los estilos instalados de PBWoW (excepto el estilo maestro de PBWoW).',
	'PBWOW_LOGO_SRC'					=> 'Ruta origen de la imagen',
	'PBWOW_LOGO_SRC_EXPLAIN'			=> 'Ruta de la imagen dentro de su directorio ra&iacute;z de phpBB, e.j. <samp>images/logotipo.png</samp>.<br />Le aconsejo encarecidamente que use una imagen PNG con el fondo transparente.',
	'PBWOW_LOGO_SIZE'					=> 'Dimensiones del logotipo',
	'PBWOW_LOGO_SIZE_EXPLAIN'			=> 'Dimensiones exactas de la imagen de su logotipo (Ancho x Alto en pixeles).<br />No se aconseja usar imagenes de mas de 350 x 200(debido al dise&ntilde;o responsivo).',
	'PBWOW_LOGO_MARGINS'				=> 'M&aacute;rgenes del logotipo',
	'PBWOW_LOGO_MARGINS_EXPLAIN'		=> 'Establece los m&aacute;rgenes CSS de su logotipo. Esto le dar&aacute; m&aacute;s control sobre el posicionamiento de su imagen. Utilice marcado CSS v&aacute;lido, e.j. <samp>10px 5px 25px 0</samp>.',

	'PBWOW_TOPBAR'						=> 'Barra de cabecera superior',
	'PBWOW_TOPBAR_ENABLE'				=> 'Habilita la barra de cabecera superior',
	'PBWOW_TOPBAR_ENABLE_EXPLAIN'		=> 'Al activar esta opci&oacute;n, una barra de 40px altamente personalizable se mostrar&aacute; en la parte superior de cada p&aacute;gina.',
	'PBWOW_TOPBAR_CODE'					=> 'C&oacute;digo de la barra de cabecera superior',
	'PBWOW_TOPBAR_CODE_EXPLAIN'			=> 'Ingrese su c&oacute;digo aqu&iacute;. Use elementos &lt;span&gt; o &lt;a class="cell"&gt; para separar bloques con bordes. Para usar iconos, use bloques &lt;img&gt; o define clases CSS especiales dentro de su hoja de estilo custom.css (mejor).',
	'PBWOW_TOPBAR_FIXED'				=> 'Fija arriba',
	'PBWOW_TOPBAR_FIXED_EXPLAIN'		=> 'Fijar la barra de cabecera superior a la parte superior de la pantalla la mantendr&aacute; visible y bloqueada en su lugar, incluso al desplazarse.<br />Esto no se aplica a los dispositivos m&oacute;viles. Se revertir&aacute; al modo por defecto (desplazante) cuando se vea en pantallas peque&ntilde;as.',

	'PBWOW_HEADERLINKS'					=> 'Enlaces Personalizados en el Cuadro del Encabezado',
	'PBWOW_HEADERLINKS_ENABLE'			=> 'Habilita los enlaces personalizados en el cuadro del encabezado',
	'PBWOW_HEADERLINKS_ENABLE_EXPLAIN'	=> 'Al activar esta opci&oacute;n, el c&oacute;digo HTML ingresado debajo se mostrar&aacute; dentro de la caja en la parte superior derecha de la pantalla (en l&iacute;nea antes de el enlace de Preguntas m&aacute;s frecuentes). Esto es &uacute;til para portales y DKP enlaces (algunos de los cuales se detectar&aacute;n autom&aacute;ticamente).',
	'PBWOW_HEADERLINKS_CODE'			=> 'C&oacute;digo de los enlaces del encabezado personalizado',
	'PBWOW_HEADERLINKS_CODE_EXPLAIN'	=> 'Ingrese sus enlaces personalizados aqu&iacute;. Estos deben envolverse en elementos &lt;li&gt;. Para utilizar los iconos, por favor defina clases CSS dentro de su hoja de estilo custom.css.',

	'PBWOW_VIDEOBG'						=> 'Configuraci&oacute;n de fondo (Video)',
	'PBWOW_VIDEOBG_ENABLE'				=> 'Habilitar fondos de v&iacute;deo animado',
	'PBWOW_VIDEOBG_ENABLE_EXPLAIN'		=> 'Algunos estilos PBWoW soportan fondos especiales de animaci&oacute;n de v&iacute;deo (no todos). Puede habilitarlos para un efecto fresco o desactivarlos para ahorrar ancho de banda (o si usted est&aacute; teniendo problemas).',
	'PBWOW_VIDEOBG_ALLPAGES'			=> '&iquest;Mostrar fondos de v&iacute;deo en todas las p&aacute;ginas?',
	'PBWOW_VIDEOBG_ALLPAGES_EXPLAIN'	=> 'Por defecto, PBWoW s&oacute;lo carga los fondos de v&iacute;deo (si est&aacute; disponible) en la p&aacute;gina <u>index.php</u>. Puede permitirlos para todas las p&aacute;ginas, pero esto puede afectar a la velocidad de navegaci&oacute;n de sus visitantes (pero no en el ancho de banda del servidor en general, debido a que se almacenan en cach&uacute; localmente). [s&oacute;lo se aplica si el v&iacute;deo est&aacute; activada]',
	'PBWOW_FIXEDBG'						=> 'Fondo fijo',
	'PBWOW_FIXEDBG_EXPLAIN'				=> 'Fijar la posici&oacute;n del fondo evitar&aacute; se desplace a lo largo con el resto del contenido. Tenga en cuenta que algunos de los dispositivos de baja resoluci&oacute;n no tendr&aacute;n ninguna opci&oacute;n de ver toda la imagen de fondo.',

	'PBWOW_AVATARS'						=> 'Avatares de Juego',
	'PBWOW_AVATARS_ENABLE'				=> 'Habilitar los avatares de juego (y los iconos) en todo el sitio',
	'PBWOW_AVATARS_ENABLE_EXPLAIN'		=> 'Si se activa, su sitio mostrar&aacute; un avatar de juego generado (basado en las entradas del perfil) si el usuario no tiene configurado ningun avatar personalizado.',
	'PBWOW_AVATARS_PATH'				=> 'Ruta de los avatares de juego',
	'PBWOW_AVATARS_PATH_EXPLAIN'		=> 'Ruta dentro de su directorio ra&iacute;z de phpBB donde se guardan los avatares de juego, e.j. <samp>images/avatars/gaming</samp>.<br />Los iconos de personajes tambi&eacute;n requieres que se configure esta ruta.',
	'PBWOW_SMALLRANKS_ENABLE'			=> 'User imagenes de rango peque&ntilde;as',
	'PBWOW_SMALLRANKS_ENABLE_EXPLAIN'	=> 'Active esto si quiere usar imagenes de rango peque&ntilde;as que se superponen al avatar (como sucede en PBWoW.com). No active esto si est&aacute; usando imagenes de rango mas grandes.',

	'PBWOW_BNET_APIKEY'					=> 'Llave de Battle.net API',
	'PBWOW_BNET_APIKEY_EXPLAIN'			=> 'Entra tu llave de juego de Battle.net API. Si no tienes, obt&eacute;n una creando una <a href="https://dev.battle.net/member/register">cuenta Mashery</a>. Si se usa un Battle.net personalizado este campo debe contener el nombre de usuario de una cuenta con permisos para extraer datos del Battle.net personalizado que se configure',
	'PBWOW_BNETCHARS'					=> 'Informaci&oacute;n de Personajes de Battle.net',
	'PBWOW_BNETCHARS_ENABLE'			=> 'Habilita la informaci&oacute;n de personajes de Battle.net API',
	'PBWOW_BNETCHARS_ENABLE_EXPLAIN'	=> 'Habilita esta funci&oacute;n para usar la API de Battle.net para obtener informaci&oacute;n de los personajes (cuando est&aacut; disponible), para usarlo los perfiles de usuario. La configuraci&oacute;n de <u>Avatars de Juego</u> debe estar habilitada para mostrar los avatares de Battle.net!',
	'PBWOW_BNETCHARS_CACHETIME'			=> 'Tiempo de vida del cach&eacute;',
	'PBWOW_BNETCHARS_CACHETIME_EXPLAIN'	=> 'Establece el tiempo de vida (en segundos) de la informaci&oacute;n de car&aacute;cter en cach&eacute; despu&eacute;s de que se ha recuperado de la API de Battle.net. Puede cambiar esto para actualizar la informaci&oacute;n de car&aacute;cter con m&aacute;s o menos frecuencia. 86400 = 24h',
	'PBWOW_BNETCHARS_TIMEOUT'			=> 'Tiempo de espera de la consulta a la API',
	'PBWOW_BNETCHARS_TIMEOUT_EXPLAIN'	=> 'Establece el intervalo de tiempo de espera (en segundos) de las solicitudes del API Battle.net. B&aacute;sicamente significa el tiempo m&aacute;ximo que el script esperar&aacute; a que Battle.net responda. Aum&eacute;ntelo si cree que los datos (correcto) no se reciben a tiempo, pero el tiempo carga de la p&aacute;gina puede aumentar!',

	'PBWOW_ADS_INDEX'					=> 'Bloque de Publicidad del &Iacute;ndice',
	'PBWOW_ADS_INDEX_ENABLE'			=> 'Habilitar la publicidad del &iacute;ndice',
	'PBWOW_ADS_INDEX_ENABLE_EXPLAIN'	=> 'Activar este ad generar&aacute; bloque estrecho de anuncios en la p&aacute;gina de &iacute;ndice del foro (requiere la extensi&oacute;n Recent Topics).',
	'PBWOW_ADS_INDEX_CODE'				=> 'C&oacute;digo de publicidad del &iacute;ndice',
	'PBWOW_ADS_INDEX_CODE_EXPLAIN'		=> 'Este bloque es adecuado para anuncios con <u>ancho</u> de: <b>300px</b>.<br />Si quiere usar/cambiar el estilo personalizado, por favor agr&eacute;guelo a <samp>styles/pbwow3/theme/custom.css</samp>',
	
));
