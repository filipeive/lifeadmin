<!-- cultos.php -->
<div class="home-tab">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom" style="margin-bottom:5px 5px">
        <h3 class="mb-0">Gerenciar Relatorios de Culto</h3>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <button class="btn btn-primary mb-3" id="btn-add-culto">Adicionar Dados do Culto</button>

        <!-- Tabela de Cultos -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Número do Culto</th>
                    <th scope="col">Tema da Mensagem</th>
                    <th scope="col">Participantes</th>
                    <th scope="col">Visitantes</th>
                    <th scope="col">Total Ofertas</th>
                    <th scope="col">Total Dízimos</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2024-06-28</td>
                    <td>1</td>
                    <td>O Poder da Oração</td>
                    <td>50</td>
                    <td>10</td>
                    <td>R$ 500,00</td>
                    <td>R$ 300,00</td>
                    <td>
                        <button class="btn btn-sm btn-warning">Editar</button>
                        <button class="btn btn-sm btn-danger">Excluir</button>
                    </td>
                </tr>
                <!-- Outras linhas -->
            </tbody>
        </table>

        <!-- Formulário para Adicionar Culto -->
        <div id="form-add-culto" style="display: none;">
            <h2>Adicionar Culto</h2>
            <form>
                <div class="form-group">
                    <label for="data">Data:</label>
                    <input type="date" class="form-control" id="data">
                </div>
                <div class="form-group">
                    <label for="pregador">Pregador:</label>
                    <input type="text" class="form-control" id="pregador" placeholder="Nome do Pregador">
                </div>
                <div class="form-group">
                    <label for="numero">Número do Culto:</label>
                    <input type="text" class="form-control" id="numero" placeholder="Número do Culto">
                </div>
                <div class="form-group">
                    <label for="tema">Tema da Mensagem:</label>
                    <input type="text" class="form-control" id="tema" placeholder="Tema da Mensagem">
                </div>
                <div class="form-group">
                    <label for="participantes">Número de Participantes:</label>
                    <input type="number" class="form-control" id="participantes">
                </div>
                <div class="form-group">
                    <label for="visitantes">Número de Visitantes:</label>
                    <input type="number" class="form-control" id="visitantes">
                </div>
                <div class="form-group">
                    <label for="ofertas">Total de Ofertas:</label>
                    <input type="text" class="form-control" id="ofertas" placeholder="R$">
                </div>
                <div class="form-group">
                    <label for="dizimos">Total de Dízimos:</label>
                    <input type="text" class="form-control" id="dizimos" placeholder="R$">
                </div>
                <div class="form-group">
                    <label for="observacoes">Observações Gerais:</label>
                    <textarea class="form-control" id="observacoes" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button class="btn btn-danger" id="fechar">Cancelar</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('btn-add-culto').addEventListener('click', function() {
    document.getElementById('form-add-culto').style.display = 'block';
});
document.getElementById('fechar').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('form-add-culto').style.display = 'none';
});
</script>