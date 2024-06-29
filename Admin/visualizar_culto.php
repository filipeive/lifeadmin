<?php
include "../partials/conn.php";

if (isset($_GET['id'])) {
    $culto_id = $_GET['id'];

    $sql = "SELECT cultos.*, SUM(entradas.valor) AS total_ofertas, 
                   SUM(CASE WHEN entradas.tipo = 'Dízimo' THEN entradas.valor ELSE 0 END) AS total_dizimos,
                   SUM(relatorios_participacao.membros_presentes_criancas) AS membros_criancas,
                   SUM(relatorios_participacao.membros_presentes_adultos) AS membros_adultos,
                   SUM(relatorios_participacao.visitantes_presentes_criancas) AS visitantes_criancas,
                   SUM(relatorios_participacao.visitantes_presentes_adultos) AS visitantes_adultos
            FROM cultos
            LEFT JOIN entradas ON cultos.id = entradas.culto_id
            LEFT JOIN relatorios_participacao ON cultos.id = relatorios_participacao.culto_id
            WHERE cultos.id = $culto_id
            GROUP BY cultos.id";

    $result = $conn->query($sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        echo '<div class="modal-details">';
        echo '<h4>Detalhes do Culto</h4>'.'</hr>';
        echo '<p><strong>Data:</strong> ' . $row['data'] . '</p>';
        echo '<p><strong>Hora:</strong> ' . $row['hora'] . '</p>';
        echo '<p><strong>Tema:</strong> ' . $row['tema'] . '</p>';
        echo '<p><strong>Total de Participantes:</strong> ' . ($row['membros_criancas'] + $row['membros_adultos']) . '</p>';
        echo '<p><strong>Membros Presentes (Adultos):</strong> ' . $row['membros_adultos'] . '</p>';
        echo '<p><strong>Membros Presentes (Crianças):</strong> ' . $row['membros_criancas'] . '</p>';
        echo '<p><strong>Total de Visitantes:</strong> ' . ($row['visitantes_criancas'] + $row['visitantes_adultos']) . '</p>';
        echo '<p><strong>Visitantes Presentes (Adultos):</strong> ' . $row['visitantes_adultos'] . '</p>';
        echo '<p><strong>Visitantes Presentes (Crianças):</strong> ' . $row['visitantes_criancas'] . '</p>';
        echo '<p><strong>Total de Ofertas:</strong> MT ' . number_format($row['total_ofertas'], 2, ',', '.') . '</p>';
        echo '<p><strong>Total de Dízimos:</strong> MT ' . number_format($row['total_dizimos'], 2, ',', '.') . '</p>';
        echo '</div>';
    } else {
        echo '<p>Erro ao carregar detalhes do culto.</p>';
    }
} else {
    echo '<p>ID do culto não fornecido.</p>';
}
?>
