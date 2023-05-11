<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Borra Artistas';
if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}

$artistas = es\ucm\fdi\aw\Artista\Artista::buscaArtistas();

if(isset($_POST['boton'])){
    foreach($artistas as $artista){
        if(isset($_POST[$artista->id])){
            if(es\ucm\fdi\aw\Artista\Artista::borraPorId($artista->id)){
                echo '<script>alert("Se ha borrado con éxito.")</script>';
            }
        }
    }
    $artistas = es\ucm\fdi\aw\Artista\Artista::buscaArtistas();
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


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
?>