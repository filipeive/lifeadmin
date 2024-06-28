<?php
include "../partials/conn.php";

// Carregar a lista de pastores de zona
$sql_pastores = "SELECT id, nome, area FROM pastores_zona";
$result_pastores = mysqli_query($conn, $sql_pastores);
?>

<div class="home-tab">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom" style="margin-bottom:5px 5px">
        <h3 class="mb-0">Supervisores</h3>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <button class="btn btn-primary mb-3" id="btn-add-supervisor">Adicionar Supervisor</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Zona</th>
                    <th scope="col">Contato</th>
                    <th scope="col">Pastor de Zona</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT supervisores.*, pastores_zona.nome AS pastor_nome FROM supervisores
                        LEFT JOIN pastores_zona ON supervisores.pastor_zona_id = pastores_zona.id";
                $result = mysqli_query($conn, $sql);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['nome'] . '</td>';
                        echo '<td>' . $row['area'] . '</td>';
                        echo '<td>' . $row['contato'] . '</td>';
                        echo '<td>' . $row['pastor_nome'] . '</td>';
                        echo '<td>';
                        echo '<button class="btn btn-sm btn-warning">Editar</button>';
                        echo '<button class="btn btn-sm btn-danger">Excluir</button>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>
                        <td colspan="5">Nenhum registro encontrado.</td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>

        <div id="form-add-supervisor" style="display: none;">
            <h2>Adicionar Supervisor</h2>
            <form action="add_supervisor.php" method="POST">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Supervisor" required>
                </div>
                <div class="form-group">
                    <label for="zona">Área:</label>
                    <input type="text" class="form-control" id="zona" name="zona" placeholder="Área de Supervisão" required>
                </div>
                <div class="form-group">
                    <label for="contato">Contato:</label>
                    <input type="text" class="form-control" id="contato" name="contato" placeholder="Contato" required>
                </div>
                <div class="form-group">
                    <label for="pastor_zona_id">Pastor de Zona:</label>
                    <select class="form-control" id="pastor_zona_id" name="pastor_zona_id" required>
                        <?php
                        while ($pastor = mysqli_fetch_assoc($result_pastores)) {
                            echo '<option value="' . $pastor['id'] . '">' . $pastor['nome'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button class="btn btn-danger" id="fechar">Cancelar</button>
            </form>
        </div>
        <script>
        document.getElementById('btn-add-supervisor').addEventListener('click', function() {
            document.getElementById('form-add-supervisor').style.display = 'block';
        });
        document.getElementById('fechar').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('form-add-supervisor').style.display = 'none';
        });
        </script>
    </div>
</div>
