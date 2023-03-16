<?php

function visualizVinilo($vinilo){
    return <<<EOS
    <img src="{$vinilo->portada}">
    <figcaption>({$vinilo->titulo})({$vinilo->autor})</figcaption>
    EOS;
}

function listaVinilos($id = NULL){
    $vinilos = Vinilo::buscaVinilos();
    if(count($vinilos) == 0){
        return '';
    }

    $html = '<ul>';
    foreach($vinilos as $vinilo){
        $html .= '<li>';
        $html .= visualizaVinilo($vinilo);
        $html .= '</li>';
    }
    $html .= '</ul>';

    return $html;
}

?>