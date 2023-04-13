<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';

$tituloPagina = 'Actualizar Vinilos';
$vinilos = Vinilo::buscaVinilos();
if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}



if(isset($_POST['update'])){
    if(isset($_POST['id'])){
        $nuevo = Vinilo::buscaPorId($_POST['id']);
    }
    if(isset($_POST['titulo'])){
        $nuevo->titulo = $_POST['titulo'];
    }
    if(isset($_POST['autor'])){
        $nuevo->autor = $_POST['autor'];
    }
    if(isset($_POST['precio'])){
        $nuevo->precio = $_POST['precio'];
    }
    if(isset($_POST['stock'])){
        $nuevo->stock = $_POST['stock'];
    }
    if(Vinilo::actualiza($nuevo)){
        echo '<script>Se ha actualizado correctamente</script>';
    }
}

$contenidoPrincipal = '<h2>Lista de Vinilos</h2>';
$contenidoPrincipal .= '<p>Selecciona el vinilo que quieres actualizar</p>';

$contenidoPrincipal .= '<form method="post">';

foreach($vinilos as $vinilo){
    $contenidoPrincipal .= '<input type="radio" id="'.$vinilo->id.'" name="vinilo" value="'.$vinilo->id.'">';
    $contenidoPrincipal .= '<label for="'.$vinilo->id.'">'. $vinilo->titulo .'</label>';
}
$contenidoPrincipal .= '<br><input type="submit" id="sel" name="boton" value="Aceptar" >';
$contenidoPrincipal .= '</form>';

if(isset($_POST['boton'])){
    $nuevo = Vinilo::buscaPorId($_POST['vinilo']);
    $contenidoPrincipal = <<<EOS
            <h1>$nuevo->titulo</h1>
            <form method="post">
                <div>
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" required minlength="1" size="10">
                </div>
                <div>
                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor" required minlength="1" size="10">
                </div>
                <div>
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" min="1">
                </div>
                <div>
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" min="1">
                </div>
                <input type="hidden" name="id" value="{$nuevo->id}">
                <div>
                <input type="submit" name="update" value="Aceptar">
                </div>
                
            </form>
    EOS;
}


require 'includes/vistas/comun/layout.php';
?>