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
    $calendario = '';
    $dias = cal_days_in_month(CAL_GREGORIAN, $mes, $year);
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
            $date = new DateTime($ev->fecha);
            if($date == $fecha){
                if($ev->tipo == "disco"){
                    $calendario .= '<img src="img/utils/disco.png" width="30" id="img">';
                }
                elseif($ev->tipo == "concierto"){
                    $calendario .= '<img src="img/utils/micro.png" width="30" id="img">';
                }
                $e[] = $ev;
                $cont = visualizarEventos($e);
                $calendario .= <<<EOS
                    <dialog id="myDialog">
                        {$cont}
                        <button id="closeButton">Cerrar</button>
                    </dialog>

                    <script>
                        var imagen = document.getElementById('img');
                        var dialog = document.getElementById('myDialog');
                        var closeButton = document.getElementById('closeButton');
                        
                        imagen.addEventListener('click', function() {
                            dialog.showModal();
                        });
                        
                        closeButton.addEventListener('click', function() {
                            dialog.close();
                        });
                    </script>
                EOS;
            }   
        }
        
        $calendario .= '</td>';
    }
    $calendario .= '</tr> </table>';
    return $calendario;
}

function visualizarEventos($eventos){
    $dialog = '<ul>';
    foreach($eventos as $ev){
        $artista = Artista::buscaPorId($ev->idArtista);
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