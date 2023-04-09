<?php

class Evento{
    use MagicProperties;

    public static function añade($fecha,$idArtista,$tipo,$descripcion){
        $a = new Evento(self::numFilas() + 1,$fecha,$idArtista,$tipo,$descripcion);
        return $a;   
    }

    private static function numFilas(){
        $result = 0;

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT COUNT(*) as total FROM eventos;");

        $rs = $conn->query($query);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result = $fila['total'];
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorArtista($idArtista){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM eventos WHERE idArtista = %d;", $idArtista);
        $rs = $conn->query($query);
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Evento($fila['id'],$fila['fecha'],$fila['idArtista'],$fila['tipo'],$fila['descripcion']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorFecha($fecha){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $date = date_format($fecha, "Y-m-d");
        $query = sprintf("SELECT * FROM eventos WHERE fecha = '%s';", $date);
        $rs = $conn->query($query);
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Evento($fila['id'],$fila['fecha'],$fila['idArtista'],$fila['tipo'],$fila['descripcion']);
            }
            $rs->free();
        }
        return $result;
    }

    private $id;
    private $fecha;
    private $idArtista;
    private $tipo;
    private $descripcion;

    private function __construct($id,$fecha,$idArtista,$tipo,$descripcion){
        $this->id = $id !== null ? intval($id) : null;
        $this->fecha = $fecha;
        $this->idArtista = intval($idArtista);
        $this->tipo = $tipo;
        $this->descripcion = $descripcion;
    }

    public function getId(){
        return $this->id;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function setFecha($nuevo){
        $this->fecha = $nuevo;
    }

    public function getArtista(){
        return $this->idArtista;
    }

    public function setArtista($nuevo){
        $this->idArtista = $nuevo;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function setTipo($nuevo){
        $this->tipo = $nuevo;
    }

    public function getDesc(){
        return $this->descripcion;
    }

    public function setDesc($nuevo){
        $this->descripcion = $nuevo;
    }
}

?>