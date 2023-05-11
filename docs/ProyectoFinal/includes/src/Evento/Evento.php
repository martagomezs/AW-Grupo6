<?php
namespace es\ucm\fdi\aw\Evento;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Evento{
    use MagicProperties;

    public static function añade($fecha,$idArtista,$tipo,$descripcion){
        $a = new Evento(self::numFilas() + 1,$fecha,$idArtista,$tipo,$descripcion);
        return $a;   
    }

    private static function numFilas(){
        $result = 0;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT COUNT(*) as total FROM Eventos;");

        $rs = $conn->query($query);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result = $fila['total'];
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaEventos(){
        $result = [];

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM Eventos E ORDER BY E.fecha DESC;");
        $rs = $conn->query($query);
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Evento($fila['id'],$fila['fecha'],$fila['idArtista'],$fila['tipo'],$fila['descripcion']);            }
            $rs->free();
        }
        return $result;
    }

    public static function insertaAdmin($fecha, $tipo , $idArtista, $descripcion){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO Eventos (fecha, idArtista, tipo, descripcion) VALUES ('%s', %d , '%s', '%s')",
            $fecha,
            $idArtista, 
            $tipo,
            $descripcion
        );
        $result = $conn->query($query);
        return $result;
    }

    public static function buscaPorArtista($idArtista){
        $result = [];

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Eventos WHERE idArtista = %d;", $idArtista);
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

        $conn = Aplicacion::getInstance()->getConexionBd();
        $date = date_format($fecha, "Y-m-d");
        $query = sprintf("SELECT * FROM Eventos WHERE fecha = '%s';", $date);
        $rs = $conn->query($query);
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Evento($fila['id'],$fila['fecha'],$fila['idArtista'],$fila['tipo'],$fila['descripcion']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function borraPorId($idEvento){
        if(!$idEvento){
            return false;
        }
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Eventos WHERE id = %d", $idEvento);
        $result = $conn->query($query);
        if(!$result){
            error_log($conn->error);
        }
        else if($conn->affected_rows != 1){
            error_log("Se han borrado '$conn->affected_rows' ");
        }
        return $result;
    }

    public static function borraPorArtista($idArtista){
        if(!$idArtista){
            return false;
        }
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Eventos WHERE idArtista = %d", $idArtista);
        $result = $conn->query($query);
        if(!$result){
            error_log($conn->error);
        }
        else if($conn->affected_rows != 1){
            error_log("Se han borrado '$conn->affected_rows' ");
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

    public function getidArtista(){
        return $this->idArtista;
    }

    public function setidArtista($nuevo){
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