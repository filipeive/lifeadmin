<?php
include "../partials/conn.php";

$response = array('status' => 'error', 'message' => 'Erro ao adicionar transação');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST['data'];
    $descricao = $_POST['descricao'];
    $tipo = $_POST['tipo'];
    $valor = $_POST['valor'];

    if ($tipo == 'entrada') {
        $sql = "INSERT INTO entradas (data, descricao, valor) VALUES ('$data', '$descricao', '$valor')";
    } else {
        $sql = "INSERT INTO saidas (data, descricao, valor) VALUES ('$data', '$descricao', '$valor')";
    }

    if ($conn->query($sql) === TRUE) {
        $response = array('status' => 'success', 'message' => 'Transação adicionada com sucesso');
    } else {
        $response['message'] = "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

echo json_encode;
?>