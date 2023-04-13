<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$tituloPagina = 'Crear Vinilos';

if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}



if(isset($_POST['create'])){
    $titulo = $_POST['titulo'];
    $idAutor = $_POST['id'];
    $autor = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $portada = 'img/utils/disco.png';
    $ventas = 0;
    if (Vinilo::insertaAdmin($titulo, $autor, $idAutor, $precio, $portada, $ventas, $stock)){
        echo '<script>alert("Vinilo creado con éxito.")</script>';
    }
}

$contenidoPrincipal = '<h2>Crea Nuevo Vinilo</h2>';

$contenidoPrincipal .= '<p>Selecciona el artista del que quieres añadir un vinilo</p>';

$contenidoPrincipal .= '<form method="post">';

$artistas = Artista::buscaArtistas();

foreach($artistas as $artista){
    $contenidoPrincipal .= '<input type="radio" id="'.$artista->id.'" name="artista" value="'.$artista->id.'">';
    $contenidoPrincipal .= '<label for="'.$artista->id.'">'. $artista->nombre .'</label>';
}
$contenidoPrincipal .= '<br><input type="submit" id="sel" name="boton" value="Aceptar" >';
$contenidoPrincipal .= '</form>';

if(isset($_POST['boton'])){
    $idArtista = $_POST['artista'];
    $artista = Artista::buscaPorId($idArtista);
    $nombreArtista = $artista->getNombre();
    $contenidoPrincipal = <<<EOS
            <h2> Nuevo vinilo de $nombreArtista </h2>
            <form method="post">
            <div>
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" required minlength="1" size="10">
                </div>
                <div>
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" min="1"" required>
                </div>
                <div>
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" min="1" required>
                </div>
                <div>
                <input type="submit" name="create" value="Aceptar">
                </div>
                </div>
                <input type="hidden" name="id" value="{$idArtista}">
                <div>
                </div>
                <input type="hidden" name="nombre" value="{$nombreArtista}">
                <div>
            </form>
    EOS;
}



require 'includes/vistas/comun/layout.php';
?>