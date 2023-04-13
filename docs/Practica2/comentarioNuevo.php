<?php
require_once 'includes/config.php';
require_once 'includes/modelos/Comentario.php';
require_once 'includes/vistas/helpers/autorizacion.php';

if(!estaLogado()){
    Utils::paginaError(403, "Nuevo comentario", 'Usuario no conectado!', 'Debes iniciar sesión para poder añadir un comentario');
}
else{
    if(isset($_POST['comentario'])){
        $idVinilo = $_POST['idVinilo'];
        $autor = $_SESSION['username'];
        $comentario = $_POST['comentario'];
        $fecha = date('Y-m-d H:i:s');

        $nuevoComentario = new Comentario($idVinilo, $autor, $comentario, $fecha);
        $nuevoComentario->guarda();
        header("Location: comentarios.php?id=$idVinilo");
        exit();
    }
    else{
        Utils::paginaError(400, "Nuevo comentario", 'Error en formulario!', 'Debes rellenar todos los campos');
    }
}
?> 




<?php

require_once 'includes/config.php';
require_once 'includes/modelos/Comentario.php';
require_once 'includes/vistas/helpers/autorizacion.php';

// Si el usuario no está logueado, redirigimos a la página de inicio de sesión
if (!estaLogado()) {
  header('Location: login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $idVinilo = $_POST['idVinilo'];
  $comentario = $_POST['comentario'];

  $nuevoComentario = new Comentario($idVinilo, $_SESSION['username'], $comentario);
  $nuevoComentario->guarda();

  // Redirigimos al usuario a la página del vinilo
  header("Location: vinilo.php?id=$idVinilo");
  exit();
}

// Si llegamos aquí es porque estamos mostrando el formulario de nuevo comentario
$idVinilo = $_GET['vinilo'];
$tituloPagina = "Nuevo comentario";
$contenidoPrincipal = <<<EOS
  <h1>Nuevo comentario</h1>
  <form method="post" action="nuevoComentario.php">
    <input type="hidden" name="idVinilo" value="$idVinilo">
    <label for="comentario">Comentario:</label>
    <br>
    <textarea name="comentario" required></textarea>
    <br>
    <input type="submit" value="Enviar">
  </form>
EOS;

require 'includes/vistas/comun/layout.php';

*/
