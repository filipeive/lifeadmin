<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "filipe";
$password = "senha";
$dbname = "igreja_gestao";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
