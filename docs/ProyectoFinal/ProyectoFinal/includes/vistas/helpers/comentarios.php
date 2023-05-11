<?php

function visualizaComentario($coment){
    $c = '<h3>' . $coment->autor . '</h3>';
    $c .= '<p>' . $coment->comentario . '</p>';
    $c .= <<< EOS
        <form method="post" action="vinilo.php">
        <input type="hidden" name="idPadre" value="{$coment->id}">
        <input type="hidden" name="idVinilo" value="{$coment->idVinilo}">
        <input type="hidden" name="coment" value="{$coment->comentario}">
        <input type="submit" class="resp" value="Responder">
        </form> 
    EOS;
    
    $respuestas = es\ucm\fdi\aw\Comentario\Comentario::buscaPorPadre($coment->id);

    if($respuestas){
        $c .= '<div class="respuestas">';
        $c .= '<ul class="respond">';
        foreach($respuestas as $respuesta){
            $c .= '<dl class="respuesta-dl">';
            $c .= '<h3>' . $respuesta->autor . '</h3>';
            $c .= '<p>' . $respuesta->comentario . '<p>';
            $c .= '</dl>';
        }
        $c .= '</ul>';
        $c .= '</div>';
    }

    return $c;
}

?>