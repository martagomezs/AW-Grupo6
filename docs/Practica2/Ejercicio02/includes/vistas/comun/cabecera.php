<?php

require_once __DIR__.'/../helpers/usuarios.php';

?>
<header>
	<a href="catalogo.php"><img src="img/logo.png" width="75"></a>

	<input type="button" onclick="window.location.href = 'catalogo.php';" name="Catálogo" value="Catalogo" >

	<input type="button" onclick="window.location.href = 'top.php';" name="TOP Ventas" value="TOP Ventas">

	<input type="button" onclick="window.location.href = 'ofertas.php';" name="Ofertas" value="Ofertas">

	<a href="cesta.php"><img src="img/cesta.png" width="50"></a>

	<a href="login.php"><img src="img/user.png" width="50"></a>
</header>