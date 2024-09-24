<?php
include_once('../_php/dados_sessao.php'); // Inclui a função de conexão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conectar ao banco de dados
$con = getConexaoBancoMySQL();

// Atualizar dados se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; // Você pode optar por fazer hash da senha antes de salvar
}

// Atualiza usuário se o botão Atualizar for clicado
if (isset($_POST['atualizar'])) {
    $stmt = $con->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?");
    
    // Armazena o hash da senha em uma variável para não dar problema de notice:
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    
    $stmt->bind_param("sssi", $nome, $email, $senhaHash, $_SESSION['usuario_id']);
    
    if ($stmt->execute()) {
        echo "<script>alert('Dados atualizados com sucesso!');
        window.location.href = '../_public/sessao.php';
        </script>";
        
    } else {
        echo "<script>alert('Erro ao atualizar dados.');
        window.location.href = '../_public/sessao.php';
        </script>";
    }
    $stmt->close();
}


// Excluir usuário se o botão Excluir for clicado
if (isset($_POST['excluir'])) {
    $stmt = $con->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['usuario_id']);
    if ($stmt->execute()) {
        session_destroy(); // Sai da sessão
        echo "<script>
                alert('Usuário excluído com sucesso. Entre com outro usuário ou cadastre-se novamente.');
                window.location.href = '../_public/entrar.html';
                </script>";
        exit();
    } else {
        echo "<script>alert('Erro ao excluir usuário.');
        window.location.href = '../_public/sessao.php';
        </script>";
    }
    $stmt->close();
}

$con->close();
?>
