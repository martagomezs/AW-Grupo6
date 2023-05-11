<?php
require_once __DIR__.'/includes/config.php';

$id = $_GET['idAutor'];
$user = null;
if(estaLogado()){
	$user = $_SESSION['username'];
}

$artista = es\ucm\fdi\aw\Artista\Artista::buscaPorId($id);
$seguidores = es\ucm\fdi\aw\Seguir\Seguir::buscaSeguidores($artista->id);

$tituloPagina = "{$artista->nombre}";

if(isset($_POST['seguir'])){
	if(estaLogado()){
		$user = $_SESSION['username'];
		if(!es\ucm\fdi\aw\Seguir\Seguir::seguir($artista->id,$user)){
			Utils::paginaError(403, $tituloPagina, 'No se ha podido seguir', 'xxx');
		}
		$seguidores = es\ucm\fdi\aw\Seguir\Seguir::buscaSeguidores($artista->id);
	}
	else{
		Utils::paginaError(403, $tituloPagina, 'Usuario no conectado!', 'Debes iniciar sesión para poder seguir al artista');
	}
}
if(isset($_POST['dejar'])){
	$user = $_SESSION['username'];
	if(!es\ucm\fdi\aw\Seguir\Seguir::dejarDeSeguir($artista->id,$user)){
		Utils::paginaError(403, $tituloPagina, 'Fallo al dejar de seguir', 'xxx');
	}
	$seguidores = es\ucm\fdi\aw\Seguir\Seguir::buscaSeguidores($artista->id);
}

$contenidoPrincipal=<<<EOS
	<h1 class="titulo">{$artista->nombre}</h1>
	<div class="artista-contenido">
	<div class="art">
	<img src="{$artista->foto}" width="400">
	<p>Seguidores: {$seguidores}</p>
EOS;
if(!estaLogado() || !es\ucm\fdi\aw\Seguir\Seguir::siguiendo($artista->id,$user)){
	$contenidoPrincipal .= '<form method="post">
		<input type="submit" name="seguir" value="Seguir">
		</form>';
}
else if(es\ucm\fdi\aw\Seguir\Seguir::siguiendo($artista->id,$user)){
	$contenidoPrincipal .= '<form method="post">
		<input type="submit" name="dejar" value="Dejar de seguir">
		</form>';
}
	$contenidoPrincipal .= 
		'</div>
		<div class="discografia">
		<h2>Discografía:</h2>
		<section>';
		
	$vinilos = es\ucm\fdi\aw\Vinilo\Vinilo::buscaPorAutor($artista->id);
	foreach($vinilos as $vinilo){
		$contenidoPrincipal .= '<a href="vinilo.php?id=' . $vinilo->id . '"><img src="' . $vinilo->portada . '" width="200"></a>';
	}
	$mes = 1;
	$year = 2023;
	$contenidoPrincipal .= 
		'</section>
		</div>
		<div class="eventos">
		<h2>Eventos</h2>';
	$eventos = es\ucm\fdi\aw\Evento\Evento::buscaPorArtista($artista->id);
	$contenidoPrincipal .= calendario($eventos);
	$contenidoPrincipal .= 
		'<form method="post">
    		<label for="mes">Mes:</label>
    		<input type="number" id="mes" name="mes" min="1" max="12" value= ' . $mes . '>
    		<label for="año">Año:</label>
    		<input type="number" id="año" name="año" min="2023" value=' . $year . '>
    		<button type="submit">Aceptar</button>
		</form>
		</div>
		</div>';
		

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
?>
