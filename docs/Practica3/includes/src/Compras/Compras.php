<?php

class Compra{
    use MagicProperties;

    public static function añade($user, $idVinilo, $precio, $enCesta, $comprado, $fechaCompra){
        $c = new Compra(self::numFilas() + 1,$user, $idVinilo, $precio, $enCesta, $comprado, $fechaCompra);
        return $c;
    }

    private static function numFilas(){
        $result = 0;

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT COUNT(*) as total FROM compras;");

        $rs = $conn->query($query);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result = $fila['total'];
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaCesta($user){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM compras C WHERE C.enCesta = TRUE AND C.user = '%s';", $conn->real_escape_string($user));

        $rs = $conn->query($query);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Compra($fila['id'],$fila['user'],$fila['idVinilo'],$fila['precio'],$fila['enC esta'],$fila['comprado'],$fila['fechaCompra']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaCompra($user){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM compras C WHERE C.comprado = TRUE AND C.user = '%s';", $conn->real_escape_string($user));

        $rs = $conn->query($query);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Compra($fila['id'],$fila['user'],$fila['idVinilo'],$fila['precio'],$fila['enCesta'],$fila['comprado'],$fila['fechaCompra']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorUser($username){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM compras C WHERE C.User = '%s'", 
                $conn->real_escape_string($username));
        $rs = $conn->query($query);
        if($rs && $rs->num_rows == 1){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Compra($fila['id'],$fila['user'],$fila['idVinilo'],$fila['precio'],$fila['enCesta'],$fila['comprado'],$fila['fechaCompra']);
            }
            $rs->fila();
        }
        return $result;
    }

    public static function buscaPorVinilo($vinilo){
        $result = [];

        $conn = sprintf("SELECT * FROM compras C WHERE C.idVinilo = %d", $vinilo->id);
        $rs = $conn->query($query);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Compra($fila['id'],$fila['user'],$fila['idVinilo'],$fila['precio'],$fila['enCesta'],$fila['comprado'],$fila['fechaCompra']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function inserta($comp){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO compras (user, idVinilo, precio, enCesta, comprado, fechaCompra) VALUES ('%s', %d, %f, %d, %d, '%s')",
            $conn->real_escape_string($comp->user),
            $comp->idVinilo,
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
            "UPDATE compras SET idVinilo = %d, precio = %f, enCesta=%d, comprado=%d, fechaCompra='%s'  WHERE user = '%s'",
            $comp->idVinilo,
            $comp->precio,
            $comp->enCesta,
            $comp->comprado,
            $comp->fechaCompra,
            $conn->real_escape_string($comp->user)
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

    public static function eliminaElementoCesta($idCesta){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM compras WHERE id = %d", $idCesta);
        $conn->query($query); 
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
        $query = sprintf("DELETE FROM compras WHERE user = '%s'",$user);
        $result = $conn->query($query);
        if(!$result){
           error_log($conn->error); 
        }
        else if($conn->affected_rows != 1){
            error_log("Se ha borrado '$conn->affected_rows' ");
        }
        return $result;
    }

    public static function actualizaCestaCompra($user){
        $fecha_actual = date('Y-m-d');
	    $cesta = Compra::buscaCesta($user);
	    foreach($cesta as $c){
            $conn = BD::getInstance()->getConexionBd();
            $query = sprintf(
            "UPDATE compras SET enCesta=%d, comprado=%d, fechaCompra='%s'  WHERE user = '%s'",
            0, 
            1,
            $fecha_actual,
            $conn->real_escape_string($user)
            );
            $conn->query($query);
        }
    }

    private $id;
    private $user;
    private $idVinilo;
    private $precio;
    private $enCesta;
    private $comprado;
    private $fechaCompra;

    private function __construct($id,$user,$idVinilo,$precio,$enCesta,$comprado,$fechaCompra){
        $this->id = $id !== null ? intval($id) : null;
        $this->user = $user;
        $this->idVinilo = $idVinilo;
        $this->precio = $precio;
        $this->enCesta = $enCesta;
        $this->comprado = $comprado;
        $this->fechaCompra = $fechaCompra;
    }

    public function getId(){
        return $this->id;
    }

    public function getUser(){
        return $this->user;
    }

    public function getIdVinilo(){
        return $this->idVinilo;
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
        self::inserta($this);
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