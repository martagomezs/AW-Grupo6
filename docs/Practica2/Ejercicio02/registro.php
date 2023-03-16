<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/registro.php';


$tituloPagina = 'Registro';

$htmlFormReg = buildFormularioRegistro();
$contenidoPrincipal=<<<EOS
<h1>Acceso al sistema</h1>
$htmlFormReg
EOS;

require 'includes/vistas/comun/layout.php';