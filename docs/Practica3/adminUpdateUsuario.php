<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$tituloPagina = 'Actualizar Usuarios';
$usuarios = Usuario::buscaUsuarios();
if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}



if(isset($_POST['update'])){
    if(isset($_POST['username'])){
        $nuevo = Usuario::buscaPorUsername($_POST['username']);
    }
    if(isset($_POST['nombre'])){
        if(Usuario::actualizaNombreAdmin($_POST['nombre'],$_POST['username'])){
            echo '<script>alert("Nombre de usuario actualizado.")</script>';
        }
    }
    if(isset($_POST['correo'])){
        if(Usuario::actualizaCorreoAdmin($_POST['correo'],$_POST['username'])){
            echo '<script>alert("Correo actualizado.")</script>';
        }
    }
    
}

$contenidoPrincipal = '<h2>Lista de Usuarios</h2>';
$contenidoPrincipal .= '<p>Selecciona el usuario que quieres actualizar</p>';

$contenidoPrincipal .= '<form method="post">';

foreach($usuarios as $usuario){
    $contenidoPrincipal .= '<input type="radio" id="'.$usuario->username.'" name="usuario" value="'.$usuario->username.'">';
    $contenidoPrincipal .= '<label for="'.$usuario->username.'">'. $usuario->username .'</label>';
}
$contenidoPrincipal .= '<br><input type="submit" id="sel" name="boton" value="Aceptar" >';
$contenidoPrincipal .= '</form>';

if(isset($_POST['boton'])){
    $nuevo = Usuario::buscaPorUsername($_POST['usuario']);
    $contenidoPrincipal = <<<EOS
            <h1>$nuevo->username</h1>
            <form method="post">
                <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="{$nuevo->nombre}" value="{$nuevo->nombre}">
                </div>
                <div>
                <label for="correo">Correo:</label>
                <input type="text" id="correo" name="correo" placeholder="{$nuevo->correo}" value="{$nuevo->correo}">
                </div>
                <div>
                <input type="hidden" name="username" value="{$nuevo->username}">
                </div>
                <div>
                <input type="submit" name="update" value="Aceptar">
                </div>
                
            </form>
    EOS;
}


require 'includes/vistas/comun/layout.php';
?>