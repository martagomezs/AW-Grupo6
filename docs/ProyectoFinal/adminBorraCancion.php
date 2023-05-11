<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Borra Canción';
if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}

$canciones = es\ucm\fdi\aw\Vinilo\Cancion::buscaCanciones();

if(isset($_POST['boton'])){
    foreach($canciones as $cancion){
        if(isset($_POST[$cancion->id])){
            if(es\ucm\fdi\aw\Vinilo\Cancion::borraPorId($cancion->id)){
                echo '<script>alert("Se ha borrado con éxito.")</script>';
            }
        }
    }
    $canciones = es\ucm\fdi\aw\Vinilo\Cancion::buscaCanciones();
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


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
?>