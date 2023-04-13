<?php

class Artista{
    use MagicProperties;


    public static function añade($nombre,$seguidores,$eventos,$foto){
        $a = new Artista($nombre,$seguidores, $eventos,$foto);
        return $a;
    }

    public static function buscaArtistas(){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM artistas A ORDER BY A.seguidores DESC;");
        $rs = $conn->query($query);
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Artista($fila['id'],$fila['nombre'],$fila['seguidores'],$fila['eventos'],$fila['foto']);            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorId($idArtista){
        $result = null;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM artistas A WHERE A.id = %d;", $idArtista);
        $rs = $conn->query($query);
        if($rs && $rs->num_rows == 1){
            while($fila = $rs->fetch_assoc()){
                $result = new Artista($fila['id'], $fila['nombre'],$fila['seguidores'],$fila['eventos'],$fila['foto']);            }
            $rs->free();
        }
        return $result;
    }

    public static function nombrePorId($idArtista){
        $result = null;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT nombre FROM artistas A WHERE A.id = %d", $idArtista);
        $result = $conn->query($query);
        return $result;
    }

    public static function buscaPorNombre($nombre = ''){
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM artistas A WHERE A.nombre LIKE '%s';",
            $conn->real_escape_string($nombre));

        $rs = $conn->query($query);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Artista($fila['id'],$fila['nombre'],$fila['seguidores'],$fila['eventos'],$fila['foto']);            }
            $rs->free();
        }
        return $result;
    }

    private static function inserta($artista){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO artistas (id, nombre, seguidores, eventos, foto) VALUES (%d, '%s', %d, '%s', '%s')",
            $conn->real_escape_string($artista->nombre),
            $artista->seguidores,
            $conn->real_escape_string($artista->eventos),
            $conn->real_escape_string($artista->foto)
        );
        $result = $conn->query($query);
        if($result){
            $artista->id = $conn->insert_id;
            $result = $artista;
        }
        else{
            error_log($conn->error);
        }
        return $result;
    }
    
    private static function actualiza($artista){
        
        $result = false;

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf(
            "UPDATE artistas A set nombre = '%s', seguidores = %d, eventos = '%s', foto = '%s' WHERE A.id = %d",
            $conn->real_escape_string($artista->nombre),
            $artista->seguidores,
            $conn->real_escape_string($artista->eventos),
            $conn->real_escape_string($artista->foto),
            $artista->id
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

    public static function sumaSeguidores($idArtista){
        $artista = self::buscaPorId($idArtista);
        $artista->seguidores = $artista->seguidores + 1;
        return self::actualiza($artista);
    }

    public static function restaSeguidores($idArtista){
        $artista = self::buscaPorId($idArtista);
        $artista->seguidores = $artista->seguidores - 1;
        return self::actualiza($artista);
    }

    private static function borra($artista){
        return self::borraPorId($artista->id);
    }

    public static function borraPorId($idArtista){
        if(!$idArtista){
            return false;
        }
        $result = false;

        $conn = $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM artistas WHERE id = %d", $idArtista);
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
    private $nombre;
    private $seguidores;
    private $eventos;
    private $foto;

    private function __construct($id,$nombre,$seguidores,$eventos,$foto){
        $this->id = $id !== null ? intval($id) : null;
        $this->nombre = $nombre;
        $this->seguidores = intval($seguidores);
        $this->eventos = $eventos;
        $this->foto = $foto;
    }

    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nuevo){
        $this->nombre = $nuevo;
    }

    public function getSeguidores(){
        return $this->seguidores;
    }

    public function setSeguidores($nuevo){
        $this->seguidores = $nuevo;
    }

    public function getEventos(){
        return $this->eventos;
    }

    public function setEventos($nuevo){
        $this->eventos = $nuevo;
    }

    public function getFoto(){
        return $this->foto;
    }

    public function guarda(){
        if(!$this->id){
            self::insert($this);
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
