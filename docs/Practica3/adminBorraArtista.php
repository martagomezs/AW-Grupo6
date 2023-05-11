<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$tituloPagina = 'Borra Artistas';
if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}

$artistas = Artista::buscaArtistas();

if(isset($_POST['boton'])){
    foreach($artistas as $artista){
        if(isset($_POST[$artista->id])){
            if(Artista::borraPorId($artista->id)){
                echo '<script>alert("Se ha borrado con éxito.")</script>';
            }
        }
    }
    $artistas = Artista::buscaArtistas();
}



$contenidoPrincipal = '<h2>Lista de Artistas</h2>';
$contenidoPrincipal .= '<p>Selecciona los artistas que quieres eliminar</p>';
$contenidoPrincipal .= '<form method="post">';

foreach($artistas as $artista){
    $contenidoPrincipal .= '<div>';
        $contenidoPrincipal .= '<input type="checkbox" id="' . $artista->id . '" name="' . $artista->id . '" value="' . $artista->id . '">';
        $contenidoPrincipal .= '<label for="' . $artista->id . '">' . $artista->nombre . '</label>';
    $contenidoPrincipal .= '</div>';
}

$contenidoPrincipal .= '<input type="submit" name="boton" value="Borrar" >';

$contenidoPrincipal .= '</form>';


require 'includes/vistas/comun/layout.php';
?>