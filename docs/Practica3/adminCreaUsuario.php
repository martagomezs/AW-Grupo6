<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$tituloPagina = 'Crear Usuarios';

if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}



if(isset($_POST['create'])){
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $correo = $_POST['correo'];
    if (!Usuario::buscaPorUsername($username)){
        if (Usuario::crea($username, $password, $nombre, $correo)){
            echo '<script>alert("Usuario creado con éxito.")</script>';
        }
    }
    else {
        echo '<script>alert("El nombre de usuario ya existe.")</script>';
    }
    
}

$contenidoPrincipal = '<h2>Crea Nuevo Usuario</h2>';

$contenidoPrincipal = <<<EOS
        <h2> Nuevo usuario </h2>
        <form method="post">
            <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required minlength="1" size="10">
            </div>
            <div>
            <label for="password">Contraseña:</label>
            <input type="text" id="password" name="password" required minlength="1" size="10">
            </div>
            <div>
            <label for="username">Nombre de usuario:</label>
            <input type="text" id="username" name="username" required minlength="1" size="10">
            </div>
            <div>
            <label for="correo">Correo:</label>
            <input type="text" id="correo" name="correo" required minlength="1" size="20">
            </div>
            <div>
            <input type="submit" name="create" value="Aceptar">
            </div>
        </form>        
EOS;


require 'includes/vistas/comun/layout.php';
?>