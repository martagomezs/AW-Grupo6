<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$tituloPagina = 'Ofertas';

$contenidoPrincipal=<<<EOS
	<h1 class="titulo">Ofertas</h1>
	<p> Aquí van las ofertas</p>
EOS;

require 'includes/vistas/comun/layout.php';
