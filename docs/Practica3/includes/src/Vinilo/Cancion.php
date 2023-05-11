<?php

class Cancion{
    use MagicProperties;

    public static function canciones($idVinilo){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM Canciones WHERE idVinilo = %d;", $idVinilo);
        $rs = $conn->query($query);
        if($rs && $rs->num_rows > 0){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Cancion($fila['id'], $fila['idVinilo'], $fila['titulo'], $fila['audio']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaCanciones(){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM Canciones C ORDER BY C.idVinilo DESC;");
        $rs = $conn->query($query);
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Cancion($fila['id'],$fila['idVinilo'],$fila['titulo'],$fila['audio']);            }
            $rs->free();
        }
        return $result;
    }

    public static function borraPorVinilo($idVinilo){
        if(!$idVinilo){
            return false;
        }
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Canciones WHERE idVinilo = %d", $idVinilo);
        $result = $conn->query($query);
        if(!$result){
            error_log($conn->error);
        }
        return $result;
    }

    public static function borraPorId($id){
        if(!$id){
            return false;
        }
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Canciones WHERE id = %d", $id);
        $result = $conn->query($query);
        if(!$result){
            error_log($conn->error);
        }
        return $result;
    }

    public static function insertaAdmin($idVinilo, $titulo , $audio){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO Canciones (idVinilo, titulo, audio) VALUES (%d , '%s', '%s')",
            $idVinilo,
            $titulo, 
            $audio
        );
        $result = $conn->query($query);
        if(!$result){
            error_log($conn->error);
        }
        return $result;
    }

    private $id;
    private $idVinilo;
    private $titulo;
    private $audio;

    private function __construct($id,$idVinilo,$titulo,$audio){
        $this->id = $id !== null ? intval($id) : null;
        $this->idVinilo = intval($idVinilo);
        $this->titulo = $titulo;
        $this->audio = $audio;
    }

    public function getId(){
        return $this->id;
    }

    public function getTitulo(){
        return $this->titulo;
    }

    public function getAudio(){
        return $this->audio;
    }
}
?>