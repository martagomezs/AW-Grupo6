<?php
/* */
/* Parámetros de configuración de la aplicación */
/* */

// Parámetros de configuración generales
define('RUTA_APP', '/AW-Grupo6/docs/Practica3');
define('RUTA_IMGS', RUTA_APP . '/img');
define('RUTA_CSS', RUTA_APP . '/css');
define('RUTA_JS', RUTA_APP . '/js');
define('INSTALADA', true);

// Parámetros de configuración de la BD
define('BD_HOST', 'localhost');
// zsdefine('BD_HOST', 'vm05.db.swarm.test');
define('BD_NAME', 'beatstore');
define('BD_USER', 'usuario');
define('BD_PASS', 'userpass');

/* */
/* Utilidades básicas de la aplicación */
/* */

require_once __DIR__.'/src/Utils.php';

/* */
/* Inicialización de la aplicación */
/* */

if (!INSTALADA) {
	Utils::paginaError(502, 'Error', 'Oops', 'La aplicación no está configurada. Tienes que modificar el fichero config.php');
}

/* */
/* Configuración de Codificación y timezone */
/* */

ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

/* */
/* Clases y Traits de la aplicación */
/* */
require_once 'src/Arrays.php';
require_once 'src/traits/MagicProperties.php';

/* */
/* Clases que simulan una BD almacenando los datos en memoria */
/*
require_once 'src/usuarios/memoria/Usuario.php';
require_once 'src/mensajes/memoria/Mensaje.php';
*/

/*
 * Configuramos e inicializamos la sesión para todas las peticiones
 */
session_start([
	'cookie_path' => RUTA_APP, // Para evitar problemas si tenemos varias aplicaciones en htdocs
]);

/* */
/* Inicialización de las clases que simulan una BD en memoria */
/*
Usuario::init();
Mensaje::init();
*/

/* */
/* Clases que usan una BD para almacenar el estado */
/* */
require_once 'src/BD.php';
require_once 'src/usuarios/bd/Usuario.php';
require_once 'src/Vinilos/vinilos.php';
require_once 'src/Vinilos/canciones.php';
require_once 'src/Artistas/artistas.php';
require_once 'src/Eventos/Eventos.php';
require_once 'src/Compras/Compras.php';
require_once 'src/Seguidos/Seguidos.php';
