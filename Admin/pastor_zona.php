<?php
session_start();
include '../partials/conn.php';

// Handle form submission for adding or updating a pastor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $nome = $_POST['nome'];
        $zona = $_POST['zona'];
        $contato = $_POST['contato'];
        $sql = "INSERT INTO pastores_zona (nome, zona, contato) VALUES ('$nome', '$zona', '$contato')";
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $zona = $_POST['zona'];
        $contato = $_POST['contato'];
        $sql = "UPDATE pastores_zona SET nome='$nome', zona='$zona', contato='$contato' WHERE id='$id'";
    }
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Pastor de Zona salvo com sucesso.";
    } else {
        $_SESSION['message'] = "Erro ao salvar Pastor de Zona: " . mysqli_error($conn);
    }
    header('Location: pastores_zona.php');
    exit();
}

// Handle deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM pastores_zona WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Pastor de Zona excluído com sucesso.";
    } else {
        $_SESSION['message'] = "Erro ao excluir Pastor de Zona: " . mysqli_error($conn);
    }
    header('Location: pastores_zona.php');
    exit();
}
?>

<!-- lideres.php -->
<div class="home-tab">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom" style="margin-bottom:5px 5px">
        <h3 class="mb-0">Gerir Pastores de Zonas</h3>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <button class="btn btn-primary mb-3" id="btn-add-pastor">Adicionar Pastor de Zona</button>
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
        }
        ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Zona</th>
                    <th scope="col">Contato</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM pastores_zona";
                $result = mysqli_query($conn, $sql);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['nome'] . '</td>';
                        echo '<td>' . $row['zona'] . '</td>';
                        echo '<td>' . $row['contato'] . '</td>';
                        echo '<td>';
                        echo '<button class="btn btn-sm btn-warning btn-edit" data-id="' . $row['id'] . '" data-nome="' . $row['nome'] . '" data-contato="' . $row['contato'] . '">Editar</button>';
                        echo '<a href="pastores_zona.php?delete=' . $row['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Tem certeza que deseja excluir?\')">Excluir</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>
                        <td colspan="3">Nenhum registro encontrado.</td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
<hr>
        <div id="form-add-pastor" style="display: none;">
            <h2 id="form-title">Adicionar Pastor de Zona</h2>
            <form method="POST">
                <input type="hidden" id="id" name="id">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Pastor de Zona"
                        required>
                </div>
                <div class="form-group">
                    <label for="zona">Zona:</label>
                    <input type="text" class="form-control" id="zona" name="zona" placeholder="Zona de Actuacao"
                        required>
                </div>
                <div class="form-group">
                    <label for="contato">Contato:</label>
                    <input type="text" class="form-control" id="contato" name="contato" placeholder="Contato" required>
                </div>
                <button type="submit" name="add" class="btn btn-primary">Salvar</button>
                <button class="btn btn-danger" id="fechar">Cancelar</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('btn-add-pastor').addEventListener('click', function() {
    document.getElementById('form-title').innerText = "Adicionar Pastor de Zona";
    document.querySelector('form').reset();
    document.getElementById('form-add-pastor').style.display = 'block';
});

document.getElementById('fechar').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('form-add-pastor').style.display = 'none';
});

document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('form-title').innerText = "Editar Pastor de Zona";
        document.getElementById('id').value = this.dataset.id;
        document.getElementById('nome').value = this.dataset.nome;
        document.getElementById('zona').value = this.dataset.zona;
        document.getElementById('contato').value = this.dataset.contato;
        document.getElementById('form-add-pastor').style.display = 'block';
    });
});
</script>