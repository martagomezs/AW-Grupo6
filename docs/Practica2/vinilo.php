<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/vinilos.php';
require_once 'includes/vistas/helpers/autorizacion.php';


$id = $_GET['id'];

$vinilo = Vinilo::buscaPorId($id);

$tituloPagina = "{$vinilo->titulo}";


if(isset($_POST['idVinilo'])){
    if(!estaLogado()){
        Utils::paginaError(403, $tituloPagina, 'Usuario no conectado!', 'Debes iniciar sesión para poder añadir el articulo a la cesta');
    }
    else{
    $compra = Compra::añade($_SESSION['username'], $_POST['idVinilo'], 0);
    $compra->guarda();
    }
}

$contenidoPrincipal = <<< EOS
    <h1>{$vinilo->titulo}</h1>
    <h2><a href="artista.php?idAutor={$vinilo->idAutor}">{$vinilo->autor}</a></h2>
    <img src="{$vinilo->portada}" width="400">
    <p>{$vinilo->precio}€</p>
EOS;

    $canciones = Cancion::canciones($vinilo->id);
    
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
    <form method="post">
        <input type="hidden" name="idVinilo" value="{$vinilo->id}">
        <input type="submit" value="Añadir a Cesta">
    </form>
EOS;

require 'includes/vistas/comun/layout.php';
?>