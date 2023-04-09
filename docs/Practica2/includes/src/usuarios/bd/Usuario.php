<?php

class Usuario
{

    use MagicProperties;

    public const ADMIN_ROLE = 1;

    public const USER_ROLE = 2;

    public static function login($nombreUsuario, $password)
    {
        $username = self::buscaUsuario($nombreUsuario);
        if ($username && $username->compruebaPassword($password)) {
             return true;
        }
        return false;
    }
    
    public static function crea($nombreUsuario, $password, $nombre, $correo)
    {
        $user = new Usuario($nombreUsuario, self::hashPassword($password), $nombre, $correo, 2, null);
        //$user->añadeRol($rol);
        return $user->guarda();
    }

    public static function buscaUsuario($nombreUsuario)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuarios U WHERE U.username='%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['username'], $fila['password'], $fila['nombre'], $fila['correo'], $fila['rol'], $fila['ventas']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorUsername($username)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuarios WHERE username=%s", $username);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['username'], $fila['password'], $fila['nombre'], $fila['correo'], $fila['rol'], $fila['ventas']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
   
    private static function inserta($usuario)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Usuarios(username, password, nombre, correo, rol, ventas) VALUES ('%s', '%s', '%s', '%s', %s, %d)"
            , $conn->real_escape_string($usuario->username)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->correo)
            , $conn->real_escape_string($usuario->rol)
            , $usuario->ventas 
        );
        if ( $conn->query($query) ) {
            $usuario->username = $conn->insert_id;
            //$result = self::insertaRoles($usuario);
            $result = $usuario;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    private static function actualiza($usuario)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Usuarios U SET nombre='%s', password='%s', correo='%s', rol='%s', ventas=%d WHERE U.username='%s'"
            , $conn->real_escape_string($usuario->username)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->correo)
            , $conn->real_escape_string($usuario->rol)
            , $usuario->ventas
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
    
    private static function borra($usuario)
    {
        return self::borraPorUsername($usuario->username);
    }
    
    private static function borraPorUsername($username)
    {
        if (!$username) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Usuarios U WHERE U.username = %s"
            , $username
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }


    private $username;

    private $password;

    private $nombre;

    private $correo;

    private $rol;

    private $ventas;

    private function __construct($username, $password, $nombre, $correo, $rol, $ventas)
    {
        $this->username = $username;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->rol = $rol;
        $this->ventas = $ventas;
    }

    public function getNombreUsuario()
    {
        return $this->username;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function getVentas()
    {
        return $this->ventas;
    }

    public function compruebaPassword($password)
    {
        //return password_verify($password, $this->password);
        return $password == $this->password;
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->password = self::hashPassword($nuevoPassword);
    }
    
    public function guarda()
    {
        //if (!$this->username) {
            self::inserta($this);
        //} 
        //else{
        //    self::actualiza($this);
        //}
        return $this;
    }
    
    public function borrate()
    {
        if ($this->username != null) {
            return self::borra($this);
        }
        return false;
    }
}
