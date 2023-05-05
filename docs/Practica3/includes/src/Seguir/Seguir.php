<?php

class Seguir{
    use MagicProperties;

    public static function buscaSeguidores($idArtista){
        $result = 0;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT COUNT(*) as num FROM Seguidos WHERE idArtista = %d;", $idArtista);
        $rs = $conn->query($query);
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result = $fila['num'];
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaSeguidos($idUser){
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Seguidos WHERE idUser = '%s';", 
            $conn->real_escape_string($idUser)
        );
        $rs = $conn->query($query);
        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result[] = $fila['idArtista'];
            }
            $rs->free();
        }
        return $result;
    }

    public static function siguiendo($idArtista,$idUser){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Seguidos WHERE idArtista = %d AND idUser = '%s'",
            $idArtista, 
            $conn->real_escape_string($idUser)
        );
        $rs = $conn->query($query);
        if($rs && $rs->num_rows > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public static function seguir($idArtista,$idUser){
        $conn = BD::getInstance()->getConexionBd();
        if(self::siguiendo($idArtista,$idUser)){
            return false;
        }
        $query = sprintf("INSERT INTO Seguidos (idArtista, idUser) VALUES (%d, '%s')",
            $idArtista, 
            $conn->real_escape_string($idUser)
        );
        $rs = $conn->query($query);
        if($rs){
            Artista::sumaSeguidores($idArtista);
            return true;
        }
        else{
            return false;
        }
    }

    public static function dejarDeSeguir($idArtista,$idUser){
        $conn  = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Seguidos WHERE idArtista = %d AND idUser = '%s';",
            $idArtista,
            $conn->real_escape_string($idUser)
        );
        $rs = $conn->query($query);
        if($rs){
            Artista::restaSeguidores($idArtista);
            return true;
        }
        else{
            return false;
        }
    }

}

?>