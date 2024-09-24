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
     * Destrói a sessão e os cookies para fazer logoff do usuário
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    function logoff() : void {
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