<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/vinilos.php';
require_once 'includes/vistas/helpers/compras.php';

$tituloPagina = 'Cesta';

/*if (! estaLogado()) {
 	Utils::paginaError(403, $tituloPagina, 'Usuario no conectado!', 'Debes iniciar sesión para ver el contenido.');
}*/

$contenidoPrincipal=<<<EOS
	<h1>Cesta</h1>
EOS;

$contenidoPrincipal .= visualizaCesta($_SESSION['username']);

$contenidoPrincipal .=<<<EOS
<input type="button" name="Comprar" value="Comprar">
EOS;


require 'includes/vistas/comun/layout.php';
