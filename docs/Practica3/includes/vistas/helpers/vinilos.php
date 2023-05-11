<?php

function visualizaVinilo($vinilo){
    return <<<EOS
    <a href="vinilo.php?id={$vinilo->id}"><img src="{$vinilo->portada}" width="200"></a>
    <p>{$vinilo->titulo} - <a href="artista.php?idAutor={$vinilo->idAutor}">{$vinilo->autor}</a>: {$vinilo->precio}€</p>
    EOS;
}

function listaVinilos(){
    $vinilos = Vinilo::buscaVinilos();
    
    if(!is_array($vinilos) || count($vinilos) == 0){
        return '';
    }

    $html = '<ul>';
    foreach($vinilos as $vinilo){
        $html .= '<dl>';
        $html .= visualizaVinilo($vinilo);
        $html .= '</dl>';
    }
    $html .= '</ul>';
    
    return $html;
}

?>