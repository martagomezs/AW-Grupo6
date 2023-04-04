<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/comentario.php';
require_once 'includes/vistas/helpers/vinilos.php';

/* $id = $_GET['user'];
$artista = Artista::buscaPorId($id);

$tituloPagina = "{$artista->nombre}";

$contenidoPrincipal=<<<EOS
	<h1>{$artista->nombre}</h1>
	<img src="{$artista->foto}" width="400">
	<p>Seguidores: {$artista->seguidores}</p>
	<p>Discografía:</p>
EOS;
	$vinilos = Vinilo::buscaPorAutor($artista->id);
	foreach($vinilos as $vinilo){
		$contenidoPrincipal .= '<a href="vinilo.php?id=' . $vinilo->id . '"><img src="' . $vinilo->portada . '" width="200"></a>';
	}
	$contenidoPrincipal .= '<p>Insertar calendario</p>';


require 'includes/vistas/comun/layout.php';


 */































/* // Conectar a la base de datos
$servername = "localhost";
$username = "Usuario";
$password = "userpass";
$dbname = "mysql";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Comprobar la conexión
if (!$connr) {
  die("Conexión fallida: " . mysqli_connect_error());
}

// Obtención del ID del vinilo seleccionado
if (isset($_GET['id'])) {
  $vinilo_id = $_GET['id'];
} else {
  echo "Error: No se ha seleccionado ningún vinilo.";
  exit;
}

// Obtener la información del vinilo de la base de datos
$sql = "SELECT * FROM vinilos WHERE id =  $vinilo_id";
$resultado = mysqli_query($conn, $sql);

if ($resultado->num_rows > 0) {
  // Mostrar la información del vinilo
  $row = $resultado->fetch_assoc();
  echo "<h1>" . $row["titulo"] . " - " . $row["artista"] . "</h1>";
  echo "<img src='" . $row["portada"] . "' alt='" . $row["titulo"] . "'>";

  // Mostrar el formulario para valorar el vinilo
  echo "<h2>Valorar</h2>";
  echo "<form method='POST' action='valorar.php'>";
  echo "<input type='hidden' name='vinilo_id' value='" . $row["id"] . "'>";
  echo "Puntuación: ";
  echo "<select name='puntuacion'>";
  echo "<option value='1'>1 estrella</option>";
  echo "<option value='2'>2 estrellas</option>";
  echo "<option value='3'>3 estrellas</option>";
  echo "<option value='4'>4 estrellas</option>";
  echo "<option value='5'>5 estrellas</option>";
  echo "</select><br>";
  echo "<input type='submit' value='Enviar'>";
  echo "</form>";

  // Mostrar los comentarios existentes
  echo "<h2>Comentarios</h2>";
  $sql = "SELECT * FROM comentarios WHERE vinilo_id =  $vinilo_id";
  $resultado = mysqli_query($conn, $sql);

  if ($resultado->num_rows > 0) {
    while($row = $resultado->fetch_assoc()) {
      echo "<p><strong>" . $row["nombre"] . "</strong> - " . $row["comentario"] . "</p>";
    }
  } else {
    echo "<p>No hay comentarios todavía </p>";
  } 
} */


?>
