<?php

class Comentario{
    use MagicProperties;

    public const MAX_SIZE = 140;

    public static function crea($idVinilo,$autor,$comentario,$padre = null){
        $m = new Comentario($idVinilo,$autor,$comentario,date('Y-m-d H:i:s'),$padre,self::numFilas() + 1);
        self::inserta($m);
        return $m;
    }

    private static function numFilas(){
        $result = 0;

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT COUNT(*) as total FROM Comentarios;");

        $rs = $conn->query($query);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result = $fila['total'];
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorPadre($padre){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM Comentarios WHERE ';
        if($padre){
            $query = $query . 'padre = %d';
            $query = sprintf($query, $padre);
        }
        else{
            $query = $query . 'padre IS NULL';
        }

        $query .= ' ORDER BY fecha DESC';

        $rs = $conn->query($query);
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Comentario($fila['idVinilo'], $fila['autor'], $fila['comentario'], $fila['fecha'], $fila['padre'], $fila['id']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function numComentarios($padre = null){
        $result = 0;

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT COUNT(*) FROM Comentarios';
        if($padre){
            $query = $query . ' AND padre = %d';
            $query = sprintf($query, $padre);
        }
        else{
            $query = $query . ' AND padre IS NULL';
        }

        $rs = $conn->query($query);
        if($rs){
            $result = (int) $rs->fetch_row[0];
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorId($id){
        $result = null;

        $conn = BD:: getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM Comentarios WHERE id = %d;', $id);
        $rs = $conn->query($query);
        if($rs && $rs->num_rows == 1){
            while($fila = $rs->fetch_assoc()){
                $result = new Comentario($fila['idVinilo'], $fila['autor'], $fila['comentario'], $fila['fecha'], $fila['padre'], $fila['id']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorVinilo($idVinilo){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM Comentarios WHERE idVinilo = %d AND padre IS NULL;', $idVinilo);
        $rs = $conn->query($query);
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = new Comentario($fila['idVinilo'], $fila['autor'], $fila['comentario'], $fila['fecha'], $fila['padre'], $fila['id']);
            }
            $rs->free();
        }
        return $result;
    }

    private static function inserta($comentario){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO Comentarios(idVinilo, autor, comentario, fecha, padre,id) VALUES (%d, '%s', '%s', '%s', %s, %d)",
            $comentario->idVinilo,
            $conn->real_escape_string($comentario->autor),
            $conn->real_escape_string($comentario->comentario),
            $conn->real_escape_string($comentario->fecha->format('Y-m-d H:i:s')),
            !is_null($comentario->padre) ? $comentario->padre : 'null',
            $comentario->id 
        );
        $result = $conn->query($query);
        if($result){
            $comentario->id = $conn->insert_id;
            $result = $comentario;
        }
        else{
            error_log($conn->error);
        }
        return $result;
    }

    private static function actualiza($comentario)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE Comentarios SET idVinilo = %d, autor = '%s', comentario = '%s', fecha = '%s', idMensajePadre = %s WHERE id = %d",
            $comentario->idVinilo,
            $conn->real_escape_string($comentario->autor),
            $conn->real_escape_string($comentario->comentario),
            $conn->real_escape_string($comentario->fecha),
            !is_null($comentario->padre) ? $comentario->padre : 'null',
            $comentario->id
        );
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han actualizado '$conn->affected_rows' !");
        }

        return $result;
    }

    private static function borra($comentario){
        return self::borraPorId($comentario->id);
    }
    
    public static function borraPorId($id)
    {
        if (!$id) {
            return false;
        }
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Comentarios WHERE id = %d", $id);
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }

    public static function borraPorUser($username)
    {
        if (!$username) {
            return false;
        }
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Comentarios WHERE autor = '%s'", $username);
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }

    private const DATE_FORMAT = 'Y-m-d H:i:s';

    private $id;
    private $idVinilo;
    private $autor;
    private $comentario;
    private $fecha;
    private $padre;

    private function __construct($idVinilo, $autor, $comentario, $fecha = null, $padre, $id){
        $this->idVinilo = intval($idVinilo);
        $this->autor = $autor;
        $this->comentario = $comentario;
        $this->fecha = $fecha !== null ? DateTime::createFromFormat(self::DATE_FORMAT, $fecha) : new DateTime();
        $this->padre = $padre !== null ? intval($padre) : null;
        $this->id = $id !== null ? intval($id) : null;
    }

    public function getId() {
        return $this->id;
    }

    public function getIdVinilo(){
        return $this->idVinilo;
    }

    public function setVinilo($nuevo){
        $this->vinilo = $nuevo;
    }

    public function getAutor(){
        return $this->autor;
    }

    public function setAutor($nuevo){
        $this->autor = $nuevo;
    }

    public function getComentario(){
        return $this->comentario;
    }

    public function setComentario($nuevo){
        if(mb_strlen($nuevo) > self::MAX_SIZE){
            throw new Exception(sprintf('El mensaje no puede exceder los %d caracteres', self::MAX_SIZE));
        }
        $this->comentario = $nuevo;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function getPadre(){
        if($this->padre){
            $this->padre = self::buscaPorId($this->padre);
        }
        return $this->padre;
    }

    public function setPadre($nuevo){
        $this->padre = $padre;
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
        if($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }
}

?>