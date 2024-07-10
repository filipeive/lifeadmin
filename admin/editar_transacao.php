<?php
include "../partials/conn.php";

$response = array('status' => 'error', 'message' => 'Erro ao editar transação');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $data = $_POST['data'];
    $descricao = $_POST['descricao'];
    $tipo = $_POST['tipo'];
    $valor = $_POST['valor'];

    if ($tipo == 'entrada') {
        $sql = "UPDATE entradas SET data='$data', descricao='$descricao', valor='$valor' WHERE id='$id'";
    } else {
        $sql = "UPDATE saidas SET data='$data', descricao='$descricao', valor='$valor' WHERE id='$id'";
    }

    if ($conn->query($sql) === TRUE) {
        $response = array('status' => 'success', 'message' => 'Transação editada com sucesso');
    } else {
        $response['message'] = "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

echo json_encode($response);
?>
