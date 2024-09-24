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
?>