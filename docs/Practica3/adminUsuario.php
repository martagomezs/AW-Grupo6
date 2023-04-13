<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$tituloPagina = 'Administrar Usuarios';

if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}

$users = Usuario::buscaUsuarios();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    foreach($users as $user){
        if(isset($_POST[$user->username])){
            Usuario::borra($user);
        }
    }
    $users = Usuario::buscaUsuarios();
}

$contenidoPrincipal = '<h1>Lista de Usuarios</h1>';
$contenidoPrincipal .= '<p>Selecciona los usuarios que quieres eliminar</p>';

$contenidoPrincipal .= '<form method="post">';

foreach($users as $user){
    $contenidoPrincipal .= '<div>';
        $contenidoPrincipal .= '<input type="checkbox" id="' . $user->username . '" name="' . $user->username . '">';
        $contenidoPrincipal .= '<label for="' . $user->username . '">' . $user->username . '</label>';
    $contenidoPrincipal .= '</div>';
}

$contenidoPrincipal .= '<input type="submit" value="Borrar" >';

$contenidoPrincipal .= '</form>';

require 'includes/vistas/comun/layout.php';
?>