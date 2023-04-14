<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/vinilos.php';
require_once 'includes/vistas/helpers/autorizacion.php';


$id = $_GET['id'];

$vinilo = Vinilo::buscaPorId($id);
$canciones = Cancion::canciones($id);

$tituloPagina = "{$vinilo->titulo}";


if(isset($_POST['idVinilo'])){
    if(!estaLogado()){
        Utils::paginaError(403, $tituloPagina, 'Usuario no conectado!', 'Debes iniciar sesión para poder añadir el articulo a la cesta');
    }
    else{
    $fecha_actual = date('Y-m-d');
    $compra = Compra::añade($_SESSION['username'], $_POST['idVinilo'], $vinilo->precio, true, false, $fecha_actual);
    $compra->guarda();
    }
}
$contenidoPrincipal = '';
$contenidoPrincipal .= <<< EOS
    <h1 class="titulo">{$vinilo->titulo}</h1>
    <h2><a href="artista.php?idAutor={$vinilo->idAutor}">{$vinilo->autor}</a></h2>
    <div class="vinilo-canciones">
        <img src="{$vinilo->portada}" width="400">
        <div class="canciones">
EOS;

foreach($canciones as $cancion){
    $contenidoPrincipal .= 
            '<dl> 
            <figure>
            <figcaption>' . $cancion->titulo . ':
            </figcaption>
            <audio controls src="' . $cancion->audio . '">
            </figure>
            </dl>';
}

$contenidoPrincipal .= <<< EOS
        </div>
    </div>
    <p>{$vinilo->precio}€</p>
EOS;

$contenidoPrincipal .= <<< EOS
    <form method="post">
        <input type="hidden" name="idVinilo" value="{$vinilo->id}">
        <input type="submit" value="Añadir a Cesta">
    </form>
EOS;

require 'includes/vistas/comun/layout.php';
?>