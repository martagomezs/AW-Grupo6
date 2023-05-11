<?php

function calendario($eventos){
    if(isset($_POST['mes'])){
        $mes = $_POST['mes'];
    }
    else{
        $mes = 1;
    }
    if(isset($_POST['año'])){
        $year = $_POST['año'];
    }
    else{
        $year = 2023;
    }
    $e = [];
    $i = 0;
    $calendario = '';
    $dias = date('t', mktime(0,0,0,$mes,1,$year));
    $primero = date('N', strtotime("$year-$mes-01"));
    $calendario = '<table>';
    $calendario .= '<tr><th colspan="7">' . date('F Y', strtotime("$year-$mes-01")) . '</th></tr>';
    $calendario .= '<tr><th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th><th>Vie</th><th>Sab</th><th>Dom</th></tr>';
    $calendario .= '<tr>';

    for($j = 1; $j < $primero; $j++){
        $calendario .= '<td></td>';
    }

    for($dia = 1; $dia <= $dias; $dia++){
        if (($dia + $primero - 1) % 7 == 1) {
            $calendario .= '</tr><tr>';
        }
        $calendario .= '<td>' . $dia;
        $fecha = new DateTime($year . "-" . $mes . "-" . $dia);
        foreach($eventos as $ev){
            $e = [];
            $date = new DateTime($ev->fecha);
            if($date == $fecha){
                if($ev->tipo == "disco"){
                    $calendario .= '<img src="img/utils/disco.png" width="30" class="event-img" id="img' . $i . '">';
                }
                elseif($ev->tipo == "concierto"){
                    $calendario .= '<img src="img/utils/micro.png" width="30" class="event-img" id="img' . $i . '">';
                }
                $e[] = $ev;
                $cont = visualizarEventos($e);
                $calendario .= <<<EOS
                    <dialog id="myDialog{$i}">
                        {$cont}
                        <button class="closeButton">Cerrar</button>
                    </dialog>
                    EOS;
                $i++;
            }   
        }
        $calendario .= '</td>';   
    }
    
    $calendario .= '</tr> </table>';

    $calendario .=<<<EOS
        <script>
            var imagenes = document.querySelectorAll('.event-img');
            var closeButtons = document.querySelectorAll('.closeButton');
            
            imagenes.forEach(function(imagen, index) {
                var dialog = document.getElementById('myDialog' + index);
                
                imagen.addEventListener('click', function() {
                    dialog.showModal();
                });
            });
            
            closeButtons.forEach(function(closeButton) {
                closeButton.addEventListener('click', function() {
                    this.parentNode.close();
                });
            });
        </script>
    EOS;
    
    return $calendario;
}

function visualizarEventos($eventos){
    $dialog = '<ul>';
    foreach($eventos as $ev){
        $artista = es\ucm\fdi\aw\Artista\Artista::buscaPorId($ev->idArtista);
        $dialog .= '<dl>';
        $dialog .= '<a href="artista.php?idAutor=' . $artista->id . '"><img src="' . $artista->foto . '" width="200"></a>';
        $dialog .= "<p>{$artista->nombre} - {$ev->fecha}</p>";
        $dialog .= "<p>{$ev->tipo}</p>";
        if($ev->desc != null){
            $dialog .= "<p>{$ev->desc}</p>";
        }
        $dialog .= '</dl>';
    }
    $dialog .= '</ul>';

    return $dialog;
}

?>