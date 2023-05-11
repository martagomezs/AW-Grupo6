<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Crear Eventos';

if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}



if(isset($_POST['create'])){
    $fecha = $_POST['fecha'];
    $tipo = $_POST['tipo'];
    $idArtista = $_POST['artista'];
    $descripcion = $_POST['descripcion'];
    echo "Valor de tipo_contenido: " . $tipo;
    if (es\ucm\fdi\aw\Evento\Evento::insertaAdmin($fecha, $tipo , $idArtista, $descripcion)){
        echo '<script>alert("Evento creado con éxito.")</script>';
    }
}

$artistas = es\ucm\fdi\aw\Artista\Artista::buscaArtistas();

$contenidoPrincipal = '<h2>Crea Nuevo Evento</h2>';

$contenidoPrincipal .= '
        <h2> Nuevo evento </h2>
        <form method="post">
            <div>
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" requiered>
            </div>';

foreach($artistas as $artista){
    $contenidoPrincipal .= '<input type="radio" id="'.$artista->id.'" name="artista" value="'.$artista->id.'" required>';
    $contenidoPrincipal .= '<label for="'.$artista->id.'">'. $artista->nombre .'</label>';
}

$contenidoPrincipal .= '
            <div>
            <label for="tipo">Seleccione el tipo de contenido:</label>
            <select id="tipo" name="tipo" required>
                <option value="concierto">Concierto</option>
                <option value="disco">Disco</option>
                <option value="entrevista">Entrevista</option>
            </select>
            </div>
            <div>
            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" size="150">
            </div>
            <div>
            <input type="submit" name="create" value="Aceptar">
            </div>
        </form>';


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
?>