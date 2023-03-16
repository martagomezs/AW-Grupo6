<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$tituloPagina = 'Catálogo';

// if (! estaLogado()) {
// 	Utils::paginaError(403, $tituloPagina, 'Usuario no conectado!', 'Debes iniciar sesión para ver el contenido.');
// }

$contenidoPrincipal=<<<EOS
	<h1>Catálogo</h1>
	<p> Aquí va el catálogo</p>
EOS;

require 'includes/vistas/comun/layout.php';
