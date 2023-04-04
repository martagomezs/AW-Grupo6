<?php

function calendario(){
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
        $ev = Evento::buscaPorFecha($fecha);
        if($ev != null){
            
        }
        $calendario .= '</td>';
    }
    $calendario .= '</tr> </table>';
    return $calendario;
}

?>