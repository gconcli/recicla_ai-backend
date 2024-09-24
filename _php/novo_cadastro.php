<?php
    require_once 'scripts.php';
    require_once 'classes.php';

    $idTipo = 1;
    $login = $_POST['login'];
    $senhaAtual = $_POST['senhaAtual'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    if(session_status() !== PHP_SESSION_ACTIVE)
        session_start();
?>