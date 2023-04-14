<?php

require_once __DIR__.'/../helpers/usuarios.php';

?>
<header>
	<a href="catalogo.php" class="logo"><img src="img/utils/logo.png" name="logo" width="75"></a>

	<div class="menu">
        <input type="button" onclick="window.location.href = 'catalogo.php';" name="Catálogo" value="Catalogo" >

        <input type="button" onclick="window.location.href = 'top.php';" name="TOP Ventas" value="TOP Ventas">

        <input type="button" onclick="window.location.href = 'ofertas.php';" name="Ofertas" value="Ofertas">

        <input type="button" onclick="window.location.href = 'perfil.php';" name="Perfil" value="Perfil">
    </div>

	<div class="icons">
        <a href="cesta.php"><img src="img/utils/cesta.png" name="cesta" width="50"></a>

        <a href="login.php"><img src="img/utils/user.png" name="login" width="50"></a>
    </div>
</header>