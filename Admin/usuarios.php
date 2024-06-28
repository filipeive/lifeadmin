<?php
include "../partials/conn.php";

// Obter lista de usuários com limitação
$limit = 6; // Limite de registros por página
$order = isset($_GET['order']) ? $_GET['order'] : 'nome';
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM usuarios WHERE nome LIKE '%$search%' ORDER BY $order LIMIT $limit";
$result = $conn->query($sql);
?>

<div class="home-tab">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom" style="margin-bottom:5px 5px">
        <h3 class="mb-0">Gerir Usuários</h3>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-primary" id="btn-add-usuario">Adicionar Usuário</button>
            <input type="text" id="search" class="form-control w-25" placeholder="Pesquisar usuário">
        </div>
        
        <!-- Cards de Feedback -->
        <div id="feedback-success" class="alert alert-success" style="display: none;">
            <strong>Sucesso!</strong> Usuário adicionado com sucesso.
        </div>
        <div id="feedback-error" class="alert alert-danger" style="display: none;">
            <strong>Erro!</strong> Não foi possível adicionar o usuário.
        </div>

        <!-- Tabela de Usuários -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Perfil</th>
                    <th scope="col">Data de Criação</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nome']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['perfil']}</td>
                                <td>{$row['data_criacao']}</td>
                                <td>
                                    <button class='btn btn-sm btn-warning btn-edit' data-id='{$row['id']}'>Editar</button>
                                    <button class='btn btn-sm btn-danger btn-delete' data-id='{$row['id']}'>Excluir</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum usuário encontrado</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Formulário para adicionar Usuário -->
        <div id="form-add-usuario" style="display: none;">
            <h2>Adicionar Usuário</h2>
            <form id="add-usuario-form">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Usuário" requered>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email do Usuário" requred>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" requered>
                </div>
                <div class="form-group">
                    <label for="perfil">Perfil:</label>
                    <select class="form-control" id="perfil" name="perfil">
                        <option value="usuario">Usuário</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button class="btn btn-danger" id="fechar-usuario">Cancelar</button>
            </form>
        </div>

        <!-- Formulário para editar Usuário -->
        <div id="form-edit-usuario" style="display: none;">
            <h2>Editar Usuário</h2>
            <form id="edit-usuario-form">
                <input type="hidden" id="edit-id" name="id">
                <div class="form-group">
                    <label for="edit-nome">Nome:</label>
                    <input type="text" class="form-control" id="edit-nome" name="nome" placeholder="Nome do Usuário">
                </div>
                <div class="form-group">
                    <label for="edit-email">Email:</label>
                    <input type="email" class="form-control" id="edit-email" name="email" placeholder="Email do Usuário">
                </div>
                <div class="form-group">
                    <label for="edit-senha">Senha:</label>
                    <input type="password" class="form-control" id="edit-senha" name="senha" placeholder="Senha">
                </div>
                <div class="form-group">
                    <label for="edit-perfil">Perfil:</label>
                    <select class="form-control" id="edit-perfil" name="perfil">
                        <option value="usuario">Usuário</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button class="btn btn-danger" id="fechar-edit-usuario">Cancelar</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('btn-add-usuario').addEventListener('click', function() {
    document.getElementById('form-add-usuario').style.display = 'block';
});
document.getElementById('fechar-usuario').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('form-add-usuario').style.display = 'none';
});
document.getElementById('fechar-edit-usuario').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('form-edit-usuario').style.display = 'none';
});

document.getElementById('search').addEventListener('keyup', function() {
    var searchValue = this.value;
    window.location.href = '?search=' + searchValue;
});

// Adicionar evento de clique para botões de edição
document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', function() {
        var id = this.getAttribute('data-id');
        fetch('obter_usuario.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit-id').value = data.id;
                document.getElementById('edit-nome').value = data.nome;
                document.getElementById('edit-email').value = data.email;
                document.getElementById('edit-senha').value = ''; // ou algum valor padrão
                document.getElementById('edit-perfil').value = data.perfil;
                document.getElementById('form-edit-usuario').style.display = 'block';
            })
            .catch(error => console.error('Error:', error));
    });
});

// Adicionar evento de clique para botões de exclusão
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function() {
        var id = this.getAttribute('data-id');
        if (confirm('Você tem certeza que deseja excluir este usuário?')) {
            fetch('excluir_usuario.php?id=' + id, { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Usuário excluído com sucesso');
                         loadContent('usuarios.php');
                    } else {
                        alert('Erro ao excluir usuário');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
});
document.getElementById('add-usuario-form').addEventListener('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    fetch('cadastrar_usuario.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            document.getElementById('feedback-success').style.display = 'block';
            document.getElementById('feedback-error').style.display = 'none';
        } else {
            document.getElementById('feedback-success').style.display = 'none';
            document.getElementById('feedback-error').style.display = 'block';
            document.getElementById('feedback-error').innerHTML = `<strong>Erro!</strong> ${data.message}`;
        }
        document.getElementById('form-add-usuario').style.display = 'none';
        //location.reload(); // Recarrega a página para atualizar a tabela
        alert('Cadastro realizado com sucesso!');
        loadContent('usuarios.php');
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('feedback-success').style.display = 'none';
        document.getElementById('feedback-error').style.display = 'block';
        document.getElementById('feedback-error').innerHTML = `<strong>Erro!</strong> ${error}`;
    });
});
</script>
