<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Crear Canciones';

if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}


if(isset($_POST['create'])){
    $idVinilo = $_POST['vinilo'];
    $titulo = $_POST['titulo'];
    $audio = 'audio/prueba-audio.mp3';
    if (es\ucm\fdi\aw\Vinilo\Cancion::insertaAdmin($idVinilo, $titulo , $audio)){
        echo '<script>alert("Cancion creada con éxito.")</script>';
    }
}

$vinilos = es\ucm\fdi\aw\Vinilo\Vinilo::buscaVinilos();

$contenidoPrincipal = '<h2>Crea Nueva Canción</h2>';

$contenidoPrincipal .= '<h2> Nueva canción </h2>';

$contenidoPrincipal .= '<form method="post">';

foreach($vinilos as $vinilo){
    $contenidoPrincipal .= '<input type="radio" id="'.$vinilo->id.'" name="vinilo" value="'.$vinilo->id.'" required>';
    $contenidoPrincipal .= '<label for="'.$vinilo->id.'">'. $vinilo->titulo .'</label>';
}

$contenidoPrincipal .= '
            <div>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required size="50">
            </div>
            <div>
            <input type="submit" name="create" value="Aceptar">
            </div>
        </form>';


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
?>