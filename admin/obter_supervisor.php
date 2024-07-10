<?php
// Incluir arquivo de configuração do banco de dados
include '../partials/conn.php';

// Inicializar o buffer de saída
ob_start();

// Verificar se o parâmetro ID foi passado pela URL
if (isset($_GET['id'])) {
    $supervisor_id = $_GET['id'];

    // Consulta SQL para selecionar os dados do supervisor pelo ID
    $sql = "SELECT * FROM supervisores WHERE id = $supervisor_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $supervisor = mysqli_fetch_assoc($result);
        $response = array('status' => 'success', 'supervisor' => $supervisor);
    } else {
        $response = array('status' => 'error', 'message' => 'Supervisor não encontrado.');
    }
} else {
    $response = array('status' => 'error', 'message' => 'ID do supervisor não especificado.');
}

// Limpar o buffer de saída
ob_end_clean();

header('Content-Type: application/json');
echo json_encode($response);

// Fechar conexão com o banco de dados
mysqli_close($conn);
?>
