<?php
    require_once 'scripts.php';
    require_once 'classes.php';

    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $usuarioVO = new UsuarioVO();
    $usuarioVO->setIdTipoUsuario(1);
    $usuarioVO->setLogin($login);
    $usuarioVO->setSenha($senha);
    $usuarioVO->setNome($nome);
    $usuarioVO->setEmail($email);

    $tentativaCadastro = FactoryServicos::getServicosUsuario()->cadastroUsuario($usuarioVO);

    if(empty($tentativaCadastro)) {
        echo"<script>
                alert('Erro no cadastro!');
                window.location.href = '../index.html';
            </script>";
    }
    else {
        fazerLogin($login, $senha);
    }

    session_start();
?>