<?php
// Verifica se o parâmetro page foi recebido via POST
if (isset($_POST['page'])) {
    $page = $_POST['page'];

    // Utiliza switch case para carregar o conteúdo da página conforme o parâmetro
    switch ($page) {
        case 'report_view':
        include 'report_view.php';
        break;
        case 'dashboard':
            include 'dashboard.php';
            break;
        case 'cultos':
            include 'cultos.php';
            break;
        case 'financeiro':
            include 'financeiro.php';
            break;
        default:
            echo 'Página não encontrada';
            break;
    }
} else {
    echo 'Erro: Parâmetro page não recebido';
}
?>
