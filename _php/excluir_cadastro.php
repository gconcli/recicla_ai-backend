<?php
    require_once 'scripts.php';
    require_once 'interfaces.php';
    require_once 'classes.php';

    $login = $_POST['login'];
    $senha = $_POST['senha'];

    if(password_verify($senhaAtual, $_SESSION[UsuarioVO::getNomesColunasTabela[3]])) {

        $tentativaRemocao = FactoryServicos::getServicosUsuario()->deletarUsuario($_SESSION[UsuarioVO::getNomesColunasTabela[0]]);

        if(empty($tentativaRemocao)) {
            echo"<script>
                    alert('Erro na remoção!');
                    window.location.href = '../index.php';
                </script>";
        }
        else {
            echo"<script>
                    alert('Cadastro removido com sucesso! Faça login novamente...');
                    window.location.href = '../index.php';
                </script>";
                fazerLogoff();
        }
    }
    else {
        echo"<script>
                alert('Senha incorreta!');
                window.location.href = '../index.php';
            </script>";
    }
?>