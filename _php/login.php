<?php
    require_once 'scripts.php';
    require_once 'interfaces.php';
    require_once 'classes.php';

    $login = $_POST['login'];
    $senhaAtual = $_POST['senhaAtual'];

    if(fazerLogin($login, $senhaAtual)) {
        echo"<script>
                    alert('Dados corretos, fazendo login...');
                    window.location.href = '../sessao.php';
                </script>";
    }
    else {
        echo"<script>
                    alert('Usuário e/ou senha incorretos!');
                    window.location.href = '../index.php';
            </script>";
    }
?>