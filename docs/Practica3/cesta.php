<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/vinilos.php';
require_once 'includes/vistas/helpers/compras.php';
require_once 'includes/vistas/helpers/autorizacion.php';


$tituloPagina = 'Cesta';
if(!estaLogado()){
    Utils::paginaError(403, $tituloPagina, 'No estas logado', 'No tienes acceso a esta página');
}


if(isset($_POST['comprar'])){
	$user = $_SESSION['username'];
	Compra::actualizaCestaCompra($user);
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


require 'includes/vistas/comun/layout.php';
