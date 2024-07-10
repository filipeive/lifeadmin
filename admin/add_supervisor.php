<?php
session_start();
include '../partials/conn.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $contato = $_POST['contato'];
    $zona = $_POST['zona'];
    $pastor_zona_id = $_POST['pastor_zona_id'];

    $sql = "INSERT INTO supervisores (nome, contato, pastor_zona_id, zona_id) VALUES ('$nome', '$contato', '$pastor_zona_id', '$zona')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = 'Supervisor adicionado com sucesso.';
        $response['status'] = 'success';
        $response['message'] = 'Supervisor adicionado com sucesso.';
    } else {
        $_SESSION['message'] = 'Erro ao adicionar supervisor: ' . mysqli_error($conn);
        $response['status'] = 'error';
        $response['message'] = 'Erro ao adicionar supervisor: ' . mysqli_error($conn);
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Método de requisição inválido.';
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
