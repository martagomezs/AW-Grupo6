<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$tituloPagina = 'Borra Vinilos';
if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}

$vinilos = Vinilo::buscaVinilos();

if(isset($_POST['boton'])){
    foreach($vinilos as $vinilo){
        if(isset($_POST[$vinilo->id])){
            if(Vinilo::borraPorId($vinilo->id)){
                echo '<script>alert("Se ha borrado con éxito.")</script>';
            }
        }
    }
    $vinilos = Vinilo::buscaVinilos();
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


require 'includes/vistas/comun/layout.php';
?>