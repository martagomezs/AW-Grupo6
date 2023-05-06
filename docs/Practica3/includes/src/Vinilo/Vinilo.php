<?php

class Vinilo{
    use MagicProperties;

    public static function añade($id, $titulo, $autor, $idAutor, $precio, $portada, $ventas, $stock){
        $v = new Vinilo($id, $titulo, $autor, $idAutor, $precio, $portada, $ventas, $stock);
        return $v;
    }

    public static function buscaVinilos(){
        $result = [];
        
        $conn = BD::getInstance()->getConexionBd();
        
        $query = sprintf("SELECT * FROM vinilos ORDER BY ventas DESC");
        
        $rs = $conn->query($query);
        
        if($rs){
            
            while($fila = $rs->fetch_assoc()){
                $result[] = new Vinilo($fila['id'],$fila['titulo'],$fila['autor'],$fila['idAutor'],$fila['precio'],$fila['portada'],$fila['ventas'],$fila['stock']);
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
                $result = new Vinilo($fila['id'],$fila['titulo'],$fila['autor'],$fila['idAutor'],$fila['precio'],$fila['portada'],$fila['ventas'],$fila['stock']);
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
                $result[] = new Vinilo($fila['id'], $fila['titulo'], $fila['autor'],$fila['idAutor'], $fila['precio'], $fila['portada'],$fila['ventas'],$fila['stock']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorAutor($autor){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM Vinilos V WHERE V.idAutor = %d;", $autor);

        $rs = $conn->query($query);
         
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Vinilo($fila['id'], $fila['titulo'], $fila['autor'], $fila['idAutor'], $fila['precio'], $fila['portada'],$fila['ventas'],$fila['stock']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function inserta($vinilo){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO vinilos (titulo, autor, idAutor, precio, portada, ventas, stock) VALUES (%d, %s, %s, %d, %d, %s, %d, %d)",
            $conn->real_escape_string($vinilo->titulo),
            $conn->real_escape_string($vinilo->autor),
            $vinilo->idAutor,
            $vinilo->precio,
            $conn->real_escape_string($vinilo->portada),
            $vinilo->ventas,
            $vinilo->stock
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

    public static function insertaAdmin($titulo, $autor, $idAutor, $precio, $portada, $ventas, $stock){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO vinilos (titulo, autor, idAutor, precio, portada, ventas, stock) VALUES ('%s', '%s', %d, %d, '%s', %d, %d)",
            $titulo,
            $autor, 
            $idAutor,
            $precio,
            $portada,
            $ventas,
            $stock
        );
        $result = $conn->query($query);
        return $result;
    }

    private static function actualiza($vinilo){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf(
            "UPDATE vinilos V SET titulo = %s, autor = %s, idAutor = %d, precio = %d, portada = %s, ventas = %d, stock = %d WHERE V.id = %d",
            $vinilo->id,
            $conn->real_escape_string($vinilo->autor),
            $vinilo->idAutor,
            $conn->real_escape_string($vinilo->titulo),
            $vinilo->idAutor,
            $vinilo->precio,
            $conn->real_escape_string($vinilo->portada),
            $vinilo->ventas,
            $vinilo->stock
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

    public static function actualizaPrecioAdmin($precio, $id){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf(
            "UPDATE vinilos V SET precio = %d WHERE V.id = %d",
            $precio,
            $id
        );
        $result = $conn->query($query);
        return $result;
    }

    public static function actualizaStockAdmin($stock, $id){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf(
            "UPDATE vinilos V SET stock = %d WHERE V.id = %d",
            $stock, 
            $id
        );
        $result = $conn->query($query);
        return $result;
    }

    public static function actualizaNombreArtistaAdmin($nombre, $idAutor){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf(
            "UPDATE vinilos V SET V.autor = '%s' WHERE V.idAutor = %d",
            $nombre,
            $idAutor
        );
        $result = $conn->query($query);
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
        if(!Compra::borraPorVinilo($idVinilo)){
            return false;
        }
        if(!Comentario::borraPorVinilo($idVinilo)){
            return false;
        }
        if(!Cancion::borraPorVinilo($idVinilo)){
            return false;
        }
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

    public static function borraPorArtista($idArtista){
        if(!$idArtista){
            return false;
        }
        $vinilos = self::buscaPorAutor($idArtista);
        foreach($vinilos as $vinilo){
            $idVinilo = $vinilo->id;
            if(!Vinilo::borraPorId($idVinilo)){
                return false;
            }
        }
        return true;
    }

    private $id;
    private $titulo;
    private $autor;
    private $idAutor;
    private $precio;
    private $portada;
    private $ventas;
    private $stock;

    private function __construct($id,$titulo,$autor,$idAutor,$precio,$portada,$ventas,$stock){
        $this->id = $id !== null ? intval($id) : null;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->idAutor = intval($idAutor);
        $this->precio = intval($precio);
        $this->portada = $portada;
        $this->ventas = $ventas;
        $this->stock = $stock;
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
        return $this->autor = $nuevo;
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

    public function getPortada(){
        return $this->portada;
    }

    public function getVentas(){
        return $this->ventas;
    }

    public function setVentas($nuevo){
        $this->ventas = $nuevo;
    }

    public function getStock(){
        return $this->stock;
    }

    public function setStock($nuevo){
        $this->stock = $nuevo;
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
