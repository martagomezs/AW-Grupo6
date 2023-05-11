<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Registro';

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$password = $_POST["password"] ?? null;
$name = $_POST["name"];
$mail = $_POST["mail"];

$esValido = \es\ucm\fdi\aw\Usuario\Usuario::buscaUsuario($username);
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

$user = \es\ucm\fdi\aw\Usuario\Usuario::crea($username,$password,$name,$mail);


$app->login($user);

$contenidoPrincipal=<<<EOS
	<h1>Bienvenido ${_SESSION['nombre']}</h1>
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
