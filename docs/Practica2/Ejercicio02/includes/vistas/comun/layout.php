<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS.'/miEstilo.css'?>" /> -->
	<title><?= $tituloPagina ?></title>
</head>
<body>
<div id="contenedor">
<?php

require('cabecera.php');

?>
<main>
	<article>
		<?= $contenidoPrincipal ?>
	</article>
</main>

</div>
</body>
</html>