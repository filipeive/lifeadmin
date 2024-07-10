<?php
include "../partials/conn.php";

// Carregar a lista de líderes
$sql_lideres = "SELECT id, nome FROM lideres";
$result_lideres = mysqli_query($conn, $sql_lideres);

$sql_zonas = "SELECT id, nome FROM zonas";
$result_zonas = mysqli_query($conn, $sql_zonas);

$sql_supervisores = "SELECT id, nome FROM supervisores";
$result_supervisores = mysqli_query($conn, $sql_supervisores);

$message = '';

// Verifica se há uma mensagem na sessão
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Remove a mensagem da sessão após exibi-la
}
?>
<!-- lideres.php -->
<div class="home-tab">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom" style="margin-bottom:5px 5px">
        <h3 class="mb-0">Gerir Líderes</h3>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <button class="btn btn-primary mb-3" id="btn-add-lider">Adicionar Líder</button>
        <!-- Tabela de Líderes -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Zona</th>
                    <th scope="col">Supervisor</th>
                    <th scope="col">Auxiliar</th>
                    <th scope="col">Contato</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result_lideres)) {
                    echo "<tr>";
                    echo "<td>{$row['nome']}</td>";
                    echo "<td>Zona</td>"; // Aqui você precisa substituir pela coluna correta
                    echo "<td>Supervisor</td>"; // Aqui você precisa substituir pela coluna correta
                    echo "<td>Auxiliar</td>"; // Se necessário, adicione uma coluna para auxiliar
                    echo "<td>(11) 98765-4321</td>"; // Aqui você precisa substituir pela coluna correta de contato
                    echo "<td>";
                    echo '<button class="btn btn-sm btn-warning">Editar</button>';
                    echo '<button class="btn btn-sm btn-danger">Excluir</button>';
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <hr>

        <!-- Formulário para adicionar Líder -->
        <div id="form-add-lider" style="display: none;">
            <h2>Adicionar Líder</h2>
            <form>
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" placeholder="Nome do Líder">
                </div>
                <div class="form-group">
                    <label for="area">Área:</label>
                    <input type="text" class="form-control" id="area" placeholder="Área de Liderança">
                </div>
                <div class="form-group">
                    <label for="supervisor">Supervisor:</label>
                    <select class="form-control" id="supervisor">
                        <?php
                        while ($row = mysqli_fetch_assoc($result_supervisores)) {
                            echo "<option>{$row['nome']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="auxiliar">Auxiliar:</label>
                    <input type="text" class="form-control" id="auxiliar" placeholder="Auxiliar do Líder">
                </div>
                <div class="form-group">
                    <label for="contato">Contato:</label>
                    <input type="text" class="form-control" id="contato" placeholder="Contato do Líder">
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button class="btn btn-danger" id="fechar">Cancelar</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('btn-add-lider').addEventListener('click', function() {
    document.getElementById('form-add-lider').style.display = 'block';
});
document.getElementById('fechar').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('form-add-lider').style.display = 'none';
});
</script>
