<?php

class Vinilo{
    use MagicProperties;

    private $n = 1;

    public static function añade($titulo, $autor, $idAutor, $precio, $canciones, $portada){
        $v = new Vinilo($n, $titulo, $autor, $idAutor, $precio, $canciones, $portada);
        $n = $n + 1;
        return $v;
    }

    public static function buscaVinilos(){
        $result = [];
        
        $conn = BD::getInstance()->getConexionBd();
        
        $query = sprintf("SELECT * FROM vinilos");
        
        $rs = $conn->query($query);
        
        if($rs){
            
            while($fila = $rs->fetch_assoc()){
                $result[] = new Vinilo($fila['id'],$fila['titulo'],$fila['autor'],$fila['idAutor'],$fila['precio'],$fila['canciones'],$fila['portada']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorId($idVinilo){
        $result = null;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM vinilos V WHERE V.id = %d;", $idVinilo);
        $rs = $conn->query($query);
        if($rs && $rs->num_rows == 1){
            while($fila = $rs->fetch_assoc()){
                $result = new Vinilo($fila['id'],$fila['titulo'],$fila['autor'],$fila['idAutor'],$fila['precio'],$fila['canciones'],$fila['portada']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorTitulo($titulo = ''){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM Vinilos V WHERE V.titulo LIKE '%titulo_buscado%';",
            $conn->real_escape_string($titulo));

        $rs = $conn->query($query);
         
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Vinilo($fila['id'], $fila['titulo'], $fila['autor'],$fila['idAutor'], $fila['precio'], $fila['canciones'], $fila['portada']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorAutor($autor = ''){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM Vinilos V WHERE V.autor LIKE '%autor_buscado%';",
            $conn->real_escape_string($autor));

        $rs = $conn->query($query);
         
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Vinilo($fila['id'], $fila['titulo'], $fila['autor'], $fila['idAutor'], $fila['precio'], $fila['canciones'], $fila['portada']);
            }
            $rs->free();
        }
        return $result;
    }

    private static function inserta($vinilo){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO vinilos (id, titulo, autor, idAutor, precio, canciones, portada) VALUES (%d, %s, %s, %d, %d, %s, %s)",
            $conn->real_escape_string($vinilo->titulo),
            $conn->real_escape_string($vinilo->autor),
            $vinilo->idAutor,
            $vinilo->precio,
            $vinilo->real_escape_string($vinilo->canciones),
            $vinilo->real_escape_string($vinilo->portada)
        );
        $result = $conn->query($query);
        if($result){
            $vinilo->id = $conn->insert_id;
            $result = $vinilo;
        }
        else{
            error_log($conn->error);
        }
        return $result;
    }

    private static function actualiza($vinilo){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf(
            "UPDATE vinilos V SET titulo = %s, autor = %s, idAutor = %d, precio = %d, canciones = %s, portada = %s WHERE V.id = %d",
            $vinilo->id,
            $conn->real_escape_string($vinilo->autor),
            $vinilo->idAutor,
            $conn->real_escape_string($vinilo->titulo),
            $vinilo->idAutor,
            $vinilo->precio,
            $conn->real_escape_string($vinilo->canciones),
            $conn->real_escape_string($vinilo->portada)
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

    private static function borra($vinilo){
        return self::borraPorId($vinilo->id);
    }

    public static function borraPorId($idVinilo){
        if(!$idVinilo){
            return false;
        }
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM vinilos WHERE id = %d", $idVinilo);
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
    private $titulo;
    private $autor;
    private $idAutor;
    private $precio;
    private $canciones;
    private $portada;

    private function __construct($id,$titulo,$autor,$idAutor,$precio,$canciones,$portada){
        $this->id = $id !== null ? intval($id) : null;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->idAutor = intval($idAutor);
        $this->precio = intval($precio);
        $this->canciones = $canciones;
        $this->portada = $portada;
    }

    public function getId(){
        return $this->id;
    }

    public function getTitulo(){
        return $this->titulo;
    }

    public function setTitulo($nuevo){
        $this->titulo = $nuevo;
    }

    public function getAutor(){
        return $this->autor;
    }

    public function setAutor($nuevo){
        return $this->autor;
    }

    public function getIdAutor(){
        return $this->idAutor;
    }

    public function setIdAutor($nuevo){
        $this->idAutor = $nuevo;
    }

    public function getPrecio(){
        return $this->precio;
    }

    public function setPrecio($nuevo){
        return $this->precio = $nuevo;
    }

    public function getCanciones(){
        return $this->canciones;
    }

    public function getPortada(){
        return $this->portada;
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