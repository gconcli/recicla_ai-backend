<?php

    /**
     * Cria e retorna uma conexão com o banco de dados MySQL especificado na função
     * @return mysqli - O objeto "mysqli" da conexão
     */
    function getConexaoBancoMySQL() : mysqli {
        $servidor = "localhost";
        $usuario = "root";
        $senha = "";
        $bancoDeDados = "recicla_ai";

        $con = new mysqli($servidor, $usuario, $senha, $bancoDeDados);

        if($con->connect_error) {
            exit("Falha na conexão: $con->connect_error");
        }
        echo "Sucesso na conexão com o banco de dados";
        return $con;
    }

    function recebe() {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $usuario = $_POST['usuario'];
        $senha = MD5($_POST['senha']);
    }
?>