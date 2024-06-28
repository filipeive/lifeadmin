<!-- lideres.php -->
<div class="home-tab">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom" style="margin-bottom:5px 5px">
        <h3 class="mb-0">Gerir Lideres</h3>
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
                    <th scope="col">Área</th>
                    <th scope="col">Supervisor</th>
                    <th scope="col">Auxiliar</th>
                    <th scope="col">Contato</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>João Santos</td>
                    <td>Células</td>
                    <td>Maria Silva</td>
                    <td>Ana Souza</td>
                    <td>(11) 98765-4321</td>
                    <td>
                        <button class="btn btn-sm btn-warning">Editar</button>
                        <button class="btn btn-sm btn-danger">Excluir</button>
                    </td>
                </tr>
                <!-- Outras linhas -->
            </tbody>
        </table>

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
                        <option>Maria Silva</option>
                        <option>João Oliveira</option>
                        <!-- Opções dinâmicas podem ser carregadas do banco de dados -->
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