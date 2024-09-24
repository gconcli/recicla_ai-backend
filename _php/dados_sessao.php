<?php
require_once('scripts.php'); // Inclui a função de conexão

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../_public/entrar.html"); // Redireciona se não estiver logado
    exit();
}

// Conectar ao banco de dados
$con = getConexaoBancoMySQL();
$stmt = $con->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
    $nomeCompleto = $usuario['nome']; // Supondo que o campo do nome é 'nome'
    $emailUsuario = $usuario['email']; // Supondo que o campo do e-mail é 'email'
} else {
    echo "<script>alert('Usuário não encontrado.');</script>";
}

$stmt->close();
$con->close();