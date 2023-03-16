<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$tituloPagina = 'Ofertas';

// if (! estaLogado()) {
// 	Utils::paginaError(403, $tituloPagina, 'Usuario no conectado!', 'Debes iniciar sesión para ver el contenido.');
// }

$contenidoPrincipal=<<<EOS
	<h1>Ofertas</h1>
	<p> Aquí van las ofertas</p>
EOS;

require 'includes/vistas/comun/layout.php';
