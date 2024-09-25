<?php

    /**
     * Cria e retorna uma conexão com o banco de dados MySQL especificado na função
     * @return mysqli - O objeto "mysqli" da conexão
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    function getConexaoBancoMySQL() : mysqli {
        $servidor = "localhost";
        $usuario = "root";
        $senha = "";
        $bancoDeDados = "recicla_ai2";  // Modificado para testes
        //$bancoDeDados = "recicla_ai";

        $con = new mysqli($servidor, $usuario, $senha, $bancoDeDados);

        if($con->connect_error) {
            exit("Falha na conexão: $con->connect_error");
        }
        //echo "Sucesso na conexão com o banco de dados";
        // Removido para não aparecer na hora que vai para a página se sessão
        return $con;
    }

    /**
     * 
     */
    function fazerLogin(string $login, string $senhaAtual) : bool {

        $tentativaLogin = FactoryServicos::getServicosUsuario()->loginUsuario($login, $senhaAtual);

        if(isset($tentativaLogin)) {
            if(!$tentativaLogin) {
                echo"<script>
                    alert('Senha incorreta!');
                    window.location.href = '../index.html';
                </script>";
                return false;
            }
            else {
                session_start();
                
                $_SESSION[UsuarioVO::getNomesColunasTabela[0]] = $tentativaLogin->getId();
                $_SESSION[UsuarioVO::getNomesColunasTabela[1]] = $tentativaLogin->getIdTipoUsuario();
                $_SESSION[UsuarioVO::getNomesColunasTabela[2]] = $tentativaLogin->getLogin();
                $_SESSION[UsuarioVO::getNomesColunasTabela[3]] = $tentativaLogin->getSenha();
                $_SESSION[UsuarioVO::getNomesColunasTabela[4]] = $tentativaLogin->getNome();
                $_SESSION[UsuarioVO::getNomesColunasTabela[5]] = $tentativaLogin->getEmail();
    
                echo"<script>
                    alert('Dados corretos, fazendo login...');
                    window.location.href = '../index.html';
                </script>";
                return true;
            }
        }
        else {
            echo"<script>
                    alert('Usuário não encontrado!');
                    window.location.href = '../index.html';
                </script>";
                return false;
        }
    }

    /**
     * Destrói a sessão e os cookies para fazer logoff do usuário
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    function fazerLogoff() : void {
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
    }
?>