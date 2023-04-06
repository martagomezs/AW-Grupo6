<?php

function visualizaCesta($user){
    $cesta = Compra::buscaCesta($user);
    
    if(!is_array($cesta) || count($cesta) == 0){
        return '';
    }

    $html = '<ul>';
    foreach($cesta as $c){
        $vinilo = Vinilo::buscaPorId($c->idVinilo);
        $html .= '<dl>';
        $html .= '<a href="vinilo.php?id=' . $vinilo->id . '"><img src="' . $vinilo->portada . '" width="200"></a>';
        $html .= '<p>' . $vinilo->titulo . ' - <a href="artista.php?idAutor=' . $vinilo->idAutor . '">' . $vinilo->autor . '</a>: ' . $vinilo->precio . '€</p>';
        $html .= '</dl>';
    }
    $html .= '</ul>';

    return $html;
}


?>