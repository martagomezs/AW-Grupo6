<?php
namespace es\ucm\fdi\aw;

use Exception;
use es\ucm\fdi\aw\Usuario\Usuario;

class Aplicacion{
    const ATRIBUTOS_PETICION = 'attsPeticion';

    private static $instancia;

    public static function getInstance(){
        if(!self::$instancia instanceof self){
            self::$instancia = new static();
        }
        return self::$instancia;
    }

    private $bdDatosConexion;

    private $rutaRaizApp;

    private $inicializada;

    private $generandoError;

    private $conn;

    private $atributosPeticion;

    private function __construct(){
        $this->inicializada = false;
        $this->generandoError = false;
    }

    public function init($bdDatosConexion, $rutaApp = '/', $dirInstalacion = __DIR__){

        if(!$this->inicializada){
            $this->bdDatosConexion = $bdDatosConexion;

            $this->rutaRaizApp = $rutaApp;

            $tamRutaRaizApp = mb_strlen($this->rutaRaizApp);
            if($tamRutaRaizApp > 0 && mb_substr($this->rutaRaizApp, $tamRutaRaizApp-1, 1) === '/') {
                $this->rutaRaizApp = mb_substr($this->rutaRaizApp, 0, $tamRutaRaizApp - 1);
            }

            $this->dirInstalacion = $dirInstalacion;
            $tamDirInstalacion = mb_strlen($this->dirInstalacion);
            if($tamDirInstalacion > 0){
                $ultimoChar = mb_substr($this->dirInstalacion, $tamDirInstalacion-1, 1);
                if ($ultimoChar === DIRECTORY_SEPARATOR || $ultimoChar === '/') {
                    $this->dirInstalacion = mb_substr($this->dirInstalacion, 0, $tamDirInstalacion-1);
                }
            }

            $this->conn = null;
            session_start();

            $this->atributosPeticion = $_SESSION[self::ATRIBUTOS_PETICION] ?? [];
            unset($_SESSION[self::ATRIBUTOS_PETICION]);

            $this->inicializada = true;
        }
    }

    public function shutdown(){
        $this->compruebaInstanciaInicializada();
        if($this->conn !== null && !$this->conn->connect_errno) {
            $this->conn->close();
        }
    }

    private function compruebaInstanciaInicializada(){
        if(!$this->inicializada && $this->generandoError){
            $this->paginaError(502, 'Error', 'Oops', 'La aplicacion no esta configurada. Tienes que modificar el fichero.php');
        }
    }

    public function getConexionBd(){
        $this->compruebaInstanciaInicializada();
        if(!$this->conn){
            $bdHost = $this->bdDatosConexion['host'];
            $bdUser = $this->bdDatosConexion['user'];
            $bdPass = $this->bdDatosConexion['pass'];
            $bd = $this->bdDatosConexion['bd'];

            $conn = new \mysqli($bdHost,$bdUser,$bdPass,$bd);
            if($conn->connect_errno){
                echo "Error de Conexion a la BD ({$conn->connect_errno}): {$conn->connect_error}";
                exit();
            }
            if(!$conn->set_charset("utf8mb4")) {
                echo "Error al configurar la BD ({$conn->errno}): {$conn_error}";
                exit(); 
            }
            $this->conn = $conn;
        }
        return $this->conn;
    }

    public function resuelve($path = ''){
        $this->compruebaInstanciaInicializada();
        $rutaAppLongitudPrefijo = mb_strlen($this->rutaRaizApp);
        if(mb_substr($path, 0, $rutaAppLongitudPrefijo) === $this->rutaRaizApp){
            return $path;
        }
        if(mb_strlen($path) > 0 && mb_substr($path, 0, 1) !== '/'){
            $path = '/' .$path;
        }
        return $this->rutaRaizApp . $path;
    }

    public function doInclude($path = '', &$params= []){
        $this->compruebaInstanciaInicializada();
        $this->doIncludeInterna($path, $params);
    }

    private function doIncludeInterna($path, &$params){
        $this->compruebaInstanciaInicializada();

        if(mb_strlen($path) > 0 && mb_substr($path, 0, 1) !== '/') {
            $path = '/' . $path;
        }

        include($this->dirInstalacion . $path);
    }

    public function generaVista(string $rutaVista, &$params){
        $this->compruebaInstanciaInicializada();
        $params['app'] = $this;
        if(mb_strlen($rutaVista) > 0 && mb_substr($rutaVista, 0, 1) !== '/') {
            $rutaVista = '/' . $rutaVista;
        }
        $rutaVista = "/vistas{$rutaVista}";
        $this->doIncludeInterna($rutaVista, $params);
    }

    public function login(Usuario $user){
        $this->compruebaInstanciaInicializada();
        $_SESSION['login'] = true;
        $_SESSION['nombre'] = $user->getNombre();
        $_SESSION['username'] = $user->getUsername();
    }

    public function logout() {
        $this->compruebaInstanciaInicializada();
        unset($_SESSION['login']);
        unset($_SESSION['nombre']);
        unset($_SESSION['username']);

        session_destroy();
        session_start();
    }

    public function usuarioLogueado(){
        $this->compruebaInstanciaInicializada();
        return ($_SESSION['login'] ?? false) === true;
    }

    public function nombreUsuario(){
        $this->compruebaInstanciaInicializada();
        return $_SESSION['nombre'] ?? '';
    }

    public function username(){
        $this->compruebaInstanciaInicializada();
        return $_SESSION['username'] ?? '';
    }

    public function esAdmin(){
        $this->compruebaInstanciaInicializada();
        return $this->usuarioLogueado() && (($_SESSION['rol'] == 'admin') !== false);
    }

    public function paginaError($codigoRespuesta, $tituloPagina, $mensajeError, $explicacion = ''){
        $this->generandoError = true;
        http_response_code($codigoRespuesta);

        $params =  ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => "<h1>{$mensajeError}</h1><p>{$explicacion}</p>"];
        $this->generaVista('/comun/layout.php', $params);
        exit();
    }

    public function verificaLogado($urlNoLogado){
        $this->compruebaInstanciaInicializada();
        if(!$this->usuarioLogueado()){
            self::redirige($urlNoLogado);
        }
    }

    public function getAtributoPeticion($clave){
        $result = $this->atributosPeticion[$clave] ?? null;
        if (is_null($result) && isset($_SESSION[self::ATRIBUTOS_PETICION])) {
            $result = $_SESSION[self::ATRIBUTOS_PETICION][$clave] ?? null;
        }
        return $result;
    }

    public static function redirige($url){
        header('Location: ' . $url);
        exit();
    }

    public function buildUrl($relativeURL, $params = []){
        $url = $this->resuelve($relativeURL);
        $query = self::buildParams($params);
        if(!empty($query)) {
            $url .= '?' . $query;
        }
        return $url;
    }

    public static function buildParams($params, $separator = '&', $enclosing = ''){
        $query = '';
        $numParams = 0;
        foreach ($params as $param => $value){
            if($value != null) {
                if($numParams > 0){
                    $query .= $separator;
                }
                $query .= "{$param}={$enclosing}{$value}{$enclosing}";
                $numParams++;
            }
        }
        return $query;
    }
}
?>