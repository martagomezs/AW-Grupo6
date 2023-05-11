<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Borra Vinilos';
if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}

$vinilos = es\ucm\fdi\aw\Vinilo\Vinilo::buscaVinilos();

if(isset($_POST['boton'])){
    foreach($vinilos as $vinilo){
        if(isset($_POST[$vinilo->id])){
            if(es\ucm\fdi\aw\Vinilo\Vinilo::borraPorId($vinilo->id)){
                echo '<script>alert("Se ha borrado con éxito.")</script>';
            }
        }
    }
    $vinilos = es\ucm\fdi\aw\Vinilo\Vinilo::buscaVinilos();
}



$contenidoPrincipal = '<h2>Lista de Vinilos</h2>';
$contenidoPrincipal .= '<p>Selecciona los vinilos que quieres eliminiar</p>';
$contenidoPrincipal .= '<form method="post">';

foreach($vinilos as $vinilo){
    $contenidoPrincipal .= '<div>';
        $contenidoPrincipal .= '<input type="checkbox" id="' . $vinilo->id . '" name="' . $vinilo->id . '" value="' . $vinilo->id . '">';
        $contenidoPrincipal .= '<label for="' . $vinilo->id . '">' . $vinilo->titulo . '</label>';
    $contenidoPrincipal .= '</div>';
}

$contenidoPrincipal .= '<input type="submit" name="boton" value="Borrar" >';

$contenidoPrincipal .= '</form>';


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
?>