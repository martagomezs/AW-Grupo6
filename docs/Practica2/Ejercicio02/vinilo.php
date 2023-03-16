<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/vinilos.php';


$id = $_GET['id'];

$vinilo = Vinilo::buscaPorId($id);

$tituloPagina = "{$vinilo->titulo}";

$contenidoPrincipal = <<< EOS
    <h1>{$vinilo->titulo}</h1>
    <h2><a href="artista.php">{$vinilo->idAutor}</a></h2>
    <img src="{$vinilo->portada}" width="400">
    <figure>
        <figcaption>Demo audio:</figcaption>
        <audio controls src="{$vinilo->canciones}">
    </figure>
    <p>{$vinilo->precio}€</p>
    <form action="cesta.php" method="post">
        <input type="hidden" name="id" value="{$vinilo->id}">
        <input type="submit" value="Añadir a Cesta">
    </form>
EOS;


require 'includes/vistas/comun/layout.php';
?>