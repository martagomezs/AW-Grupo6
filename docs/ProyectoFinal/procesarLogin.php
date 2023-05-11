<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Login';

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$password = $_POST["password"] ?? null;
$loged = es\ucm\fdi\aw\Usuario\Usuario::login($username, $password);
$usuario = es\ucm\fdi\aw\Usuario\Usuario::buscaUsuario($username);
if (!$loged) {
	$htmlFormLogin = buildFormularioLogin($username, $password);
	$contenidoPrincipal=<<<EOS
		<h1>Error</h1>
		<p>El usuario o contraseña no son válidos.</p>
		$htmlFormLogin
	EOS;
	require 'includes/vistas/comun/layout.php';
	exit();
}

$app->login($usuario);

if($_SESSION['rol'] == "usuario"){
	$contenidoPrincipal=<<<EOS
		<h1>Bienvenido ${_SESSION['nombre']}</h1>
		<p>Usa el menú superior para navegar.</p>
	EOS;
}
else if($_SESSION['rol'] == "admin"){
	$contenidoPrincipal=<<<EOS
		<h1>Bienvenido ${_SESSION['nombre']}</h1>
		<p>Selecciona en el menú superior lo que quieras gestionar.</p>
	EOS;
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
