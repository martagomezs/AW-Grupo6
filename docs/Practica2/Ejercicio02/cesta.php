<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/vinilos.php';

$tituloPagina = 'Cesta';

// if (! estaLogado()) {
// 	Utils::paginaError(403, $tituloPagina, 'Usuario no conectado!', 'Debes iniciar sesión para ver el contenido.');
// }

$ids[] = $_POST['id'];

if($ids != null){
	foreach($ids as $id){
		$vinilos[] = Vinilo::buscaPorId($id);
	}
}


$contenidoPrincipal=<<<EOS
	<h1>Cesta</h1>
EOS;

foreach($vinilos as $vinilo){
	$contenidoPrincipal .= visualizaVinilo($vinilo);
}

$contenidoPrincipal .=<<<EOS
<input type="button" name="Comprar" value="Comprar">
EOS;

require 'includes/vistas/comun/layout.php';
