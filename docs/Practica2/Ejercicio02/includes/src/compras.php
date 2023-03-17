<?php

class Compra{
    use MagicProperties;

    public static function añade($user, $idVinilo, $compra){
        $c = new Compra($user,$idVinilo,$compra);
        return $c;
    }

    public static function buscaCesta($user){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM compras C WHERE C.compra = FALSE AND C.User = %s;", $conn->real_escape_string($user));

        $rs = $conn->query($query);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Compra($fila['User'],$fila['Id-Vinilo'],$fila['compra']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaCompra(){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM compras C WHERE C.compra = TRUE");

        $rs = $conn->query($query);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Compra($fila['User'],$fila['Id-Vinilo'],$fila['compra']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorUser($username){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM compras C WHERE C.User = %s", 
                $conn->real_escape_string($username));
        $rs = $conn->query($query);
        if($rs && $rs->num_rows == 1){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Compra($fila['User'],$fila['Id-Vinilo'],$fila['compra']);
            }
            $rs->fila();
        }
        return $result;
    }

    public static function buscaPorVinilo($vinilo){
        $result = [];

        $conn = sprintf("SELECT * FROM compras C WHERE C.Id-Vinilo = %d", $vinilo);
        $rs = $conn->query($query);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Compra($fila['User'],$fila['Id-Vinilo'],$fila['compra']);
            }
            $rs->free();
        }
        return $result;
    }

    private static function inserta($comp){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO compras (User, Id-Vinilo, compra) VALUES (%s, %d, %d)",
            $conn->real_escape_string($comp->user);
            $comp->idVinilo;
            $comp->compra;
        );
        $result = $conn->query($query);
        if(!$result){
           error_log($conn->error), 
        }
        return $result;
    }

    private static function actualiza($comp){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE compras C SET IdVinilo = %d, compra = %d WHERE C.user = %s",
            $conn->real_escape_string($comp->user);
            $comp->idVinilo;
            $comp->compra;
        );
        $result = $conn->query($query);
        if(!$result){
           error_log($conn->error), 
        }
        else if($conn->affected_rows != 1){
            error_log("Se han actualizado '$conn->affected_rows' ");
        }
        return $result;
    }

    private static function borra($comp){
        return self::borraPorUser($comp->user);
    }

    public static function borraPorUser($user){
        if(!$user){
            return false;
        }
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM compras WHERE user = %s",$user);
        $result = $conn->query($query);
        if(!$result){
           error_log($conn->error), 
        }
        else if($conn->affected_rows != 1){
            error_log("Se ha borrado '$conn->affected_rows' ");
        }
        return $result;
    }

    private $user;
    private $idVinilo;
    private $compra;

    private function __construct($user,$idVinilo,$compra){
        $this->user = $user;
        $this->idVinilo = $idVinilo;
        $this->compras = $compras;
    }

    public function getUser(){
        return $this->user;
    }

    public function getVinilo(){
        return $this->idVinilo;
    }

    public function getComp(){
        return $this->compra;
    }

    public function setComp($nuevo){
        $this->compra = $nuevo;
    }

    public function guarda(){
        if(!$this->id){
            self::inserta($this);
        }
        else{
            self::actualiza($this);
        }
        return $this;
    }

    public function borrate(){
        if($this->id != null){
            return self:: borra($this);
        }
        return $this;
    }

}

?>