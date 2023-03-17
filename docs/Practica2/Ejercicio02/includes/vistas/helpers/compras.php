<?php

function visualizaCesta($user){
    $vinilos = Compra::buscaCesta($user);
    
    if(!is_array($vinilos) || count($vinilos) == 0){
        return '';
    }

    $html = '<ul>';
    foreach($vinilos as $vinilo){
        $html .= '<dl>';
        $html .= '<a href="vinilo.php?id={$vinilo->id}"><img src="{$vinilo->portada}" width="200"></a>';
        $html .= '<p>{$vinilo->titulo} - <a href="artista.php?idAutor={$vinilo->idAutor}">{$vinilo->autor}</a>: {$vinilo->precio}€</p>';
        $html .= '</dl>';
    }
    $html = '</ul>';

    return $html;
}

?>