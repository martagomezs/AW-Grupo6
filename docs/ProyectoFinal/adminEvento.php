<?php
require_once __DIR__.'/includes/config.php';

if (isset($_POST['option'])) {
    if ($_POST['option'] == 'Borra') {
        header('Location: adminBorraEvento.php');
        exit;
    } elseif ($_POST['option'] == 'Inserta') {
        header('Location: adminCreaEvento.php');
        exit;
    }
}

$tituloPagina = 'Aministrar Eventos';
$artistas = es\ucm\fdi\aw\Artista\Artista::buscaArtistas();
if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}

$contenidoPrincipal = '<h1>Gestión de eventos</h1>';

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