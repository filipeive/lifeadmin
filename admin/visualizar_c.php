<?php
include "../partials/conn.php";

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $culto_id = $_GET['id'];

    $sql = "SELECT cultos.*, 
                   SUM(entradas.valor) AS total_ofertas, 
                   SUM(CASE WHEN entradas.tipo = 'Dízimo' THEN entradas.valor ELSE 0 END) AS total_dizimos,
                   SUM(relatorios_participacao.membros_presentes_criancas) AS membros_criancas,
                   SUM(relatorios_participacao.membros_presentes_adultos) AS membros_adultos,
                   SUM(relatorios_participacao.visitantes_presentes_criancas) AS visitantes_criancas,
                   SUM(relatorios_participacao.visitantes_presentes_adultos) AS visitantes_adultos
            FROM cultos
            LEFT JOIN entradas ON cultos.id = entradas.culto_id
            LEFT JOIN relatorios_participacao ON cultos.id = relatorios_participacao.culto_id
            WHERE cultos.id = ?
            GROUP BY cultos.id";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $culto_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $data = [
                'id' => $row['id'],
                'data' => $row['data'],
                'pregador' => $row['descricao'],
                'hora' => $row['hora'],
                'tema' => $row['tema'],
                'observacoes' => $row['obs'],
                'participantes_adultos' => $row['membros_adultos'],
                'participantes_criancas' => $row['membros_criancas'],
                'visitantes_adultos' => $row['visitantes_adultos'],
                'visitantes_criancas' => $row['visitantes_criancas'],
                'ofertas' => $row['total_ofertas'],
                'dizimos' => $row['total_dizimos']
            ];

            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'Culto não encontrado']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Erro ao preparar consulta']);
    }
} else {
    echo json_encode(['error' => 'ID do culto não fornecido']);
}
$conn->close();
?>
