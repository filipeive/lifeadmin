<!-- participacao.php -->
<div class="home-tab">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom" style="margin-bottom:5px 5px">
        <h3 class="mb-0">Participação</h3>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <button class="btn btn-primary mb-3" id="btn-add-participacao">Registrar Participação</button>

        <!-- Tabela de Participação -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Nome do Membro</th>
                    <th scope="col">Participação em Célula</th>
                    <th scope="col">Participação em Culto</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2024-06-28</td>
                    <td>João Santos</td>
                    <td>Sim</td>
                    <td>Sim</td>
                    <td>
                        <button class="btn btn-sm btn-warning">Editar</button>
                        <button class="btn btn-sm btn-danger">Excluir</button>
                    </td>
                </tr>
                <!-- Outras linhas -->
            </tbody>
        </table>

        <!-- Formulário para Registrar Participação -->
        <div id="form-add-participacao" style="display: none;">
            <h2>Registrar Participação</h2>
            <form>
                <div class="form-group">
                    <label for="data">Data:</label>
                    <input type="date" class="form-control" id="data">
                </div>
                <div class="form-group">
                    <label for="membro">Membro:</label>
                    <select class="form-control" id="membro">
                        <option>João Santos</option>
                        <option>Maria Silva</option>
                        <!-- Opções dinâmicas podem ser carregadas do banco de dados -->
                    </select>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="participacaoCelula">
                    <label class="form-check-label" for="participacaoCelula">Participou de Célula?</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="participacaoCulto">
                    <label class="form-check-label" for="participacaoCulto">Participou de Culto?</label>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button class="btn btn-danger" id="fechar">Cancelar</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('btn-add-participacao').addEventListener('click', function() {
    document.getElementById('form-add-participacao').style.display = 'block';
});
document.getElementById('fechar').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('form-add-participacao').style.display = 'none';
});
</script>