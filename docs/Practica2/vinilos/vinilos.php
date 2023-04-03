<?php

require_once '../includes/config.php';
require_once '../includes/vistas/helpers/vinilos.php';

$idVinilo = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if(!$idVinilo){
    Utils::redirige(Utils::buildUrl('/catalogo.php'));
}

$vinilo = Vinilo::buscaPorId($idVinilo);
if(!$vinilo){
    Utils::redirige(Utils::buildUrl('/catalogo.php'));
}

$tituloPagina = 'Vinilo';

$contenidoPrincipal = listaVinilos();

require '../includes/vistas/comun/layout.php';

?>