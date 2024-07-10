<!-- financeiro.php -->
<?php
include "../partials/conn.php";

// Recuperar entradas
$sql_entradas = "SELECT * FROM entradas";
$result_entradas = $conn->query($sql_entradas);

// Calcular saldo total a partir das entradas
$saldo_total = 0;
while ($row = $result_entradas->fetch_assoc()) {
    $saldo_total += $row['valor'];
}

// Recuperar saídas
$sql_saidas = "SELECT * FROM saidas";
$result_saidas = $conn->query($sql_saidas);

// Subtrair os valores das saídas do saldo total
while ($row = $result_saidas->fetch_assoc()) {
    $saldo_total -= $row['valor'];
}

// Recuperar requisições
$sql_requisicoes = "SELECT * FROM requisicoes";
$result_requisicoes = $conn->query($sql_requisicoes);
?>
 <div class="home-tab">
        <div class="d-sm-flex align-items-center justify-content-between border-bottom" style="margin-bottom:5px 5px">
            <h3 class="mb-0">Gerenciar Finanças</h3>
        </div>
        <!-- Saldo Atual -->
         <br>
        <div class="card mb-3">
                <div class="card-body">
                    <h4>Saldo Atual: MZN <?php echo number_format($saldo_total, 2, ',', '.'); ?></h4>
                </div>
            </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <button class="btn btn-primary mb-3" id="btn-add-transacao">Adicionar Transação</button>
            <button class="btn btn-secondary mb-3" id="btn-gerar-relatorio">Gerar Relatório</button>

            <!-- Tabela de Transações -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Data</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Exibir entradas
                    $result_entradas->data_seek(0); // Resetar o ponteiro para o início
                    while ($row = $result_entradas->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['data']; ?></td>
                            <td><?php echo $row['descricao']; ?></td>
                            <td>Entrada</td>
                            <td>MZN <?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning">Editar</button>
                                <button class="btn btn-sm btn-danger btn-delete">Excluir</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <?php 
                    // Exibir saídas
                    while ($row = $result_saidas->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['data']; ?></td>
                            <td><?php echo $row['descricao']; ?></td>
                            <td>Saída</td>
                            <td>MZN <?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning">Editar</button>
                                <button class="btn btn-sm btn-danger">Excluir</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <hr>
            <!-- Formulário para Adicionar Transação -->
            <div id="form-add-transacao" style="display: none;">
                <h2>Adicionar Transação</h2>
                <form id="add-transacao-form">
                    <div class="form-group">
                        <label for="data">Data:</label>
                        <input type="date" class="form-control" id="data" name="data">
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição:</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição da Transação">
                    </div>
                    <div class="form-group">
                        <label for="tipo">Tipo:</label>
                        <select class="form-control" id="tipo" name="tipo">
                            <option value="entrada">Entrada</option>
                            <option value="saida">Saída</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="valor">Valor:</label>
                        <input type="text" class="form-control" id="valor" name="valor" placeholder="R$">
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>

            <!-- Tabela de Requisições -->
            <h2>Requisições</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Data</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_requisicoes->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['data']; ?></td>
                            <td><?php echo $row['descricao']; ?></td>
                            <td>MZN <?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <button class="btn btn-sm btn-success">Despachar</button>
                                <button class="btn btn-sm btn-danger">Rejeitar</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
    document.getElementById('btn-add-transacao').addEventListener('click', function() {
        document.getElementById('form-add-transacao').style.display = 'block';
    });

    document.getElementById('btn-gerar-relatorio').addEventListener('click', function() {
        // Lógica para gerar relatório (pode abrir uma nova janela ou gerar um PDF)
        alert('Relatório gerado!');
    });

    document.getElementById('add-transacao-form').addEventListener('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        fetch('adicionar_transacao.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log(data);
                alert('Transação adicionada com sucesso!');
                location.reload();
            } else {
                alert('Erro ao adicionar transação: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao adicionar transação. Verifique o console para mais detalhes.');
        });
    });
    // Adicionar evento de clique para botões de exclusão
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function() {
        var id = this.getAttribute('data-id');
        if (confirm('Você tem certeza que deseja excluir esta trnasicao?')) {
            fetch('excluir_transicao.php?id=' + id, { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Transicao excluído com sucesso');
                         loadContent('usuarios.php');
                    } else {
                        alert('Erro ao excluir transicao');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
});
    </script>

