<?php
include "../partials/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM usuarios WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Usuário excluído com sucesso']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir usuário: ' . $conn->error]);
    }
}
?>
