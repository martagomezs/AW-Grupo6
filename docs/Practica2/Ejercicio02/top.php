<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$tituloPagina = 'Top Ventas';

// if (! estaLogado()) {
// 	Utils::paginaError(403, $tituloPagina, 'Usuario no conectado!', 'Debes iniciar sesión para ver el contenido.');
// }

$contenidoPrincipal=<<<EOS
	<h1>Top Ventas</h1>
	<p> Aquí van el Top Ventas y el Top Artistas</p>
EOS;

require 'includes/vistas/comun/layout.php';
