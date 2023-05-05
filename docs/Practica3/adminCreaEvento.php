<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$tituloPagina = 'Crear Artistas';

if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}



if(isset($_POST['create'])){
    $fecha = $_POST['fecha'];
    $tipo = $_POST['tipo'];
    $idArtista = $_POST['artista'];
    $descripcion = $_POST['descripcion'];
    echo "Valor de tipo_contenido: " . $tipo;
    if (Evento::insertaAdmin($fecha, $tipo , $idArtista, $descripcion)){
        echo '<script>alert("Evento creado con éxito.")</script>';
    }
}

$artistas = Artista::buscaArtistas();

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


require 'includes/vistas/comun/layout.php';
?>