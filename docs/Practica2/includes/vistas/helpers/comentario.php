<?php

function visualizaComentario($comentario){
    return <<<EOS
    <p><strong>{$comentario->autor}:</strong> {$comentario->comentario}</p>
    <p><small>{$comentario->fecha}</small></p>
    EOS;
}

function listaComentarios(){

    $comentarios = Comentario::buscaComentarios($vinilo_id);

    if(!is_array($comentarios) || count($comentarios) == 0){
        return '';
    }
    
    $html = '<ul>';
    foreach($comentarios as $comentario){
        $html .= '<dl>';
        $html .= visualizaComentario($comentario);
        $html .= '</dl>';
    }
    $html .= '</ul>';

    return $html;
}

?>