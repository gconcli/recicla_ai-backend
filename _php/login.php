<?php
    require_once 'scripts.php';
    require_once 'classes.php';

    $login = $_POST['login'];
    $senhaAtual = $_POST['senhaAtual'];

    $tentativaLogin = FactoryServicos::getServicosUsuario()->loginUsuario($login, $senhaAtual);

    if(isset($tentativaLogin)) {
        if(!$tentativaLogin) {
            echo"<script>
                alert('Senha incorreta!');
                window.location.href = '../index.html';
            </script>";
        }
        else {

            session_start();
            $_SESSION['id'] = $tentativaLogin->getId();
            $_SESSION['idTipo'] = $tentativaLogin->getIdTipoUsuario();
            $_SESSION['login'] = $tentativaLogin->getLogin();
            $_SESSION['senha'] = $tentativaLogin->getSenha();
            $_SESSION['nome'] = $tentativaLogin->getNome();
            $_SESSION['email'] = $tentativaLogin->getEmail();

            echo"<script>
                alert('Dados corretos, fazendo login...');
                window.location.href = '../index.html';
            </script>";
        }
    }
    else {
        echo"<script>
                alert('Usuário não encontrado!');
                window.location.href = '../index.html';
            </script>";
    }
?>