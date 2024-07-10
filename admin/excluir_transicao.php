<?php
include "../partials/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM entradas WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Transicao excluído com sucesso']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir Transicao: ' . $conn->error]);
    }
}
?>
