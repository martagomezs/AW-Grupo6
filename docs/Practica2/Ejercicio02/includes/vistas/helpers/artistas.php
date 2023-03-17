<?php

function visualizaArtista($artista){
    return <<<EOS
    <a href="artista.php?id={$artista->id}"><img src="{$artista->foto}" width="200"></a>
    <p>{$artista->nombre}{$artista->seguidores}</p>
    EOS;
}

function listaArtistas(){
    $artistas = Artista::buscaARtistas();

    if(!is_array($artistas) || count($artistas) == 0){
        return '';
    }
    
    $html = '<ol>';
    foreach($artistas as $artista){
        $html .= '<li>';
        $html .= visualizaArtista($artista);
        $html .= '</li>';
    }
    $html .= '</ol>';

    return $html;
}

?>