<?php
/* */
/* Parámetros de configuración de la aplicación */
/* */

// Parámetros de configuración generales
define('RUTA_APP', __DIR__);
define('RUTA_IMGS', RUTA_APP . '/img');
define('RUTA_CSS', RUTA_APP . '/css');
define('RUTA_JS', RUTA_APP . '/js');
define('RUTA_SRC', RUTA_APP . '/src');
define('INSTALADA', true);

// Parámetros de configuración de la BD
define('BD_HOST', 'localhost');
//define('BD_HOST', 'vm05.db.swarm.test');
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
require_once RUTA_SRC . '/BD.php';
require_once RUTA_SRC . '/usuarios/bd/Usuario.php';
require_once RUTA_SRC . '/vinilos/Vinilos.php';
require_once RUTA_SRC . '/vinilos/Canciones.php';
require_once RUTA_SRC . '/Artistas/artistas.php';
require_once RUTA_SRC . '/Eventos/Eventos.php';
require_once RUTA_SRC . '/Compras/Compras.php';
require_once RUTA_SRC . '/Seguidos/Seguidos.php';
