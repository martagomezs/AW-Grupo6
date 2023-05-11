<?php
namespace es\ucm\fdi\aw\Seguir;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;
use es\ucm\fdi\aw\Artista\Artista;

class Seguir{
    use MagicProperties;

    public static function buscaSeguidores($idArtista){
        $result = 0;
        $conn = Aplicacion::getInstance()->getConexionBd();
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
        $conn = Aplicacion::getInstance()->getConexionBd();
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
        $conn = Aplicacion::getInstance()->getConexionBd();
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
        $conn = Aplicacion::getInstance()->getConexionBd();
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
        $conn  = Aplicacion::getInstance()->getConexionBd();
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

    public static function borraPorUsername($idUser){
        $conn  = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Seguidos WHERE idUser = '%s';",
            $idUser
        );
        $rs = $conn->query($query);
        if($rs){
            $artistas = Artista::buscaArtistas();
            foreach($artistas as $artista){
                $idArtista = $artista->id;
                $numSeguidores = Seguir::buscaSeguidores($idArtista);
                if(!Artista::actualizaSeguidores($idArtista, $numSeguidores)){
                    return false;
                }
            }
            return true;
        }
        else{
            return false;
        }
    }
    public static function borraPorArtista($idArtista){
        $conn  = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Seguidos WHERE idArtista = %d;",
            $idArtista
        );
        $rs = $conn->query($query);
        if($rs){
            return true;
        }
        else{
            return false;
        }
    }

}

?>