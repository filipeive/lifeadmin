

<?php
include "../partials/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $culto_id = $_POST['culto_id'];
        
        // Deletar registros relacionados em entradas e relatorios_participacao
        $delete_entradas = $conn->prepare("DELETE FROM entradas WHERE culto_id = ?");
        $delete_entradas->bind_param("i", $culto_id);
        $delete_entradas->execute();

        $delete_relatorios = $conn->prepare("DELETE FROM relatorios_participacao WHERE culto_id = ?");
        $delete_relatorios->bind_param("i", $culto_id);
        $delete_relatorios->execute();
        
        // Deletar o culto
        $delete_culto = $conn->prepare("DELETE FROM cultos WHERE id = ?");
        $delete_culto->bind_param("i", $culto_id);
        $delete_culto->execute();
        
        if ($delete_culto->affected_rows > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao deletar culto']);
        }
    } else {
        // Processamento do formulário
$response = array('status' => 'error', 'message' => 'Erro ao cadastrar culto');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST['data'];
    $descricao = $_POST['pregador'];
    $hora = $_POST['numero'];
    $tema = $_POST['tema'];
    $participantes_adultos = $_POST['participantes_adultos'];
    $participantes_criancas = $_POST['participantes_criancas'];
    $visitantes_adultos = $_POST['visitantes_adultos'];
    $visitantes_criancas = $_POST['visitantes_criancas'];
    $ofertas = $_POST['ofertas'];
    $dizimos = $_POST['dizimos'];
    $obs = $_POST['observacoes'];

    // Inserir dados na tabela cultos
    $sql_culto = "INSERT INTO cultos (data, hora, tema, descricao, obs) VALUES ('$data', '$hora', '$tema', '$descricao', '$obs')";

    if ($conn->query($sql_culto) === TRUE) {
        $culto_id = $conn->insert_id; // Obtém o ID do culto inserido

        // Inserir dados na tabela entradas para ofertas
        $sql_ofertas = "INSERT INTO entradas (culto_id, data, descricao, valor, tipo) VALUES ('$culto_id', '$data', 'Ofertas', '$ofertas', 'Oferta')";
        $conn->query($sql_ofertas);

        // Inserir dados na tabela entradas para dízimos
        $sql_dizimos = "INSERT INTO entradas (culto_id, data, descricao, valor, tipo) VALUES ('$culto_id', '$data', 'Dízimos', '$dizimos', 'Dízimo')";
        $conn->query($sql_dizimos);

        // Inserir dados na tabela relatorios_participacao
        $sql_relatorio = "INSERT INTO relatorios_participacao (culto_id, membros_presentes_criancas, membros_presentes_adultos, visitantes_presentes_criancas, visitantes_presentes_adultos, data_relatorio) VALUES ('$culto_id', '$participantes_criancas', '$participantes_adultos', '$visitantes_criancas', '$visitantes_adultos', '$data')";
        $conn->query($sql_relatorio);

        $response = array('status' => 'success', 'message' => 'Novo culto e entradas cadastrados com sucesso!');
    } else {
        $response['message'] = "Erro: " . $sql_culto . "<br>" . $conn->error;
    }
}

$conn->close();

echo json_encode($response);
    }
}
?>
