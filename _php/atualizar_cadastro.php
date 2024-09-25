<?php
    require_once 'scripts.php';
    require_once 'classes.php';

    $login = $_POST['login'];
    $senhaAtual = $_POST['senhaAtual'];
    $senhaNova = $_POST['senhaNova'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    if(password_verify($senhaAtual, $_SESSION[UsuarioVO::getNomesColunasTabela[3]])) {
        
        $usuarioVO = new UsuarioVO();
        $usuarioVO->setIdTipoUsuario(1);
        $usuarioVO->setLogin($login);
        $usuarioVO->setSenha($senhaNova);
        $usuarioVO->setNome($nome);
        $usuarioVO->setEmail($email);

        $tentativaEdicao = FactoryServicos::getServicosUsuario()->re;

        if(empty($tentativaEdicao)) {
            echo"<script>
                    alert('Erro na edição!');
                    window.location.href = '../index.html';
                </script>";
        }
        else {
            fazerLogoff();
            fazerLogin($login, $senhaNova);
            echo"<script>
                    alert('Cadastro atualizado com sucesso! Faça login novamente...');
                    window.location.href = '../index.html';
                </script>";
        }
    }
    else {
        echo"<script>
                alert('Senha atual incorreta!');
                window.location.href = '../index.html';
            </script>";
    }
?>