<?php
require_once __DIR__.'/includes/config.php';

if (isset($_POST['option'])) {
    if ($_POST['option'] == 'Borra') {
        header('Location: adminBorraUsuario.php');
        exit;
    } elseif ($_POST['option'] == 'Actualiza') {
        header('Location: adminUpdateUsuario.php');
        exit;
    } elseif ($_POST['option'] == 'Inserta') {
        header('Location: adminCreaUsuario.php');
        exit;
    }
}

$tituloPagina = 'Aministrar Usuarios';
$users = es\ucm\fdi\aw\Usuario\Usuario::buscaUsuarios();
if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}

$contenidoPrincipal = '<h1>Gestión de usuarios</h1>';

$contenidoPrincipal .= '<p>Seleccione qué quiere hacer:</p>';

$contenidoPrincipal .= '<form method="post">';

$contenidoPrincipal .= '<input type="radio" id="delete" name="option" value="Borra">';
$contenidoPrincipal .= '<label for="delete">Borrar</label>';

$contenidoPrincipal .= '<input type="radio" id="update" name="option" value="Actualiza">';
$contenidoPrincipal .= '<label for="update">Actualizar</label>';

$contenidoPrincipal .= '<input type="radio" id="insert" name="option" value="Inserta">';
$contenidoPrincipal .= '<label for="insert">Crear</label>';

$contenidoPrincipal .= '<br><input type="submit" value="Aceptar" >';

$contenidoPrincipal .= '</form>';

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
?>