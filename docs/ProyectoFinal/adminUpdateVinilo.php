<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Actualizar Vinilos';
$vinilos = es\ucm\fdi\aw\Vinilo\Vinilo::buscaVinilos();
if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}



if(isset($_POST['update'])){
    if(isset($_POST['id'])){
        $nuevo = es\ucm\fdi\aw\Vinilo\Vinilo::buscaPorId($_POST['id']);
    }
    if(isset($_POST['precio'])){
        $nuevo->precio = $_POST['precio'];
        es\ucm\fdi\aw\Vinilo\Vinilo::actualizaPrecioAdmin($_POST['precio'],$_POST['id']);
    }
    if(isset($_POST['stock'])){
        $nuevo->stock = $_POST['stock'];
        es\ucm\fdi\aw\Vinilo\Vinilo::actualizaStockAdmin($_POST['stock'],$_POST['id']);
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
    $nuevo = es\ucm\fdi\aw\Vinilo\Vinilo::buscaPorId($_POST['vinilo']);
    $contenidoPrincipal = <<<EOS
            <h1>$nuevo->titulo</h1>
            <form method="post">
                <div>
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" min="1" placeholder="{$nuevo->precio}" value="{$nuevo->precio}">
                </div>
                <div>
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" min="1" placeholder="{$nuevo->stock}" value="{$nuevo->stock}">
                </div>
                <input type="hidden" name="id" value="{$nuevo->id}">
                <div>
                <input type="submit" name="update" value="Aceptar">
                </div>
                
            </form>
    EOS;
}


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
?>