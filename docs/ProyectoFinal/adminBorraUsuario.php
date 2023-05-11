<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Borra Usuarios';
if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}

$users = es\ucm\fdi\aw\Usuario\Usuario::buscaUsuarios();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    foreach($users as $user){
        if(isset($_POST[$user->username])){
            if(es\ucm\fdi\aw\Usuario\Usuario::borra($user)){
                echo '<script>alert("Usuario eliminados con éxito.")</script>';
            }
        }
    }
    $users = es\ucm\fdi\aw\Usuario\Usuario::buscaUsuarios();
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

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
?>