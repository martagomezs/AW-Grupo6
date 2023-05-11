<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Crear Artistas';

if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}



if(isset($_POST['create'])){
    $autor = $_POST['nombre'];
    $foto = 'img/utils/user.png';
    if (es\ucm\fdi\aw\Artista\Artista::insertaAdmin($autor, $foto)){
        echo '<script>alert("Artista creado con éxito.")</script>';
    }
}

$contenidoPrincipal = '<h2>Crea Nuevo Artista</h2>';

$contenidoPrincipal = <<<EOS
        <h2> Nuevo artista </h2>
        <form method="post">
            <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required minlength="1" size="10">
            </div>
            <div>
            <input type="submit" name="create" value="Aceptar">
            </div>
        </form>        
EOS;


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
?>