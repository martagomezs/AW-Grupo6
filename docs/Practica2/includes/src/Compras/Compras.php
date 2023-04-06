<?php

class Compra{
    use MagicProperties;

    public static function añade($user, $idVinilo, $compra){
        $c = new Compra($user, $idVinilo, $compra);
        return $c;
    }

    public static function buscaCesta($user){
        $result = [];
        
        $conn = BD::getInstance()->getConexionBd();
        
        $query = sprintf("SELECT * FROM compras WHERE user=%s", $user);
        
        $rs = $conn->query($query);
        
        if($rs){
            
            while($fila = $rs->fetch_assoc()){
                $result[] = new Compra($fila['user'],$fila['idVinilo'],$fila['compra']);
            }
            $rs->free();
        }
        return $result;
    }

    private static function inserta($compra){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO compras (user, idVinilo, compra) VALUES (%s, %d, %d)",
            $_SESSION['username'],
            $vinilo->id,
            1
        );
        $result = $conn->query($query);
        if($result){
            $compra->id = $conn->insert_id;
            $result = $compra;
        }
        else{
            error_log($conn->error);
        }
        return $result;
    }

    private static function actualiza($compra){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();

        // $query = sprintf(
        //     "UPDATE compra C SET user = %s, idVinilo = %d, compra = %d WHERE C.id = %d",
        //     $compra->user,
        //     $compra->idVinilo,
        //     $vinilo->idAutor,
        //     $vinilo->precio,
        //     $conn->real_escape_string($vinilo->portada),
        //     $vinilo->ventas
        // );
        $result = $conn->query($query);
        if(!$result){
            error_log($conn->error);
        }
        else if($conn->affected_rows != 1){
            error_log("Se han actualizado '$conn->affected_rows' ");
        }
        return $result;
    }

    private static function borra($compra){
        return self::borraPorId($compra->id);
    }

    public static function borraPorId($idCompra){
        if(!$idCompra){
            return false;
        }
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM vinilos WHERE id = %d", $idCompra);
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
    private $user;
    private $idVinilo;
    private $compra;

    private function __construct($id,$user,$idVinilo,$compra){
        $this->id = $id !== null ? intval($id) : null;
        $this->user = $user;
        $this->idVinilo = intval($idVinilo);
        $this->compra = $compra;
    }

    public function getId(){
        return $this->id;
    }

    public function getUser(){
        return $this->user;
    }

    public function setUser($nuevo){
        $this->user = $nuevo;
    }

    public function getIdVinilo(){
        return $this->idVinilo;
    }

    public function setIdVinilo($nuevo){
        return $this->idVinilo = $nuevo;
    }

    public function getCompra(){
        return $this->compra;
    }

    public function setCompra($nuevo){
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
            return self::borra($this);
        }
        return false;
    }
}

?>
