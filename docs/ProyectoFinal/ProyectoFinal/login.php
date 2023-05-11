<?php

require_once __DIR__.'/includes/config.php';


$tituloPagina = 'Login';

$htmlFormLogin = buildFormularioLogin();
$logado = estaLogado();
$saludo=saludo();
if ($logado){
    $contenidoPrincipal=<<<EOS
    <h1>Acceso al sistema</h1>
    $saludo
    EOS;
}
else {
    $contenidoPrincipal=<<<EOS
    <h1>Acceso al sistema</h1>
    $htmlFormLogin
    EOS;
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);