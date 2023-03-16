<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$tituloPagina = 'Cesta';

// if (! estaLogado()) {
// 	Utils::paginaError(403, $tituloPagina, 'Usuario no conectado!', 'Debes iniciar sesión para ver el contenido.');
// }

$contenidoPrincipal=<<<EOS
	<h1>Cesta</h1>
	<p> Esta es tu cesta de la compra </p>
EOS;

require 'includes/vistas/comun/layout.php';
