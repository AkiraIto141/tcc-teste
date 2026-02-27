<?php

session_start();

//verifica se existe uma sessao ativa ou nao:
//se o id tiver nulo, manda devolta pro login
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

//verifica se o nivel é permitido, se nao for, vai para acesso_negado
function verificarTipo($niveisPermitidos) {
    if (!in_array($_SESSION['user_tipo'], $niveisPermitidos)) {
        header('Location: acesso_negado.php');
        exit();
    }
}

