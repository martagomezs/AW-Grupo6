<?php
namespace es\ucm\fdi\aw\Vinilo;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Valoracion{
    use MagicProperties;

    public static function añade($idVinilo, $idUser, $valoracion){
        $v = new Valoracion(self::numFilas() + 1, $idVinilo,$idUser,$valoracion);
        self::inserta($v);
        return $v;
    }

    public static function numFilas(){
        $result = 0;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT COUNT(*) as total FROM Valoraciones;");

        $rs = $conn->query($query);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result = $fila['total'];
            }
            $rs->free();
        }
        return $result; 
    }

    public static function numValoraciones($idVinilo){
        $result = 0;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT COUNT(*) as total FROM Valoraciones WHERE idVinilo = %d;", $idVinilo);

        $rs = $conn->query($query);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result = $fila['total'];
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorVinilo($idVinilo){
        $result = [];

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM Valoraciones WHERE idVinilo = %d;", $idVinilo);
        $rs = $conn->query($query);
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Valoracion($fila['id'],$fila['idVinilo'],$fila['idUser'],$fila['valoracion']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function haValorado($idUser, $idVinilo){
        $result = false;

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM Valoraciones WHERE idUser = '%s' AND idVinilo = %d;", $idUser, $idVinilo);
        $rs = $conn->query($query);
        if($rs && $rs->num_rows == 1){
            $result = true;
            $rs->free();
        }
        return $result;
    }

    private static function inserta($valoracion){
        $result = false;

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO Valoraciones (id, idVinilo, idUser, valoracion) VALUES (%d, %d, '%s', %d)",
            $valoracion->id,
            $valoracion->idVinilo,
            $conn->real_escape_string($valoracion->idUser),
            $valoracion->valoracion
        );
        $result = $conn->query($query);
        if($result){
            $valoracion->id = $conn->insert_id;
            $result = $valoracion;
        }
        else{
            error_log($conn->error);
        }
        return $result;
    }     


    private $id;
    private $idVinilo;
    private $idUser;
    private $valoracion;

    private function __construct($id,$idVinilo,$idUser,$valoracion){
        $this->id = $id !== null ? intval($id) : null;
        $this->idVinilo = intval($idVinilo);
        $this->idUser = $idUser;
        $this->valoracion = $valoracion;
    }

    public function getId(){
        return $this->id;
    }

    public function getVinilo(){
        return $this->idVinilo;
    }

    public function setVinilo($nuevo){
        $this->idVinilo = $nuevo;
    }

    public function getUser(){
        return $this->idUser;
    }

    public function setUser($nuevo){
        $this->idUser = $nuevo;
    }

    public function getValoracion(){
        return $this->valoracion;
    }

    public function setValoracion($nuevo){
        $this->valoracion = $nuevo;
    }
}

?>