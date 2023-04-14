<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/artistas.php';
require_once 'includes/vistas/helpers/eventos.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$tituloPagina = 'Tu Perfil';

if (! estaLogado()) {
    Utils::paginaError(403, $tituloPagina, 'Usuario no conectado!', 'Debes iniciar sesión para ver el contenido.');
}

$user = $_SESSION['username'];

$artistas = Seguir::buscaSeguidos($user);
$a = [];
$eventos = [];
foreach($artistas as $artista){
    $a[] = Artista::buscaPorId($artista);
    $aux = Evento::buscaPorArtista($artista);
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

require 'includes/vistas/comun/layout.php';

?>