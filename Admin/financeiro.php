<!-- financeiro.php -->
<div class="home-tab">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom" style="margin-bottom:5px 5px">
        <h3 class="mb-0">Gerenciar Finanças</h3>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <button class="btn btn-primary mb-3" id="btn-add-transacao">Adicionar Transação</button>
        <button class="btn btn-secondary mb-3" id="btn-gerar-relatorio">Gerar Relatório</button>

        <!-- Saldo Atual -->
        <div class="card mb-3">
            <div class="card-body">
                <h4>Saldo Atual: R$ 10,000.00</h4>
            </div>
        </div>

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
                <tr>
                    <td>2024-06-28</td>
                    <td>Oferta</td>
                    <td>Entrada</td>
                    <td>R$ 500.00</td>
                    <td>
                        <button class="btn btn-sm btn-warning">Editar</button>
                        <button class="btn btn-sm btn-danger">Excluir</button>
                    </td>
                </tr>
                <!-- Outras linhas -->
            </tbody>
        </table>

        <!-- Formulário para Adicionar Transação -->
        <div id="form-add-transacao" style="display: none;">
            <h2>Adicionar Transação</h2>
            <form>
                <div class="form-group">
                    <label for="data">Data:</label>
                    <input type="date" class="form-control" id="data">
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <input type="text" class="form-control" id="descricao" placeholder="Descrição da Transação">
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo:</label>
                    <select class="form-control" id="tipo">
                        <option value="entrada">Entrada</option>
                        <option value="saida">Saída</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="valor">Valor:</label>
                    <input type="text" class="form-control" id="valor" placeholder="R$">
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
                <tr>
                    <td>2024-06-27</td>
                    <td>Compra de Material</td>
                    <td>R$ 200.00</td>
                    <td>Pendente</td>
                    <td>
                        <button class="btn btn-sm btn-success">Despachar</button>
                        <button class="btn btn-sm btn-danger">Rejeitar</button>
                    </td>
                </tr>
                <!-- Outras linhas -->
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
</script>