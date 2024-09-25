<?php
    require_once 'scripts.php';
    require_once 'classes.php';

    $login = $_POST['login'];
    $senhaAtual = $_POST['senhaAtual'];

    fazerLogin($login, $senhaAtual);
?>