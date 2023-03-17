<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';
require_once 'includes/vistas/helpers/artistas.php';
require_once 'includes/vistas/helpers/vinilos.php';


// if (! estaLogado()) {
// 	Utils::paginaError(403, $tituloPagina, 'Usuario no conectado!', 'Debes iniciar sesión para ver el contenido.');
// }


$tituloPagina = 'Artista';

$id = $_GET['id'];

$artista = Artista::buscaPorId($id);
$vinilo = Vinilo::buscaPorId($artista->vinilo);

$contenidoPrincipal=<<<EOS
	<h1>{$artista->nombre}</h1>
	<img src="{$artista->foto}" width="400">
	<p>{$artista->seguidores}</p>
	<a href="vinilo.php?id={$vinilo->id}"><img src="{$vinilo->portada}" width="200"></a>
	<p>Insertar calendario</p>
EOS;

require 'includes/vistas/comun/layout.php';
