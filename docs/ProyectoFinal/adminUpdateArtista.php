<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Actualizar Artistas';
$artistas = es\ucm\fdi\aw\Artista\Artista::buscaArtistas();
if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}

if(isset($_POST['update'])){
    if(isset($_POST['id'])){
        $nuevo = es\ucm\fdi\aw\Artista\Artista::buscaPorId($_POST['id']);   
    }
    if(isset($_POST['nombre'])){
        $nuevo->nombre = $_POST['nombre'];
        es\ucm\fdi\aw\Artista\Artista::actualizaNombreAdmin($_POST['nombre'],$_POST['id']);
        es\ucm\fdi\aw\Vinilo\Vinilo::actualizaNombreArtistaAdmin($_POST['nombre'],$_POST['id']);
    }    
}

$contenidoPrincipal = '<h2>Lista de Artistas</h2>';
$contenidoPrincipal .= '<p>Selecciona el artista que quieres actualizar</p>';

$contenidoPrincipal .= '<form method="post">';

foreach($artistas as $artista){
    $contenidoPrincipal .= '<input type="radio" id="'.$artista->id.'" name="artista" value="'.$artista->id.'">';
    $contenidoPrincipal .= '<label for="'.$artista->id.'">'. $artista->nombre .'</label>';
}
$contenidoPrincipal .= '<br><input type="submit" id="sel" name="boton" value="Aceptar" >';
$contenidoPrincipal .= '</form>';

if(isset($_POST['boton'])){
    $nuevo = es\ucm\fdi\aw\Artista\Artista::buscaPorId($_POST['artista']);
    $contenidoPrincipal = <<<EOS
            <h1>$nuevo->nombre</h1>
            <form method="post">
                <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required minlength="1" size="15">
                </div>
                <input type="hidden" name="id" value="{$nuevo->id}">
                <div>
                <input type="submit" name="update" value="Aceptar">
                </div>
                
            </form>
    EOS;
}


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
?>