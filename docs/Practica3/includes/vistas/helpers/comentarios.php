<?php

function visualizaComentario($coment){
    $c = '<h3>' . $coment->autor . '</h3>';
    $c .= '<p>' . $coment->comentario . '</p>';
    
    $respuestas = Comentario::buscaPorPadre($coment->id);

    if($respuestas){
        $c .= '<ul>';
        foreach($respuestas as $respuesta){
            $c .= '<dl>';
            $c .= '<h3>' . $respuesta->autor . '</h3>';
            $c .= '<p>' . $respuesta->comentario . '<p>';
            $c .= '</dl>';
        }
        $c .= '</ul>';
    }

    return $c;
}

?>