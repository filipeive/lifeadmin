<?php
include "../partials/conn.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    // Recebe os dados do formulário
    $culto_id = $input['id'];
    $data = $input['data'];
    $pregador = $input['pregador'];
    $hora = $input['hora'];
    $tema = $input['tema'];
    $participantes_adultos = $input['participantes_adultos'];
    $participantes_criancas = $input['participantes_criancas'];
    $visitantes_adultos = $input['visitantes_adultos'];
    $visitantes_criancas = $input['visitantes_criancas'];
    $ofertas = $input['ofertas'];
    $dizimos = $input['dizimos'];
    $observacoes = $input['observacoes'];

    // Validação simples
    if (empty($culto_id) || empty($data) || empty($pregador) || empty($hora) || empty($tema)) {
        echo json_encode(['error' => 'Por favor, preencha todos os campos obrigatórios.']);
        exit;
    }

    // Atualiza os dados do culto
    $sql = "UPDATE cultos SET data = ?, descricao = ?, hora = ?, tema = ?, obs = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssi', $data, $pregador, $hora, $tema, $observacoes, $culto_id);

    if ($stmt->execute()) {
        $sql_participacao = "UPDATE relatorios_participacao SET 
                                membros_presentes_adultos = ?, 
                                membros_presentes_criancas = ?, 
                                visitantes_presentes_adultos = ?, 
                                visitantes_presentes_criancas = ?
                            WHERE culto_id = ?";
        $stmt_participacao = $conn->prepare($sql_participacao);
        $stmt_participacao->bind_param('iiiii', $participantes_adultos, $participantes_criancas, $visitantes_adultos, $visitantes_criancas, $culto_id);
        $stmt_participacao->execute();

        $sql_ofertas = "UPDATE entradas SET valor = ? WHERE culto_id = ? AND tipo = 'Oferta'";
        $stmt_ofertas = $conn->prepare($sql_ofertas);
        $stmt_ofertas->bind_param('di', $ofertas, $culto_id);
        $stmt_ofertas->execute();

        $sql_dizimos = "UPDATE entradas SET valor = ? WHERE culto_id = ? AND tipo = 'Dízimo'";
        $stmt_dizimos = $conn->prepare($sql_dizimos);
        $stmt_dizimos->bind_param('di', $dizimos, $culto_id);
        $stmt_dizimos->execute();

        echo json_encode(['success' => 'Culto atualizado com sucesso.']);
    } else {
        echo json_encode(['error' => 'Erro ao atualizar culto.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'Método inválido. Utilize POST.']);
}
?>
