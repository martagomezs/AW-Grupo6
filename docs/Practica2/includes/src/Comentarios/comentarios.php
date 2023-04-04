<?php

class Comentario{
    use MagicProperties;


    public static function añade($vinilo_id,$autor,$comentario,$fecha,$padre){
        $c = new Comentario($vinilo_id,$autor,$comentario,$fecha,$padre);
        return $c;
    }

    public static function buscaComentarios($vinilo_id){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM comentarios C WHERE C.vinilo_id = %d ORDER BY C.fecha DESC;", $vinilo_id);
        $rs = $conn->query($query);
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Comentario($fila['id'],$fila['vinilo_id'],$fila['autor'],$fila['comentario'],$fila['fecha'],$fila['padre']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorId($idComent){
        $result = null;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM comentarios C WHERE C.id = %d;", $idComent);
        $rs = $conn->query($query);
        if($rs && $rs->num_rows == 1){
            while($fila = $rs->fetch_assoc()){
                $result = new Comentario($fila['id'], $fila['vinilo_id'], $fila['autor'],$fila['comentario'],$fila['fecha'],$fila['padre']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorAutor($autor = ''){
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM comentarios C WHERE C.autor LIKE '%a';",
            $conn->real_escape_string($nombre));

        $rs = $conn->query($query);

        if($rs && $rs->num_rows == 1){
            while($fila = $rs->fetch_assoc()){
                $result = new Comentario($fila['id'], $fila['vinilo_id'], $fila['autor'],$fila['comentario'],$fila['fecha'],$fila['padre']);
            }
            $rs->free();
        }
        return $result;
    }

    private static function inserta($coment){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO comentarios (id, vinilo_id, autor, comentario, fecha, padre) VALUES (%d, %d, %s, %s, CURRENT_TIMESTAMP, %d)",
            $coment->vinilo_id,
            $conn->real_escape_string($coment->autor),
            $conn->real_escape_string($coment->comentario),
            date('Y-m-d H:i:s', strtotime($coment->fecha)),
            $coment->padre
        );
        $result = $conn->query($query);
        if($result){
            $coment->id = $conn->insert_id;
            $result = $coment;
        }
        else{
            error_log($conn->error);
        }
        return $result;
    }
    
    private static function actualiza($coment){
        
        $result = false;

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf(

            "UPDATE comentarios SET vinilo_id = %d, autor = '%s', comentario = '%s', fecha = '%s', padre = %d WHERE id = %d",
            $coment->vinilo_id,
            $conn->real_escape_string($coment->autor),
            $conn->real_escape_string($coment->comentario),
            date('Y-m-d H:i:s', strtotime($coment->fecha)),
            $coment->padre

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

    private static function borra($coment){
        return self::borraPorId($coment->id);
    }

    public static function borraPorId($idComent){
        if(!$idComent){
            return false;
        }
        $result = false;

        $conn = $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM comentarios WHERE id = %d", $idComent);
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
    private $vinilo_id;
    private $autor;
    private $comentario;
    private $fecha;
    private $padre;

    
    private function __construct($id,$vinilo_id,$autor,$comentario,$fecha,$padre) {
        $this->id = $id !== null ? intval($id) : null;
        $this->vinilo_id = intval($vinilo_id);
        $this->autor = $autor;
        $this->comentario = $comentario;
        $this->fecha = $fecha;
        $this->padre = intval($padre);
    }

    public function getId() {
        return $this->id;
    }
    
    public function getViniloId() {
        return $this->vinilo_id;
    }
    
    public function setViniloId() {
        $this->vinilo_id = $vinilo_id;
    }

    public function getAutor() {
        return $this->autor;
    }
    
    public function setAutor() {
        $this->autor = $autor;
    }

    public function getComentario() {
        return $this->comentario;
    }
    
    public function setComentario() {
        $this->comentariom = $comentario;
    }

    public function getFecha() {
        return $this->fecha;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getPadre() {
        return $this->padre;
    }

    public function setPadre() {
        $this->padre = $padre;
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
