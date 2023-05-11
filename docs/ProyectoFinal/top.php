<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Top';

$artistas = es\ucm\fdi\aw\Artista\Artista::buscaArtistas();

$contenidoPrincipal=<<<EOS
	<h1 class="titulo">TOP</h1>
EOS;

$contenidoPrincipal .= '<h2>Top Vinilos</h2>';
$contenidoPrincipal .= listaVinilos();
$contenidoPrincipal .= '<h2>Top Artistas</h2>';
$contenidoPrincipal .= listaArtistas($artistas);
	

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
