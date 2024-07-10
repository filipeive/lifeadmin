<?php
session_start();
include 'partials/conn.php'; // Arquivo de conexão ao banco de dados
echo "connecao estabelecida com sucesso";
if ($conn == true) {
    echo 'Conexão estabelecida com sucesso!';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    // Proteção contra SQL Injection
    $email = mysqli_real_escape_string($conn, $email);

    // Busca o usuário no banco de dados
    $sql = "SELECT * FROM usuarios WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    
    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['perfil'] = $user['perfil'];
        
        // Redireciona com base no perfil
        if ($user['perfil'] == 'admin') {
            header('Location: admin/index.php');
        } else {
            header('Location: usuario/index.php');
        }
        exit();
    } else {
        // Usuário ou senha inválidos
        $_SESSION['login_error'] = 'Erro: Usuário ou senha inválidos';
        header('Location: index.php');
        exit();
    }
}
?>
