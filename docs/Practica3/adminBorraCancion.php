<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$tituloPagina = 'Borra Canción';
if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}

$canciones = Cancion::buscaCanciones();

if(isset($_POST['boton'])){
    foreach($canciones as $cancion){
        if(isset($_POST[$cancion->id])){
            if(Cancion::borraPorId($cancion->id)){
                echo '<script>alert("Se ha borrado con éxito.")</script>';
            }
        }
    }
    $canciones = Cancion::buscaCanciones();
}



$contenidoPrincipal = '<h2>Lista de Canciones</h2>';
$contenidoPrincipal .= '<p>Selecciona las canciones que quieres eliminar</p>';
$contenidoPrincipal .= '<form method="post">';

foreach($canciones as $cancion){
    $contenidoPrincipal .= '<div>';
        $contenidoPrincipal .= '<input type="checkbox" id="' . $cancion->id . '" name="' . $cancion->id . '" value="' . $cancion->id . '">';
        $contenidoPrincipal .= '<label for="' . $cancion->id . '">' . $cancion->titulo. '</label>';
    $contenidoPrincipal .= '</div>';
}

$contenidoPrincipal .= '<input type="submit" name="boton" value="Borrar" >';

$contenidoPrincipal .= '</form>';


require 'includes/vistas/comun/layout.php';
?>