
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/estilo.css') ?>">
	<title><?= $params['tituloPagina'] ?></title>
</head>
<body>
<div id="contenedor">
<?php

if(isset($_SESSION['rol'])){
	if($_SESSION['rol'] == "usuario"){
		$params['app']->doInclude('/vistas/comun/cabecera.php', $params);
	}
	else if($_SESSION['rol'] == "admin"){
		$params['app']->doInclude('/vistas/comun/admin.php', $params);
	}
}
else{
	$params['app']->doInclude('/vistas/comun/cabecera.php', $params);
}

?>
<main>
	<article>
		<?= $params['contenidoPrincipal'] ?>
	</article>
</main>

</div>
</body>
</html>