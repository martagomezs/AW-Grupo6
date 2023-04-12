<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/vinilos.php';
require_once 'includes/vistas/helpers/compras.php';

$tituloPagina = 'Cesta';


if(isset($_POST['cesta'])){
	$user = $_SESSION['username'];
	$fecha_actual = date('Y-m-d');
	$cesta = Compra::buscaCesta($user);
	foreach($cesta as $c){
		$c->setEnCesta(false);
		$c->setComprado(true);
		$c->setFechaCompra($fecha_actual);  
	}
}

$contenidoPrincipal=<<<EOS
	<h1>Cesta</h1>
EOS;

$contenidoPrincipal .= visualizaCesta($_SESSION['username']);

$contenidoPrincipal .= <<< EOS
    <form method="post">
        <input type="submit" name="cesta" value="Comprar">
    </form>
EOS;


require 'includes/vistas/comun/layout.php';
