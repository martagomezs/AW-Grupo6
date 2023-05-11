<?php
require_once 'autorizacion.php';

function saludo()
{
    $html = '';

    if (estaLogado()) {
        
        $html = <<<EOS
        Hola, {$_SESSION['nombre']}. Si quieres puedes <a href="logout.php"> cerrar sesión</a>
        EOS;
    } else {
        
        $html = <<<EOS
        Usuario desconocido. <a href="login.php">Login</a>
        EOS;
    }

    return $html;
}


