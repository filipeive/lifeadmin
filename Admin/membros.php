<!-- membros.php -->
<div class="home-tab">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom" style="margin-bottom:5px 5px">
        <h3 class="mb-0">Gerenciar Membros</h3>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <button class="btn btn-primary mb-3" id="btn-add-membro">Adicionar Membro</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Zona</th>
                    <th scope="col">Líder</th>
                    <th scope="col">Discipulado</th>
                    <th scope="col">Baptizado</th>
                    <th scope="col">Contato</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>João Pereira</td>
                    <td>Zona 1</td>
                    <td>Maria Silva</td>
                    <td>Sim</td>
                    <td>Não</td>
                    <td>(11) 98765-4321</td>
                    <td>
                        <button class="btn btn-sm btn-warning">Editar</button>
                        <button class="btn btn-sm btn-danger">Excluir</button>
                    </td>
                </tr>
                <!-- Outras linhas -->
            </tbody>
        </table>

        <div id="form-add-membro" style="display: none;">
            <h2>Adicionar Membro</h2>
            <form>
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" placeholder="Nome do Membro">
                </div>
                <div class="form-group">
                    <label for="zona">Zona:</label>
                    <input type="text" class="form-control" id="zona" placeholder="Zona">
                </div>
                <div class="form-group">
                    <label for="lider">Líder:</label>
                    <input type="text" class="form-control" id="lider" placeholder="Nome do Líder">
                </div>
                <div class="form-group">
                    <label for="discipulado">Discipulado:</label>
                    <select class="form-control" id="discipulado">
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="baptizado">Baptizado:</label>
                    <select class="form-control" id="baptizado">
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="auxiliar">Auxiliar do Líder:</label>
                    <input type="text" class="form-control" id="auxiliar" placeholder="Nome do Auxiliar">
                </div>
                <div class="form-group">
                    <label for="contato">Contato:</label>
                    <input type="text" class="form-control" id="contato" placeholder="Contato">
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button class="btn btn-danger" id="fechar">Cancelar</button>
            </form>
        </div>
    </div>
</div>
<hr>
<script>
document.getElementById('btn-add-membro').addEventListener('click', function() {
    document.getElementById('form-add-membro').style.display = 'block';
});
document.getElementById('fechar').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('form-add-membro').style.display = 'none';
});
</script>