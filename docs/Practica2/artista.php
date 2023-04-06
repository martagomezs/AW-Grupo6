<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/artistas.php';
require_once 'includes/vistas/helpers/vinilos.php';
require_once 'includes/vistas/helpers/eventos.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$id = $_GET['idAutor'];
$user = null;
$artista = Artista::buscaPorId($id);
$eventos = Evento::buscaPorArtista($artista->id);
$seguidores = Artista::buscaSeguidores($artista->id);

$tituloPagina = "{$artista->nombre}";

if(isset($_POST['seguir'])){
	if(estaLogado()){
		$user = $_SESSION['username'];
		if(!Artista::seguir($artista->id,$user)){
			Utils::paginaError(403, $tituloPagina, 'No se ha podido seguir', 'xxx');
		}
		$seguidores = Artista::buscaSeguidores($artista->id);
	}
	else{
		Utils::paginaError(403, $tituloPagina, 'Usuario no conectado!', 'Debes iniciar sesión para poder seguir al artista');
	}
}
if(isset($_POST['dejar'])){
	$user = $_SESSION['username'];
	if(!Artista::dejarDeSeguir($artista->id,$user)){
		Utils::paginaError(403, $tituloPagina, 'Fallo al dejar de seguir', 'xxx');
	}
	$seguidores = Artista::buscaSeguidores($artista->id);
}

$contenidoPrincipal=<<<EOS
	<h1>{$artista->nombre}</h1>
	<img src="{$artista->foto}" width="400">
	<p>Seguidores: {$seguidores}</p>
EOS;
if(!estaLogado() || !Artista::siguiendo($artista->id,$user)){
	$contenidoPrincipal .= '<form method="post">
		<input type="submit" name="seguir" value="Seguir">
		</form>';
}
elseif(Artista::siguiendo($artista->id,$user)){
	$contenidoPrincipal .= '<form method="post">
		<input type="submit" name="dejar" value="Dejar de seguir">
		</form>';
}
	$contenidoPrincipal .= '<p>Discografía:</p>';
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
