<?php

function buildFormularioRegistro($username='', $name='', $mail='', $password='')
{
    return <<<EOS
    <form id="formReg" action="procesarRegistro.php" method="POST">
        <fieldset>
            <legend>Formulario de registro</legend>
            <div><label>Usuario:</label> <input type="text" name="username" value="$username" /></div>
            <div><label>Nombre:</label> <input type="text" name="name" value="$name" /></div>
            <div><label>Correo:</label> <input type="email" name="mail" value="$mail" /></div>
            <div><label>Contraseña:</label> <input type="password" name="password" password="$password" /></div>
            <div><button type="submit">Registrarse</button></div>
        </fieldset>
    </form>
    EOS;
}