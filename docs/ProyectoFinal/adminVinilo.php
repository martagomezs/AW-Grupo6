<?php
require_once __DIR__.'/includes/config.php';

if (isset($_POST['option'])) {
    if ($_POST['option'] == 'Borra') {
        header('Location: adminBorraVinilo.php');
        exit;
    } elseif ($_POST['option'] == 'Actualiza') {
        header('Location: adminUpdateVinilo.php');
        exit;
    } elseif ($_POST['option'] == 'Inserta') {
        header('Location: adminCreaVinilo.php');
        exit;
    }
}

$tituloPagina = 'Aministrar Vinilos';
$vinilos = es\ucm\fdi\aw\Vinilo\Vinilo::buscaVinilos();
if(!esAdmin()){
    Utils::paginaError(403, $tituloPagina, 'No eres admin', 'No tienes acceso a esta página');
}

$contenidoPrincipal = '<h1>Gestión de vinilos</h1>';

$contenidoPrincipal .= '<p>Seleccione qué quiere hacer:</p>';

$contenidoPrincipal .= '<form method="post">';

$contenidoPrincipal .= '<input type="radio" id="delete" name="option" value="Borra">';
$contenidoPrincipal .= '<label for="delete">Borrar</label>';

$contenidoPrincipal .= '<input type="radio" id="update" name="option" value="Actualiza">';
$contenidoPrincipal .= '<label for="update">Actualizar</label>';

$contenidoPrincipal .= '<input type="radio" id="insert" name="option" value="Inserta">';
$contenidoPrincipal .= '<label for="insert">Crear</label>';

$contenidoPrincipal .= '<br><input type="submit" value="Aceptar" >';

$contenidoPrincipal .= '</form>';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    if(isset($_POST['boton']) && $_POST['boton'] == "Actualizar"){
        
        

        $contenidoPrincipal .= '<h2>Lista de canciones</h2>';
        $canciones = es\ucm\fdi\aw\Vinilo\Cancion::canciones($id);

        $contenidoPrincipal .= '<p>Selecciona los vinilos que quieres eliminiar:</p>';
        $contenidoPrincipal .= '<form method="post">';

        foreach($canciones as $cancion){
            $contenidoPrincipal .= '<div>';
                $contenidoPrincipal .= '<input type="checkbox" id="' . $cancion->id . '" name="' . $cancion->id . '" value="' . $cancion->id . '">';
                $contenidoPrincipal .= '<label for="' . $cancion->id . '">' . $cancion->titulo . '</label>';
            $contenidoPrincipal .= '</div>';
        }
        $contenidoPrincipal .= '<input type="submit" name="canciones" value="Borrar" >';
        $contenidoPrincipal .= '</form>';

        $contenidoPrincipal .= '<p>Añade una nueva canción:</p>';
        $contenidoPrincipal .= '<form method="post" enctype="multipart/form-data">';
        $contenidoPrincipal .= 
            '<div>
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulocancion" required minlength="1" size="10">
            </div>';
        $contenidoPrincipal .= 
            '<div>
                <label for="audio">Selecciona un audio:</label>
                <input type="file" id="audio" name="audio" accept=".mp3">
            </div>';
        $contenidoPrincipal .= '<input type="submit" name="creaCancion" value="Crear Cancion">';
    
    }
    else if(isset($_POST['boton']) && $_POST['boton'] == "Inserta"){
        
    }
    
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
?>