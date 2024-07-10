<?php
// Incluir arquivo de configuração do banco de dados
include '..partials/conn.php';

// Verificar se o parâmetro ID foi passado pela URL
if (isset($_GET['id'])) {
    $supervisor_id = $_GET['id'];

    // Consulta SQL para selecionar os dados do supervisor pelo ID
    $sql = "SELECT * FROM supervisores WHERE id = $supervisor_id";
    $result = $conn->query($sql);

   if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        echo '<div class="modal-details">';
        echo '<h4>Detalhes do Culto</h4>'.'</hr>';
        echo '<p><strong>Nome:</strong> ' . $row['nome'] . '</p>';
        echo '<p><strong>Zona:</strong> ' . $row['zona_id'] . '</p>';
        echo '<p><strong>Contacto:</strong> ' . $row['contacto'] . '</p>';
        echo '<p><strong>Pastor de Zona:</strong> ' . $row['membros_adultos'] . '</p>';
        echo '</div>';
    } else {
        echo '<p>Erro ao carregar detalhes do Supervisor.</p>';
    }
} else {
    echo '<p>ID do culto não fornecido.</p>';
}
?>