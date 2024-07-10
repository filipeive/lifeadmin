<?php
include "../partials/conn.php";

if (isset($_GET['id'])) {
    $supervisor_id = $_GET['id'];
    
    // Verificar se o supervisor existe
    $check_sql = "SELECT * FROM supervisores WHERE id = $supervisor_id";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        // Excluir o supervisor
        $delete_sql = "DELETE FROM supervisores WHERE id = $supervisor_id";
        
        if (mysqli_query($conn, $delete_sql)) {
            // Redirecionar com mensagem de sucesso
            header("Location: supervisores.php?message=success");
            exit();
        } else {
            // Redirecionar com mensagem de erro
            header("Location: supervisores.php?message=error");
            exit();
        }
    } else {
        // Redirecionar com mensagem de ID inválido
        header("Location: supervisores.php?message=invalid");
        exit();
    }
} else {
    // Redirecionar com mensagem de ID não especificado
    header("Location: supervisores.php?message=invalid");
    exit();
}
?>
