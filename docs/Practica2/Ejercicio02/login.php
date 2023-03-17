<?php
session_start();

require_once 'includes/config.php';
require_once 'includes/vistas/helpers/login.php';
require_once 'includes/vistas/helpers/usuarios.php';


$tituloPagina = 'Login';

$htmlFormLogin = buildFormularioLogin();
$saludo=saludo();
$contenidoPrincipal=<<<EOS
<h1>Acceso al sistema</h1>
$saludo
$htmlFormLogin
EOS;

require 'includes/vistas/comun/layout.php';
