<?php

class Vinilo{
    use MagicProperties;

    public int id = 1;

    public static function añade($titulo, $idAutor, $precio, $canciones, $portada){
        $v = new Vinilo(id, $titulo, $idAutor, $precio, $canciones, $portada);
        return $v;
    }

    public static function buscaPorId($idVinilo){
        $result = null;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM vinilos V WHERE V.id = %d;', $idVinilo);
        $rs = $conn->query($query);
        if($rs && $rs->num_rows == 1){
            while($fila = $rs->fetch_assoc()){
                $result = new Vinilo($fila['id'],$fila['titulo'],$fila['autor'],$fila['precio'],$fila['canciones'],$fila['portada']);
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
                $result[] = new Vinilo($fila['id'], $fila['titulo'], $fila['autor'], $fila['precio'], )
            }
        }
    }

    private static function inserta($vinilo){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO vinilos (titulo, autor, precio, canciones, portada) VALUES (%d, '%s', %d, %d, ?,?)",
            $conn->real_escape_string($vinilo->titulo),
            $vinilo->idAutor,
            $vinilo->precio,
            $vinilo->canciones,
            $vinilo->portada
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
}

?>