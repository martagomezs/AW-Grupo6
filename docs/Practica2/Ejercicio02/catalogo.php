<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$tituloPagina = 'Catálogo';

// if (! estaLogado()) {
// 	Utils::paginaError(403, $tituloPagina, 'Usuario no conectado!', 'Debes iniciar sesión para ver el contenido.');
// }

$contenidoPrincipal=<<<EOS
	<h1>Catálogo</h1>
	<p> Aquí va el catálogo</p>
	// <section class="products">
	// <?php
	// // Conectarse a la base de datos
	// $conexion = mysqli_connect("localhost", "usuario", "contraseña", "nombre-de-la-base-de-datos");
	
	// // Verificar si la conexión fue exitosa
	// if (!$conexion) {
	// 	die("Error al conectar a la base de datos: " . mysqli_connect_error());
	// }
	
	// // Realizar la consulta a la tabla de productos
	// $query = "SELECT * FROM productos";
	// $resultado = mysqli_query($conexion, $query);
	
	// // Verificar si se encontraron resultados
	// if (mysqli_num_rows($resultado) > 0) {
	// 	// Mostrar cada producto en el catálogo
	// 	while ($producto = mysqli_fetch_assoc($resultado)) {
	// 		echo '<article class="product">';
	// 		echo '<a href="detalle-producto.php?id=' . $producto['id'] . '">';
	// 		echo '<img src="' . $producto['imagen'] . '" alt="' . $producto['nombre'] . '">';
	// 		echo '<h2>' . $producto['nombre'] . '</h2>';
	// 		echo '<p>' . $producto['descripcion'] . '</p>';
	// 		echo '<span class="price">$' . $producto['precio'] . '</span>';
	// 		echo '</a>';
	// 		echo '</article>';
	// 	}
	// } else {
	// 	echo "No se encontraron productos.";
	// }
	
	// // Liberar los resultados de la consulta y cerrar la conexión a la base de datos
	// mysqli_free_result($resultado);
	// mysqli_close($conexion);
	// ?>
	
	// 		<article class="product">
	// 			<a href="detalle-producto.php">
	// 				<img src="ruta-a-la-imagen.jpg" alt="Nombre del producto">
	// 				<h2>Nombre del producto</h2>
	// 				<p>Descripción breve del producto</p>
	// 				<span class="price">$99.99</span>
	// 			</a>
	// 		</article>
	// 		<!-- Repite este article para cada producto en la base de datos -->
	// 	</section>
EOS;

require 'includes/vistas/comun/layout.php';
