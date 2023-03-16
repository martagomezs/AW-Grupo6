<?php

function visualizVinilo($vinilo){
    return <<<EOS
    <img src="{$vinilo->portada}">
    <figcaption>({$vinilo->titulo})({$vinilo->autor})</figcaption>
    EOS;
}

?>