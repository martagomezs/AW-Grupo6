<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Tu Perfil';

if (!$app->usuarioLogueado()) {
    Utils::paginaError(403, $tituloPagina, 'Usuario no conectado!', 'Debes iniciar sesión para ver el contenido.');
}
else{
	$user = $_SESSION['username'];

	$artistas = es\ucm\fdi\aw\Seguir\Seguir::buscaSeguidos($user);
	$a = [];
	$eventos = [];
	foreach($artistas as $artista){
		$a[] = es\ucm\fdi\aw\Artista\Artista::buscaPorId($artista);
		$aux = es\ucm\fdi\aw\Evento\Evento::buscaPorArtista($artista);
		$eventos = array_merge($eventos, $aux);
	}
	$contenidoPrincipal=<<<EOS
		<h1 class="titulo">Perfil</h1>
	EOS;

	$contenidoPrincipal .= '<h2>Artistas seguidos</h2>';
	$contenidoPrincipal .= listaArtistas($a);

	$mes = 1;
	$year = 2023;
	$contenidoPrincipal .= '<h2>Eventos</h2>';
	$contenidoPrincipal .= calendario($eventos);
	$contenidoPrincipal .= 
			'<form method="post">
				<label for="mes">Mes:</label>
				<input type="number" id="mes" name="mes" min="1" max="12" value= ' . $mes . '>
				<label for="año">Año:</label>
				<input type="number" id="año" name="año" min="2023" value=' . $year . '>
				<button type="submit">Aceptar</button>
			</form>';
}


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);

?>