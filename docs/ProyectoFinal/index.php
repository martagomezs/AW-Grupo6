<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Catálogo';

$contenidoPrincipal=<<<EOS
<h1 class="titulo">Catálogo</h1>
EOS;

$contenidoPrincipal .= listaVinilos();

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);

?>