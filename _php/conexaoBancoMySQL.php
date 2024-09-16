<?php
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
?>