<?php

class Evento{
    use MagicProperties;

    public static function añade($fecha,$idArtista,$idVinilo){
        $a = new Evento($fecha,$idArtista,$idVinilo);
        return $a;   
    }

    public static function buscaPorArtista($idArtista){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM eventos WHERE idArtista = %d;", $idArtista);
        $rs = $conn->query($query);
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Evento($fila['id'],$fila['idArtista'],$fila['idVinilo']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorFecha($fecha){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $date = date_format($fecha, "Y-m-d");
        $query = sprintf("SELECT * FROM eventos WHERE fecha = %s;", $date);
        $rs = $conn->query($query);
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Evento($fila['id'],$fila['idArtista'],$fila['idVinilo']);
            }
            $rs->free();
        }
        return $result;
    }

    private $id;
    private $fecha;
    private $idArtista;
    private $idVinilo;

    private function __construct($id,$fecha,$idArtista,$idVinilo){
        $this->id = $id !== null ? intval($id) : null;
        $this->fecha = $fecha;
        $this->idArtista = intval($idArtista);
        $this->idVinilo = intval($idVinilo);
    }

    public function getId(){
        return $this->id;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function getArtista(){
        return $this->idArtista;
    }

    public function getVinilo(){
        return $this->idVinilo;
    }
}

?>