<?php
    require_once 'scripts.php';
    require_once 'interfaces.php';
    require_once 'classes.php';

    $login = $_POST['login'];
    $senha1 = $_POST['senha1'];
    $senha2 = $_POST['senha2'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    if($senha1 === $senha2) {
        $usuarioVO = new UsuarioVO();
        $usuarioVO->setIdTipoUsuario(1);
        $usuarioVO->setLogin($login);
        $usuarioVO->setSenha($senha1);
        $usuarioVO->setNome($nome);
        $usuarioVO->setEmail($email);

        $tentativaCadastro = FactoryServicos::getServicosUsuario()->cadastroUsuario($usuarioVO);

        if(empty($tentativaCadastro)) {
            echo"<script>
                    alert('Erro no cadastro!');
                    window.location.href = '../index.php';
                </script>";
        }
        else {
            fazerLogin($login, $senha1);
        }

        session_start();
    }
    else {
        echo"<script>
                alert('As senhas não são iguais!');
                window.location.href = '../index.php';
            </script>";
    }
?>