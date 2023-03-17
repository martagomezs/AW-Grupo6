<?php

require_once '../includes/config.php';
require_once '../includes/vistas/helpers/artistas.php';

$idArtista =  filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if(!$idArtista){
    Utils::redirige(Utils::buildUrl('/top.php'));
}

$artista = Artista::buscaPorId($idArtista);
if(!$artista){
    Utils::redirige(Utils::buildUrl('/top.php'));
}

$contenidoPrincipal = listaArtistas();

require '../includes/vistas/comun/layout.php';

?>