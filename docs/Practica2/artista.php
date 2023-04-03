<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/artistas.php';
require_once 'includes/vistas/helpers/vinilos.php';

$id = $_GET['idAutor'];
$artista = Artista::buscaPorId($id);

$tituloPagina = "{$artista->nombre}";

$contenidoPrincipal=<<<EOS
	<h1>{$artista->nombre}</h1>
	<img src="{$artista->foto}" width="400">
	<p>Seguidores: {$artista->seguidores}</p>
	<p>Discografía:</p>
EOS;
	$vinilos = Vinilo::buscaPorAutor($artista->id);
	foreach($vinilos as $vinilo){
		$contenidoPrincipal .= '<a href="vinilo.php?id=' . $vinilo->id . '"><img src="' . $vinilo->portada . '" width="200"></a>';
	}
	$contenidoPrincipal .= '<p>Insertar calendario</p>';


require 'includes/vistas/comun/layout.php';

?>
