<?php
require_once __DIR__.'/includes/config.php';

if (isset($_POST['option'])) {
    if ($_POST['option'] == 'Borra') {
        header('Location: adminBorraCancion.php');
        exit;
    } elseif ($_POST['option'] == 'Inserta') {
        header('Location: adminCreaCancion.php');
        exit;
    }
}

$tituloPagina = 'Aministrar Canciones';
if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}

$contenidoPrincipal = '<h1>Gestión de canciones</h1>';

$contenidoPrincipal .= '<p>Seleccione qué quiere hacer:</p>';

$contenidoPrincipal .= '<form method="post">';

$contenidoPrincipal .= '<input type="radio" id="delete" name="option" value="Borra">';
$contenidoPrincipal .= '<label for="delete">Borrar</label>';

$contenidoPrincipal .= '<input type="radio" id="insert" name="option" value="Inserta">';
$contenidoPrincipal .= '<label for="insert">Crear</label>';

$contenidoPrincipal .= '<br><input type="submit" value="Aceptar" >';

$contenidoPrincipal .= '</form>';

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
?>