<?php
include "../partials/conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $perfil = $_POST['perfil'];

    $sql = "INSERT INTO usuarios (nome, email, senha, perfil) VALUES ('$nome', '$email', '$senha', '$perfil')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Novo usuário adicionado com sucesso"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Erro: " . $sql . "<br>" . $conn->error]);
    }

    $conn->close();
}
?>
