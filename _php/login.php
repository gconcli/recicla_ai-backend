<?php
    require_once 'classes.php';

    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $tentativaLogin = FactoryServicos::getServicosUsuario()->loginUsuario($login, $senha);

    if(isset($tentativaLogin)) {
        if($tentativaLogin == false) {
            // Senha incorreta
        }
        else {
            // Senha correta, '$tentativaLogin' contém os dados do usuário
        }
    }
    else {
        // Usuário não encontrado
    }
?>