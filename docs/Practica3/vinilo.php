<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/vinilos.php';
require_once 'includes/vistas/helpers/autorizacion.php';
require_once 'includes/vistas/helpers/comentarios.php';


if(isset($_GET['id'])){
    $id = $_GET['id'];
}
if(isset($_POST['idVinilo'])){
    $id = $_POST['idVinilo'];
}

$vinilo = Vinilo::buscaPorId($id);
$canciones = Cancion::canciones($id);
$comentarios = Comentario::buscaPorVinilo($id);

$tituloPagina = "{$vinilo->titulo}";

if(isset($_POST['Comentario'])){
    if(!estaLogado()){
        Utils::paginaError(403, $tituloPagina, 'Usuario no conectado!', 'Debes iniciar sesión para poder publicar un comentario');
    }
    else{
        if(isset($_POST['dad'])){
            $c = Comentario::crea($vinilo->id,$_SESSION['username'],$_POST['Comentario'],$_POST['dad']);
        }
        else{
           $c = Comentario::crea($vinilo->id,$_SESSION['username'],$_POST['Comentario'],null); 
           $comentarios[] = $c;
        }
        
    }
}

$dialog = '';

if(isset($_POST['idPadre'])){
    $padre = $_POST['idPadre'];
    $dialog = <<< EOS
        <dialog id="res">
            <p>Responder a: </p>
            <form action="" method="post">
            <input type="text" name="Comentario" required>
            <input type="hidden" name="idVinilo" value="{$vinilo->id}">
            <input type="hidden" name="dad" value="{$padre}">
            <input type="submit" value="Enviar">
            </form>
            <button class="closeButton">Cancelar</button>
        </dialog>
    EOS;
}

if(isset($_POST['idVinilo'])){
    if(!estaLogado()){
        Utils::paginaError(403, $tituloPagina, 'Usuario no conectado!', 'Debes iniciar sesión para poder añadir el articulo a la cesta');
    }
    else{
        $fecha_actual = date('Y-m-d');
        $compra = Compra::añade($_SESSION['username'], $_POST['idVinilo'], $vinilo->precio, true, false, $fecha_actual);
        Compra::inserta($compra);
    }
}
$contenidoPrincipal = '';
$contenidoPrincipal .= <<< EOS
    <h1 class="titulo">{$vinilo->titulo}</h1>
    <h2><a href="artista.php?idAutor={$vinilo->idAutor}">{$vinilo->autor}</a></h2>
    <div class="vinilo-canciones">
        <img src="{$vinilo->portada}" width="400">
        <div class="canciones">
EOS;

foreach($canciones as $cancion){
    $contenidoPrincipal .= 
            '<dl> 
            <figure>
            <figcaption>' . $cancion->titulo . ':
            </figcaption>
            <audio controls src="' . $cancion->audio . '">
            </figure>
            </dl>';
}

$contenidoPrincipal .= '</div>';
$contenidoPrincipal .= '<div class="comentarios-escribir">';
$contenidoPrincipal .= '<div class="comentarios">';
$contenidoPrincipal .= '<h2>Comentarios</h2>';
if($comentarios != null){
    foreach($comentarios as $coment){
        $contenidoPrincipal .= '<dl>';
        $contenidoPrincipal .= visualizaComentario($coment);
        $contenidoPrincipal .= '</dl>';  
    }
}
else{
    $contenidoPrincipal .= '<p>Aún no hay comentarios</p>';
}
$contenidoPrincipal .= '</div>';
$contenidoPrincipal .= '<div class="escribir">';
$contenidoPrincipal .= '<form action="" method="post">';
$contenidoPrincipal .= '<input type="text" name="Comentario" required>';
$contenidoPrincipal .= '<input type="hidden" name="idVinilo" value="'. $vinilo->id .'">';
$contenidoPrincipal .= '<input type="submit" value="Enviar">';
$contenidoPrincipal .= '</form></div></div>';


$contenidoPrincipal .= <<< EOS
    </div>
    <p>{$vinilo->precio}€</p>
EOS;

$contenidoPrincipal .= <<< EOS
    <form method="post">
        <input type="hidden" name="idVinilo" value="{$vinilo->id}">
        <input type="submit" value="Añadir a Cesta">
    </form>
EOS;


    $contenidoPrincipal .= $dialog;
    $contenidoPrincipal .= <<<EOS
        <script>
            var responderButtons = document.querySelectorAll('.resp');
            var dialog = document.getElementById('res');
            responderButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    dialog.showModal();
                    event.preventDefault();
                });
            });
            
            var closeButton = document.querySelector('.closeButton');
            closeButton.addEventListener('click', function(){
                this.parentNode.close();
            });
        </script>
    EOS;

require 'includes/vistas/comun/layout.php';
?>