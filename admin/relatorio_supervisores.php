<?php
// Consulta SQL para contar supervisores por zona
$sql_count_supervisores = "SELECT zonas.nome AS zona_nome, COUNT(supervisores.id) AS total_supervisores
                           FROM zonas
                           LEFT JOIN supervisores ON zonas.id = supervisores.zona_id
                           GROUP BY zonas.id";

$result_count_supervisores = mysqli_query($conn, $sql_count_supervisores);

// Verifique se há resultados válidos
if ($result_count_supervisores && mysqli_num_rows($result_count_supervisores) > 0) {
    echo '<h2>Relatório de Supervisores por Zona</h2>';
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Zona</th>';
    echo '<th scope="col">Total de Supervisores</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_assoc($result_count_supervisores)) {
        echo '<tr>';
        echo '<td>' . $row['zona_nome'] . '</td>';
        echo '<td>' . $row['total_supervisores'] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>Nenhum registro encontrado.</p>';
}

// Liberar resultado da consulta
mysqli_free_result($result_count_supervisores);
?>
