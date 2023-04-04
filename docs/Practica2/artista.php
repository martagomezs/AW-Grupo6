<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/artistas.php';
require_once 'includes/vistas/helpers/vinilos.php';
require_once 'includes/vistas/helpers/eventos.php';

$id = $_GET['idAutor'];
$artista = Artista::buscaPorId($id);
$eventos = Evento::buscaPorArtista($artista->id);

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
	$mes = 1;
	$year = 2023;
	$contenidoPrincipal .= '<p>Eventos</p>';
	$contenidoPrincipal .= calendario();
	$contenidoPrincipal .= 
		'<form method="post">
    		<label for="mes">Mes:</label>
    		<input type="number" id="mes" name="mes" min="1" max="12" value= ' . $mes . '>
    		<label for="año">Año:</label>
    		<input type="number" id="año" name="año" min="2023" value=' . $year . '>
    		<button type="submit">Aceptar</button>
		</form>';
require 'includes/vistas/comun/layout.php';

?>
