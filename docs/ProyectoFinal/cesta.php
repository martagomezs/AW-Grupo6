<?php
require_once __DIR__.'/includes/config.php';


$tituloPagina = 'Cesta';
if(!estaLogado()){
    Utils::paginaError(403, $tituloPagina, 'No estas logado', 'No tienes acceso a esta página');
}


if(isset($_POST['comprar'])){
	$user = $_SESSION['username'];
	es\ucm\fdi\aw\Compra\Compra::actualizaCestaCompra($user);
	echo '<script>alert("Su compra se ha realizado correctamente. Gracias por comprar en BeatStore");</script>';
}

$contenidoPrincipal=<<<EOS
	<h1 class="titulo">Cesta</h1>
EOS;

$contenidoPrincipal .= visualizaCesta($_SESSION['username']);

$contenidoPrincipal .= <<< EOS
    <form method="post">
        <input type="submit" name="comprar" value="Comprar">
    </form>
EOS;


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
