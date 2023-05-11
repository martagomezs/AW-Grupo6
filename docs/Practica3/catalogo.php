<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/vinilos.php';

$tituloPagina = 'Catálogo';

$contenidoPrincipal=<<<EOS
	<h1 class="titulo">Catálogo</h1>
EOS;

$contenidoPrincipal .= listaVinilos();

require 'includes/vistas/comun/layout.php';
