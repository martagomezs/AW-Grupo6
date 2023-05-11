<?php
/* */
/* Parámetros de configuración de la aplicación */
/* */


// Parámetros de configuración de la BD
//define('BD_HOST', 'localhost');
define('BD_HOST', 'vm05.db.swarm.test');
define('BD_NAME', 'beatstore');
define('BD_USER', 'usuario');
define('BD_PASS', 'userpass');

// Parámetros de configuración generales
define('RAIZ_APP', __DIR__);
define('RUTA_APP', '/AW-Grupo6/docs/ProyectoFinal');
define('RUTA_IMGS', RUTA_APP.'img/');
define('RUTA_CSS', RUTA_APP.'css/');
define('RUTA_AUDIO', RUTA_APP.'audio/');


/* */
/* Configuración de Codificación y timezone */
/* */

ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');


//Función para autocargar clases PHP.

spl_autoload_register(function ($class) {

	$prefix = 'es\\ucm\\fdi\\aw\\';

	$base_dir = implode(DIRECTORY_SEPARATOR, [__DIR__,'src', '']);

	$len= strlen($prefix);
	if(strncmp($prefix, $class, $len) !== 0);

	$relative_class = substr($class, $len);

	$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

	if(file_exists($file)){
		require $file;
	}
});


/* */
/* Inicialización de la aplicación */
/* */
define('INSTALADA', true);

$app = \es\ucm\fdi\aw\Aplicacion::getInstance();
$app->init(array('host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS), RUTA_APP, RAIZ_APP);

if (!INSTALADA) {
	$app->paginaError(502, 'Error', 'Oops', 'La aplicación no está configurada. Tienes que modificar el fichero config.php');
}

register_shutdown_function(array($app, 'shutdown'));

/* */
/* Utilidades básicas de la aplicación */
/* */

require_once __DIR__.'/src/Utils.php';
require_once __DIR__.'/src/Arrays.php';
require_once __DIR__.'/vistas/helpers/artistas.php';
require_once __DIR__.'/vistas/helpers/comentarios.php';
require_once __DIR__.'/vistas/helpers/compras.php';
require_once __DIR__.'/vistas/helpers/eventos.php';
require_once __DIR__.'/vistas/helpers/login.php';
require_once __DIR__.'/vistas/helpers/registro.php';
require_once __DIR__.'/vistas/helpers/usuarios.php';
require_once __DIR__.'/vistas/helpers/vinilos.php';
