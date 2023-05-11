<?php
require_once __DIR__.'/includes/config.php';


$tituloPagina = 'Registro';

$htmlFormReg = buildFormularioRegistro();
$contenidoPrincipal=<<<EOS
<h1>Acceso al sistema</h1>
$htmlFormReg
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);