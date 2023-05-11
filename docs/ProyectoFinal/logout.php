<?php
require_once __DIR__.'/includes/config.php';

logout();

$tituloPagina = 'Logout';

$contenidoPrincipal=<<<EOS
	<h1>¡Hasta pronto!</h1>
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
