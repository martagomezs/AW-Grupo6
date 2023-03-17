<?php

require_once 'includes/config.php';
require_once 'includes/vistas/helpers/usuarios.php';
require_once 'includes/vistas/helpers/autorizacion.php';
require_once 'includes/vistas/helpers/registro.php';

$tituloPagina = 'Registro';

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$password = $_POST["password"] ?? null;
$name = $_POST["name"];
$mail = $_POST["mail"];

$esValido = $username && $password;
if (!$esValido) {
	$htmlFormLogin = buildFormularioLogin($username, $password);
	$contenidoPrincipal=<<<EOS
		<h1>Error</h1>
		<p>El usuario o contraseña no son válidos.</p>
		$htmlFormLogin
	EOS;
	require 'includes/vistas/comun/layout.php';
	exit();
}

Usuario::crea($username,$password,$name,$mail);

$_SESSION['idUsuario'] = $username;
//$_SESSION['roles'] = $usuario->roles;
$_SESSION['nombre'] = $name;

$contenidoPrincipal=<<<EOS
	<h1>Bienvenido ${_SESSION['nombre']}</h1>
	<p>Usa el menú de la izquierda para navegar.</p>
EOS;

require 'includes/vistas/comun/layout.php';
