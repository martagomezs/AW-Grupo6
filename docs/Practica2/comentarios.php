<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/comentario.php';
require_once 'includes/vistas/helpers/vinilos.php';

$id = $_GET['user'];
$vinilo = Vinilo::buscaPorId($id);

$tituloPagina = "{$vinilo->titulo}";

$contenidoPrincipal=<<<EOS
  <div style="float: left; margin-right: 20px;">
  <img src="{$vinilo->portada}" width="300">
  <p>Nombre: {$vinilo->titulo}</p>
  <p>Autor: {$vinilo->autor}</p>
  </div>
  <h1>Comentarios</h1>
EOS;
	$vinilos = Vinilo::buscaPorAutor($artista->id);
	foreach($vinilos as $vinilo){
		$contenidoPrincipal .= '<a href="vinilo.php?id=' . $vinilo->id . '"><img src="' . $vinilo->portada . '" width="200"></a>';
	}
	$contenidoPrincipal .= '<p>Insertar calendario</p>';


  $comentarios = Comentario::buscaComentarios($vinilo->id);
	foreach($comentarios as $comentario){
		$contenidoPrincipal .= '<p>Fecha: ' . $comentario->fecha . '</p>';
		$contenidoPrincipal .= '<p>Autor: ' . $comentario->autor . '</p>';
		$contenidoPrincipal .= '<p>Comentario: ' . $comentario->comentario . '</p>';
	}
	/* $contenidoPrincipal .= '<p><a href="nuevoComentario.php?vinilo=' . $vinilo->id . '">Añadir comentario</a></p>';
 */

require 'includes/vistas/comun/layout.php';


?>
