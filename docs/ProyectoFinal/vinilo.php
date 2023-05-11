<?php
require_once __DIR__.'/includes/config.php';


if(isset($_GET['id'])){
    $id = $_GET['id'];
}
if(isset($_POST['idVinilo'])){
    $id = $_POST['idVinilo'];
}

$vinilo = es\ucm\fdi\aw\Vinilo\Vinilo::buscaPorId($id);
$canciones = es\ucm\fdi\aw\Vinilo\Cancion::canciones($id);
$comentarios = es\ucm\fdi\aw\Comentario\Comentario::buscaPorVinilo($id);

$tituloPagina = "{$vinilo->titulo}";

if(isset($_POST['Comentario'])){
    if($app->usuarioLogueado()){
        if(isset($_POST['dad'])){
            $c = es\ucm\fdi\aw\Comentario\Comentario::crea($vinilo->id,$_SESSION['username'],$_POST['Comentario'],$_POST['dad']);
        }
        else{
           $c = es\ucm\fdi\aw\Comentario\Comentario::crea($vinilo->id,$_SESSION['username'],$_POST['Comentario'],null); 
           $comentarios[] = $c;
        }
    }
    else{
        
        echo '<script>alert("No puedes comentar sin estar logeado.")</script>';
    }
}

$dialog = '';
$v = 0;

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

if(isset($_POST['valoracion'])){
    if($app->usuarioLogueado()){
        if(es\ucm\fdi\aw\Compra\Compra::compruebacomprado($vinilo->id,$_SESSION['username'])){
            $user = es\ucm\fdi\aw\Vinilo\Valoracion::haValorado($_SESSION['username'],$vinilo->id);
            if($user == false){
                es\ucm\fdi\aw\Vinilo\Valoracion::añade($vinilo->id,$_SESSION['username'],$_POST['valoracion']);
                $num = es\ucm\fdi\aw\Vinilo\Valoracion::numValoraciones($vinilo->id);
                $valoraciones = es\ucm\fdi\aw\Vinilo\Valoracion::buscaPorVinilo($vinilo->id);
                $media = 0;
                foreach($valoraciones as $valoracion){
                    $media += $valoracion->valoracion;
                }
                $media = $media / $num;
                $vinilo->valoracion = $media;
                es\ucm\fdi\aw\Vinilo\Vinilo::actualiza($vinilo);
                $vinilo = es\ucm\fdi\aw\Vinilo\Vinilo::buscaPorId($vinilo->id);
            }
            else{
                echo '<script>alert("No puedes valorar el mismo vinilo dos veces.")</script>';
            }
        }
        else{
            echo '<script>alert("No puedes valorar el vinilo si no lo has comprado.")</script>';
        }
    }
    else{
        echo '<script>alert("No puedes valorar un vinilo sin estar logeado.")</script>';
    }
    
}

if(isset($_POST['idVinilo']) && !isset($_POST['Comentario'])){
    if($app->usuarioLogueado()){
        $fecha_actual = date('Y-m-d');
        $compra = es\ucm\fdi\aw\Compra\Compra::añade($_SESSION['username'], $_POST['idVinilo'], $vinilo->precio, true, false, $fecha_actual);
        es\ucm\fdi\aw\Compra\Compra::inserta($compra);
    }
    else{
        echo '<script>alert("Necesitas estar logueado para añadir un vinilo a la cesta")</script>';
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
$contenidoPrincipal .= '<input type="submit" class="boton" value="Enviar">';
$contenidoPrincipal .= '</form></div></div>';

$contenidoPrincipal .= <<< EOS
    </div>
    <div class="cesta-valoracion">
        <h2>{$vinilo->precio}€</h2>
        
        <form method="post">
            <input type="hidden" name="idVinilo" value="{$vinilo->id}">
            <input type="submit" class="boton" value="Añadir a Cesta">
        </form>
        
        <h3>Valoracion: {$vinilo->valoracion}</h3>
        
        <form method="post">
            <input type="number" id="valoracion" name="valoracion" min="0" max="5" value="{$v}">
            <input type="submit" class="boton" value="Valorar">
        </form>
    </div>
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

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/comun/layout.php', $params);
?>