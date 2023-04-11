<?php

class Compra{
    use MagicProperties;

    public static function añade($user, $idsVinilos, $precio, $enCesta, $comprado, $fechaCompra){
        $c = new Compra($user, $idsVinilos, $precio, $enCesta, $comprado, $fechaCompra);
        return $c;
    }

    public static function buscaCesta($user){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM compras C WHERE C.enCesta = TRUE AND C.user = %s;", $conn->real_escape_string($user));

        $rs = $conn->query($query);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Compra($fila['user'],$fila['idsVinilos'],$fila['precio'],$fila['enCesta'],$fila['comprado'],$fila['fechaCompra']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaCompra($user){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM compras C WHERE C.comprado = TRUE AND C.user = %s;", $conn->real_escape_string($user));

        $rs = $conn->query($query);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Compra($fila['user'],$fila['idsVinilos'],$fila['precio'],$fila['enCesta'],$fila['comprado'],$fila['fechaCompra']);
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
                $result[] = new Compra($fila['user'],$fila['idsVinilos'],$fila['precio'],$fila['enCesta'],$fila['comprado'],$fila['fechaCompra']);
            }
            $rs->fila();
        }
        return $result;
    }

    public static function buscaPorVinilo($vinilo){
        $result = [];

        $conn = sprintf("SELECT * FROM compras C WHERE FIND_IN_SET(%d, C.idsVinilos) > 0", $vinilo);
        $rs = $conn->query($query);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Compra($fila['user'],$fila['idsVinilos'],$fila['precio'],$fila['enCesta'],$fila['comprado'],$fila['fechaCompra']);
            }
            $rs->free();
        }
        return $result;
    }

    private static function inserta($comp){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO compras (user, idsVinilos, precio, enCesta, comprado, fechaCompra) VALUES (%s, %s, %f, %d, %d, %s)",
            $conn->real_escape_string($comp->user),
            $comp->real_escape_string($comp->idsVinilos),
            $comp->precio,
            $comp->enCesta,
            $comp->comprado,
            $comp->fechaCompra
        );
        $result = $conn->query($query);
        if(!$result){
           error_log($conn->error);
        }
        return $result;
    }

    private static function actualiza($comp){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE compras C SET idsVinilos = %s, precio = %f, enCesta=%d, comprado=%d, fechaCompra=%s  WHERE C.user = %s",
            $conn->real_escape_string($comp->user),
            $comp->real_escape_string($comp->idsVinilos),
            $comp->precio,
            $comp->enCesta,
            $comp->comprado,
            $comp->fechaCompra
        );
        $result = $conn->query($query);
        if(!$result){
           error_log($conn->error); 
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
           error_log($conn->error); 
        }
        else if($conn->affected_rows != 1){
            error_log("Se ha borrado '$conn->affected_rows' ");
        }
        return $result;
    }

    private $user;
    private $idsVinilos;
    private $precio;
    private $enCesta;
    private $comprado;
    private $fechaCompra;

    private function __construct($user,$idsVinilos,$precio,$enCesta,$comprado,$fechaCompra){
        $this->user = $user;
        $this->idsVinilos = $idsVinilos;
        $this->precio = $precio;
        $this->enCesta = $enCesta;
        $this->comprado = $comprado;
        $this->fechaCompra = $fechaCompra;
    }

    public function getUser(){
        return $this->user;
    }

    public function getVinilos(){
        return $this->idsVinilos;
    }

    public function getPrecio(){
        return $this->precio;
    }

    public function setPrecio($nuevo){
        $this->precio = $nuevo;
    }
    
    public function getEnCesta(){
        return $this->enCesta;
    }

    public function setEnCesta($nuevo){
        $this->enCesta = $nuevo;
    }
    
    public function getComprado(){
        return $this->comprado;
    }

    public function setComprado($nuevo){
        $this->comprado = $nuevo;
    }

    public function getFechaCompra(){
        return $this->fechaCompra;
    }

    public function setFechaCompra($nuevo){
        $this->fechaCompra = $nuevo;
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