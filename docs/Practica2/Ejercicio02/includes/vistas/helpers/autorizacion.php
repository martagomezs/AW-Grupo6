<?php

function estaLogado()
{
    return isset($_SESSION['username']);
}


function esMismoUsuario($username)
{
    return estaLogado() && $_SESSION['username'] == $username;
}

function idUsuarioLogado()
function usernameLogado()
{
    return $_SESSION['username'] ?? false;
}

// function esAdmin()
// {
//     return estaLogado() && (array_search(Usuario::ADMIN_ROLE, $_SESSION['roles']) !== false);
// }

function verificaLogado($urlNoLogado)
{
    if (! estaLogado()) {
        Utils::redirige($urlNoLogado);
    }
}
