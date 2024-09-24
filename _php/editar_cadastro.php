<?php
require_once('../_php/dados_sessao.php'); // Inclui a função de conexão

// Conectar ao banco de dados
$con = getConexaoBancoMySQL();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Atualizar dados se o formulário for enviado
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senhaAtual = $_POST['senhaAtual'];
    $senhaNova = $_POST['senhaNova'];
}

// Atualiza usuário se o botão Atualizar for clicado
if (isset($_POST['atualizar'])) {

    $stmt1 = $con->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt1->bind_param("s", $email);
    $stmt1->execute();
    $resultado = $stmt1->get_result();

    $usuario = $resultado->fetch_assoc();

    if (password_verify($senhaAtual, $usuario['senha'])) {

        $stmt1->close();

        $stmt2 = $con->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?");
        // Armazena o hash da senha em uma variável para não dar problema de notice:
        $senhaHash = password_hash($senhaNova, PASSWORD_DEFAULT);
            
        $stmt2->bind_param("sssi", $nome, $email, $senhaHash, $_SESSION['usuario_id']);
            
        if ($stmt2->execute()) {
            $stmt2->close();
            echo "<script>alert('Dados atualizados com sucesso!');
            window.location.href = '../_public/sessao.php';
            </script>";
                
        } else {
            $stmt2->close();
            echo "<script>alert('Erro ao atualizar dados.');
            window.location.href = '../_public/sessao.php';
            </script>";
        }
        
    }
    else {
        $stmt1->close();
        echo "<script>
        alert('Senha atual incorreta.');
        window.location.href = '../_public/sessao.php'; // Redireciona para a mesma página
        </script>";
    }
}


// Excluir usuário se o botão Excluir for clicado
if (isset($_POST['excluir'])) {

    $stmt1 = $con->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt1->bind_param("s", $email);
    $stmt1->execute();
    $resultado = $stmt1->get_result();

    $usuario = $resultado->fetch_assoc();
    if (password_verify($senhaAtual, $usuario['senha'])) {

        $stmt1->close();

        $stmt2 = $con->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt2->bind_param("i", $_SESSION['usuario_id']);

        if ($stmt2->execute()) {
            session_destroy(); // Sai da sessão
            $stmt2->close();
            echo "<script>
                    alert('Usuário excluído com sucesso. Entre com outro usuário ou cadastre-se novamente.');
                    window.location.href = '../_public/entrar.html';
                    </script>";
            exit();
        } else {
            $stmt2->close();
            echo "<script>alert('Erro ao excluir usuário.');
            window.location.href = '../_public/sessao.php';
            </script>";
        }
    }
    else {
        $stmt1->close();
        echo "<script>
        alert('Senha atual incorreta.');
        window.location.href = '../_public/sessao.php'; // Redireciona para a mesma página
        </script>";
    }

    
}

// Código para sair da sessão ao clicar em "Sair da Conta"
if (isset($_POST['sairDaConta'])) {
    session_destroy(); // Destroi a sessão
    echo "<script>
            alert('Você saiu da conta.');
            window.location.href = '../_public/entrar.html'; // Redireciona para a página de login
          </script>";
    exit();
}

$con->close();
?>
