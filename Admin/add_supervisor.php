<?php
session_start();
include '../partials/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $zona = $_POST['area'];
    $contato = $_POST['contato'];
    $pastor_zona_id = $_POST['pastor_zona_id'];

    $sql = "INSERT INTO supervisores (nome, area, contato, pastor_zona_id) VALUES ('$nome', '$zona', '$contato', '$pastor_zona_id')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Supervisor adicionado com sucesso.";
    } else {
        $_SESSION['message'] = "Erro ao adicionar supervisor: " . mysqli_error($conn);
    }

    header('Location: index.php');
    exit();
}
?>
