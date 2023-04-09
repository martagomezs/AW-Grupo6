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

$artistas = Artista::buscaSeguidos($user);
$a = [];
$eventos = [];
foreach($artistas as $artista){
    $a[] = Artista::buscaPorId($artista);
    $aux = Evento::buscaPorArtista($artista);
    $eventos = array_merge($eventos, $aux);
}

$contenidoPrincipal = '<p>Artistas seguidos</p>';
$contenidoPrincipal .= listaArtistas($a);

$contenidoPrincipal .= '<p>Eventos</p>';
$contenidoPrincipal .= calendario($eventos);

?>