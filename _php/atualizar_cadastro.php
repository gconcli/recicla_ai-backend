<?php
    require_once 'scripts.php';
    require_once 'interfaces.php';
    require_once 'classes.php';

    $login = $_POST['login'];
    $senhaAtual = $_POST['senhaAtual'];
    

    if(isset($_POST['atualizar'])) {
        $senhaNova1 = array_key_exists('senhaNova1', $_POST) ? $_POST['senhaNova1'] : null;
        $senhaNova2 = array_key_exists('senhaNova2', $_POST) ? $_POST['senhaNova2'] : null;

        if(isset($senhaNova1) || isset($senhaNova2)) {
            if($senhaNova1 === $senhaNova2)
                exit("Erro: As senhas novas não são iguais");
        }

        $nome = array_key_exists('nome', $_POST) ? $_POST['nome'] : null;
        if(isset($nome))
            asdasd
        $email = array_key_exists('email', $_POST) ? $_POST['email'] : null;

        if(password_verify($senhaAtual, $_SESSION[UsuarioVO::getNomesColunasTabela[3]])) {
        
            $usuarioVO = new UsuarioVO();
            $usuarioVO->setIdTipoUsuario(1);
            $usuarioVO->setLogin($login);
            $usuarioVO->setSenha($senhaNova1);
            $usuarioVO->setNome($nome);
            $usuarioVO->setEmail($email);
    
            $tentativaEdicao = FactoryServicos::getServicosUsuario()->re;
    
            if(empty($tentativaEdicao)) {
                echo"<script>
                        alert('Erro na edição!');
                        window.location.href = '../index.php';
                    </script>";
            }
            else {
                fazerLogoff();
                fazerLogin($login, $senhaNova);
                echo"<script>
                        alert('Cadastro atualizado com sucesso! Faça login novamente...');
                        window.location.href = '../index.php';
                    </script>";
            }
        }
        else {
            echo"<script>
                    alert('Senha atual incorreta!');
                    window.location.href = '../index.php';
                </script>";
        }
    }
    elseif(isset($_POST['excluir'])) {

    }
    elseif(isset($_POST['sairDaConta'])) {

    }
?>