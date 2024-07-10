<?php
// Incluir arquivo de configuração do banco de dados
include '../partials/conn.php';

// Inicializar variáveis para armazenar dados do supervisor
$supervisor = array();

// Verificar se o parâmetro ID foi passado pela URL
if (isset($_GET['id'])) {
    $supervisor_id = $_GET['id'];

    // Consulta SQL para selecionar os dados do supervisor pelo ID
    $sql = "SELECT * FROM supervisores WHERE id = $supervisor_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $supervisor = mysqli_fetch_assoc($result);
    } else {
        echo "Supervisor não encontrado.";
        exit;
    }
} else {
    echo "ID do supervisor não especificado.";
    exit;
}

// Processamento do formulário de edição, se enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os dados do formulário
    $nome = $_POST['nome'];
    $contato = $_POST['contato'];
    $zona_id = $_POST['zona_id'];
    $pastor_zona_id = $_POST['pastor_zona_id'];

    // Consulta SQL para atualizar os dados do supervisor
    $sql_update = "UPDATE supervisores SET 
                   nome = '$nome', 
                   contato = '$contato',
                   zona_id = $zona_id,
                   pastor_zona_id = $pastor_zona_id
                   WHERE id = $supervisor_id";

    if (mysqli_query($conn, $sql_update)) {
        $response = array('status' => 'success', 'message' => 'Dados do supervisor atualizados com sucesso.');
    } else {
        $response = array('status' => 'error', 'message' => 'Erro ao atualizar os dados do supervisor: ' . mysqli_error($conn));
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Fechar conexão com o banco de dados
mysqli_close($conn);
?>
