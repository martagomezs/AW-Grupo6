<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/artistas.php';
require_once 'includes/vistas/helpers/vinilos.php';

$tituloPagina = 'Top';

$contenidoPrincipal = '<h1>Top Vinilos</h1>';
$contenidoPrincipal .= listaVinilos();/*
$contenidoPrincipal .= '<h1>Top Artistas</h1>';
$contenidoPrincipal .= listaArtistas();*/
	

require 'includes/vistas/comun/layout.php';
