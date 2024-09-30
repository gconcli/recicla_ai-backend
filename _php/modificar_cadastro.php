<?php
    require_once 'scripts.php';
    require_once 'interfaces.php';
    require_once 'classes.php';

    $login = $_POST['login'];
    $senhaAtual = $_POST['senhaAtual'];
    
    
    if(isset($_POST['atualizar'])) {    // Atualiza usuário se o botão Atualizar for clicado

        if(password_verify($senhaAtual, $_SESSION[UsuarioVO::getNomesColunasTabela[3]])) {
        
            $senhaNova1 = null;
            $senhaNova2 = null;
            if(array_key_exists('senhaNova1', $_POST)) {

                $senhaNova1 = $_POST['senhaNova1'];
                $senhaNova2 = array_key_exists('senhaNova1', $_POST) ? $_POST['senhaNova2'] : null;

                if($senhaNova1 !== $senhaNova2) {
                    echo"<script>
                        alert('As senhas novas não são iguais entre si');
                        window.location.href = '../sessao.php';
                    </script>";
                    exit();
                }
            }

            $nome = null;
            if(array_key_exists('nome', $_POST)) 
                $nome = $_POST['nome'];
            

            $email = null;
            if(array_key_exists('email', $_POST)) 
                $email = $_POST['email'];
            

            $usuarioVO = new UsuarioVO();
            $usuarioVO->setIdTipoUsuario(1);
            $usuarioVO->setLogin($login);
            $usuarioVO->setSenha($senhaNova1);
            $usuarioVO->setNome($nome);
            $usuarioVO->setEmail($email);
            $tentativaEdicao = FactoryServicos::getServicosUsuario()->atualizarUsuario($usuarioVO);
    
            if(empty($tentativaEdicao)) {
                echo"<script>
                        alert('Erro na edição!');
                        window.location.href = '../sessao.php';
                    </script>";
                exit();
            }
            else {
                fazerLogoff();
                fazerLogin($login, $senhaNova);
                echo"<script>
                        alert('Cadastro atualizado com sucesso!');
                        window.location.href = '../sessao.php';
                    </script>";
                exit();
            }
        }
        else {
            echo"<script>
                    alert('Senha atual incorreta!');
                    window.location.href = '../sessao.php';
                </script>";
            exit();
        }
    }
    elseif(isset($_POST['excluir'])) {  // Excluir usuário se o botão Excluir for clicado
        if(password_verify($senhaAtual, $_SESSION[UsuarioVO::getNomesColunasTabela[3]])) {

            $tentativaRemocao = FactoryServicos::getServicosUsuario()->deletarUsuario($_SESSION[UsuarioVO::getNomesColunasTabela[0]]);
    
            if(empty($tentativaRemocao)) {
                echo"<script>
                        alert('Erro na remoção!');
                        window.location.href = '../sessao.php';
                    </script>";
                exit();
            }
            else {
                fazerLogoff();
                echo"<script>
                        alert('Cadastro removido com sucesso! Faça login novamente...');
                        window.location.href = '../sessao.php';
                    </script>";
                exit();
            }
        }
        else {
            echo"<script>
                    alert('Senha incorreta!');
                    window.location.href = '../sessao.php';
                </script>";
            exit();
        }
    }
    elseif(isset($_POST['sairDaConta'])) {
        fazerLogoff();
        echo"<script>
                alert('Saindo do usuário atual');
                window.location.href = '../sessao.php';
            </script>";
        exit();
    }
?>