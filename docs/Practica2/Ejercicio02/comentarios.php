<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "mysql";

$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Obtener la información del vinilo de la base de datos
$sql = "SELECT * FROM vinilos WHERE id = 1"; // Cambiar "1" por el ID del vinilo que se desea mostrar
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Mostrar la información del vinilo
  $row = $result->fetch_assoc();
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
  $sql = "SELECT * FROM comentarios WHERE vinilo_id = 1"; // Cambiar "1" por el ID del vinilo que se desea mostrar
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "<p><strong>" . $row["nombre"] . "</strong> - " . $row["comentario"] . "</p>";
    }
  } else {
    echo "<p>No hay comentarios todavía </p>";
  }
}
