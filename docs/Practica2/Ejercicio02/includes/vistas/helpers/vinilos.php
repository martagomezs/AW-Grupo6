<?php

function visualizaVinilo($vinilo){
    return <<<EOS
    <img src="{$vinilo->portada}" width="300">
    <figcaption>({$vinilo->titulo})({$vinilo->idAutor})</figcaption>
    EOS;
}

function listaVinilos(){
    $vinilos = Vinilo::buscaVinilos();
    
    if(!is_array($vinilos) || count($vinilos) == 0){
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