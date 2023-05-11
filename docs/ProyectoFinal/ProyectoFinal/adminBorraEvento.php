<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Borra Evento';
if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}

$eventos = es\ucm\fdi\aw\Evento\Evento::buscaEventos();

if(isset($_POST['boton'])){
    foreach($eventos as $evento){
        if(isset($_POST[$evento->id])){
            if(es\ucm\fdi\aw\Evento\Evento::borraPorId($evento->id)){
                echo '<script>alert("Se ha borrado con éxito.")</script>';
            }
        }
    }
    $eventos = es\ucm\fdi\aw\Evento\Evento::buscaEventos();
}



$contenidoPrincipal = '<h2>Lista de Eventos</h2>';
$contenidoPrincipal .= '<p>Selecciona los eventos que quieres eliminar</p>';
$contenidoPrincipal .= '<form method="post">';

foreach($eventos as $evento){
    $contenidoPrincipal .= '<div>';
        $contenidoPrincipal .= '<input type="checkbox" id="' . $evento->id . '" name="' . $evento->id . '" value="' . $evento->id . '">';
        $contenidoPrincipal .= '<label for="' . $evento->id . '">' . $evento->fecha. '- Tipo:' .$evento->tipo. '- IdArtista:' .$evento->idArtista.'</label>';
    $contenidoPrincipal .= '</div>';
}

$contenidoPrincipal .= '<input type="submit" name="boton" value="Borrar" >';

$contenidoPrincipal .= '</form>';


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
?>