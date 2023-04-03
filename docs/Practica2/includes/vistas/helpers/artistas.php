<?php

function visualizaArtista($artista){
    return <<<EOS
    <a href="artista.php?idAutor={$artista->id}"><img src="{$artista->foto}" width="200"></a>
    <p>{$artista->nombre}: {$artista->seguidores}</p>
    EOS;
}

function listaArtistas(){
    $artistas = Artista::buscaArtistas();

    if(!is_array($artistas) || count($artistas) == 0){
        return '';
    }
    
    $html = '<ul>';
    foreach($artistas as $artista){
        $html .= '<dl>';
        $html .= visualizaArtista($artista);
        $html .= '</dl>';
    }
    $html .= '</ul>';

    return $html;
}

?>