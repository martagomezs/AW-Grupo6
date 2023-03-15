<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "Usuario";
$password = "userpass";
$dbname = "mysql";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Comprobación de errores en la conexión
if (!$conn) {
  die("Conexión fallida: " . mysqli_connect_error());
}

// Obtención del ID del vinilo seleccionado
if (isset($_GET['id'])) {
  $vinilo_id = $_GET['id'];
} else {
  echo "Error: No se ha seleccionado ningún vinilo.";
  exit;
}

// Obtención de la información del vinilo
$sql = "SELECT * FROM vinilos WHERE id = $vinilo_id";
$resultado = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) > 0) {
  $vinilo = mysqli_fetch_assoc($resultado);
} else {
  echo "Error: No se ha encontrado el vinilo seleccionado.";
  exit;
}

// Cerrar conexión
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?php echo $vinilo['titulo']; ?></title>
</head>
<body>
  <h1><?php echo $vinilo['titulo']; ?></h1>
  <h2>de <?php echo $vinilo['autor']; ?></h2>
  <img src="<?php echo $vinilo['portada']; ?>" width="200">
  <p>Precio: <?php echo $vinilo['precio']; ?>€</p>

  <h3>Lista de canciones:</h3>
  <ul>
    <?php
      // Obtención de la información de las canciones
      $canciones = explode(',', $vinilo['canciones']);
      foreach ($canciones as $cancion) {
        echo '<li>' . $cancion . ' <button class="boton-play">▶</button></li>';
      }
    ?>
  </ul>

  <button class="boton-cesta" onclick="agregarVinilo(<?php echo $vinilo_id; ?>)">Añadir a la cesta</button>

  <button class="boton-comentarios" onclick="window.location.href='comentarios.php?id=<?php echo $vinilo_id; ?>'">
    <?php
      // Obtención del número de comentarios
      $sql = "SELECT COUNT(*) AS num_comentarios FROM Comentarios WHERE vinilo_id = $vinilo_id";
      $resultado = mysqli_query($conn, $sql);
      $fila = mysqli_fetch_assoc($resultado);

      echo $fila['num_comentarios'] . ' comentarios';
    ?>
  </button>

  <!-- Script para agregar el vinilo a la cesta de la compra -->
  <script>
    function agregarVinilo(id) {
      // Comprobar si el usuario ha iniciado sesión antes de agregar el vinilo a la cesta
      // Código para agregar el vinilo a la cesta de la compra
    }
  </script>
</body>
</html>
