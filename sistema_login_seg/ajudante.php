<?php


function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

function validarConfirmacaoSenha($senha, $confirmarSenha){
    if(empty($senha) || empty($confirmarSenha)){
        return "Preencha ambos os campos de senha.";
    }

    if($senha !== $confirmarSenha){
        return "As senhas não coincidem.";
    }

    if(strlen($senha) < 6){
        return "A senha deve ter pelo menos 6 caracteres.";
    }

    return true;
}


function verificarLogadoTipo() {


    if (!isset($_SESSION['user_id'])) {
        return;
    }

   
    $tipo = $_SESSION['user_tipo'] ?? 'default';

    switch ($tipo) {
        case 'medico':
            header("Location: administrador.php"); 
            break;

        case 'paciente':
            header("Location: usuario.php"); 
            break;

    }
    exit; 
}