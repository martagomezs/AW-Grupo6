<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/artistas.php';
require_once 'includes/vistas/helpers/vinilos.php';

$tituloPagina = 'Top';

$artistas = Artista::buscaArtistas();

$contenidoPrincipal=<<<EOS
	<h1 class="titulo">TOP</h1>
EOS;

$contenidoPrincipal .= '<h2>Top Vinilos</h2>';
$contenidoPrincipal .= listaVinilos();
$contenidoPrincipal .= '<h2>Top Artistas</h2>';
$contenidoPrincipal .= listaArtistas($artistas);
	

require 'includes/vistas/comun/layout.php';
