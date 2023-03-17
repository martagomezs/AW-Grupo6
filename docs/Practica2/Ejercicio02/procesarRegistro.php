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

$esValido = Usuario::buscaUsuario($username);
if ($esValido) {
	$htmlFormLogin = buildFormularioRegistro($username, $name, $mail, $password);
	$contenidoPrincipal=<<<EOS
		<h1>Error</h1>
		<p>Existe otro usuario con ese nombre de usuario</p>
		$htmlFormLogin
	EOS;
	require 'includes/vistas/comun/layout.php';
	exit();
}

$insert = Usuario::crea($username,$password,$name,$mail);


$_SESSION['idUsuario'] = $username;
//$_SESSION['roles'] = $usuario->roles;
$_SESSION['nombre'] = $name;

$contenidoPrincipal=<<<EOS
	<h1>Bienvenido ${_SESSION['nombre']}</h1>
EOS;

require 'includes/vistas/comun/layout.php';
