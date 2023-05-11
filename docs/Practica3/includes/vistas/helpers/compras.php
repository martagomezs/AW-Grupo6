<?php

function eliminaElemento($idCesta) {
    Compra::eliminaElementoCesta($idCesta);
}

function visualizaCesta($user){
    $cesta = Compra::buscaCesta($user);
    
    if(!is_array($cesta) || count($cesta) == 0){
        return '';
    }
    $precioTotal = 0;
    $html = '<ul>';
    foreach($cesta as $c){
        $vinilo = Vinilo::buscaPorId($c->idVinilo);
        $html .= '<dl>';
        $html .= '<a href="vinilo.php?id=' . $vinilo->id . '"><img src="' . $vinilo->portada . '" width="50"></a>';
        $html .= '<p>' . $vinilo->titulo . ' - ' . $vinilo->autor . ': ' . $vinilo->precio . '€ <p>';
        $html .= '</dl>';
        $precioTotal +=$vinilo->precio;
    }
    
    $html .= '</ul>';

    $html .= '<p>Total: ' . $precioTotal . '€</p>';

    return $html;
}


?>