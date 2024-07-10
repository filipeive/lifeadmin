<?php
include "../partials/conn.php";

// Carregar a lista de pastores de zona
$sql_pastores = "SELECT id, nome FROM pastores_zona";
$result_pastores = mysqli_query($conn, $sql_pastores);

$sql_zona = "SELECT id, nome FROM zonas";
$result_zonas = mysqli_query($conn, $sql_zona);

$sql_supervisores = "SELECT id, nome FROM supervisores";
$result_supervisores = mysqli_query($conn, $sql_supervisores);

$message = '';

// Verifica se há uma mensagem na sessão
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Remove a mensagem da sessão após exibi-la
}
?>
<style>
#feedback-success {
    z-index: 1000;
    color: green;
}

/* Estilo para modais */
.modal {
    display: none;
    /* Ocultar por padrão */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    /* Fundo semi-transparente */
    overflow: auto;
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    border-radius: 5px;
    position: relative;
}

.close {
    /*color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;*/
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>
<div class="home-tab">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom" style="margin-bottom:5px 5px">
        <h3 class="mb-0">Supervisores</h3>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-primary mb-3" id="btn-add-supervisor">Adicionar Supervisor</button>
            <input type="text" id="inputPesquisarSupervisores" class="form-control w-25" placeholder="Pesquisar usuário"
                aria-label="Pesquisar Supervisor" onkeyup="filtrarSupervisor()">
        </div>
        <!-- Cards de Feedback -->
        <div id="feedback-error" class="alert alert-danger" style="display: none;">
            <strong>Erro!</strong> Não foi possível adicionar o usuário.
        </div>
        <div id="tabela">
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
                    $sql = "SELECT supervisores.*, 
                            pastores_zona.nome AS pastor_nome, 
                            zonas.nome AS zona_nome
                            FROM supervisores
                            LEFT JOIN pastores_zona ON supervisores.pastor_zona_id = pastores_zona.id
                            LEFT JOIN zonas ON supervisores.zona_id = zonas.id";
                    // Execute a consulta SQL
                    $result = mysqli_query($conn, $sql);

                    // Verifique se há resultados válidos
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $row['nome'] . '</td>';
                            echo '<td>' . $row['zona_nome'] . '</td>';
                            echo '<td>' . $row['contato'] . '</td>';
                            echo '<td>' . $row['pastor_nome'] . '</td>';
                            echo '<td>';
                            
                            //echo '<button class="btn btn-sm btn-warning btn-edit" data-id="' . $row['id'] . '">Editar</button>';
                            echo '<button id="btn-edit-supervisor"' . $row['id'] . '" class="btn btn-sm btn-warning">Editar</button> ';
                            echo '<a href="excluir_supervisor.php?id=' . $row['id'] . '" class="btn btn-sm btn-danger">Excluir</a> ';
                            echo '<a href="visualizar_supervisor.php?id=' . $row['id'] . '" class="btn btn-sm btn-info">Visualizar</a> ';
                            //echo '<a href="imprimir_relatorio.php?zona_id=' . $row['zona_id'] . '" class="btn btn-sm btn-primary">Imprimir Relatório</a>';
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
        </div>

        <hr>
        <div id="modal-add-supervisor" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Adicionar Supervisor</h2>
                <form id="form-add-supervisor" method="POST">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Supervisor"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="zona">Zona:</label>
                        <select class="form-control" id="zona" name="zona" required>
                            <?php
                        while ($zona = mysqli_fetch_assoc($result_zonas)) {
                            echo '<option value="' . $zona['id'] . '">' . $zona['nome'] . '</option>';
                        }
                        ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="contato">Contato:</label>
                        <input type="text" class="form-control" id="contato" name="contato" placeholder="Contato"
                            required>
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
                    <button class="btn btn-danger close" id="fechar">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Modal de Feedback -->
<div id="modal-feedback" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="feedback-message" class="alert alert-success">
            <strong>Sucesso!</strong> Supervisor adicionado com sucesso.
        </div>
    </div>
</div>
<h2>Editar Supervisor</h2>

<!-- Botão para abrir Modal de Edição -->
<!--<button id="btn-edit-supervisor" class="btn btn-primary">Editar Supervisor</button>-->
<!-- Modal de Edição -->
<div id="modal-edit-supervisor" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="form-edit-supervisor">
            <input type="hidden" id="supervisor_id">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="contato">Contato:</label>
            <input type="text" id="contato" name="contato" required><br><br>

            <label for="zona_id">Zona:</label>
            <!-- Campo select para selecionar a zona -->
            <select id="zona_id" name="zona_id" required>
                <?php
                    // Código para preencher as opções do select de zonas
                    while ($zona = mysqli_fetch_assoc($result_zonas)) {
                    echo '<option value="' . $zona['id'] . '">' . $zona['nome'] . '</option>';
                    }
                    ?>
            </select><br><br>

            <label for="pastor_zona_id">Pastor de Zona:</label>
            <!-- Campo select para selecionar o pastor de zona -->
            <select id="pastor_zona_id" name="pastor_zona_id" required>
                <?php
                    // Código para preencher as opções do select de pastores de zona
                    while ($pastor = mysqli_fetch_assoc($result_pastores)) {
                    echo '<option value="' . $pastor['id'] . '">' . $pastor['nome'] . '</option>';
                    }
                    ?>
            </select><br><br>

            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</div>
<div class="modal-body" id="culto-details">
    <!-- Os detalhes do supervisor serão carregados aqui -->
</div>
<!-- Modal de Feedback -->
<div id="modal-feedback" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="feedback-message"></div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Abrir Modal de Adicionar Supervisor ao clicar no botão correspondente
    $('#btn-add-supervisor').click(function() {
        $('#modal-add-supervisor').css('display', 'block');
    });

    // Fechar Modais ao clicar no botão de fechar ou fora da área do modal
    $('.close, .modal').click(function(event) {
        if ($(event.target).hasClass('modal') || $(event.target).hasClass('close')) {
            $('.modal').css('display', 'none');
        }
    });

    // Enviar formulário de adicionar supervisor via AJAX
    $('#form-add-supervisor').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: 'add_supervisor.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.status === 'success') {
                    $('#modal-add-supervisor').css('display', 'none');
                    $('#feedback-message')
                        .show(); //html('Supervisor adicionado com sucesso!');
                    $('#modal-feedback').css('display', 'block');
                    setTimeout(function() {
                        $('#modal-feedback').css('display', 'none');
                        $('a[href="supervisores.php"]').click();
                        //location.reload(); // Recarregar a página após adicionar o supervisor
                    }, 3000); // Fechar modal de feedback após 30 segundos
                } else {
                    $('#modal-add-supervisor').css('display', 'none');
                    $('#feedback-message').html('Erro ao adicionar supervisor: ' + data
                        .message);
                    $('#modal-feedback').css('display',
                        'block'); // Fechar modal de feedback após 30 segundos
                }
            },
            error: function(xhr, status, error) {
                console.error('Erro:', error);
                alert(
                    'Erro ao adicionar supervisor. Verifique o console para mais detalhes.'
                );
            }
        });
    });
});
$(document).ready(function() {
    // Abrir Modal de Edição ao clicar no botão de editar e carregar dados via AJAX
    $('.btn-edit-supervisor').click(function() {
        var supervisorId = $(this).data('id');
        $.ajax({
            url: 'obter_supervisor.php',
            type: 'GET',
            data: {
                id: supervisorId
            },
            dataType: 'json',
            success: function(data) {
                if (data.status === 'success') {
                    $('#supervisor_id').val(data.supervisor.id);
                    $('#nome').val(data.supervisor.nome);
                    $('#contato').val(data.supervisor.contato);
                    $('#zona_id').val(data.supervisor.zona_id);
                    $('#pastor_zona_id').val(data.supervisor.pastor_zona_id);
                    $('#modal-edit-supervisor').css('display', 'block');
                } else {
                    alert('Erro ao carregar dados do supervisor.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Erro:', error);
                alert(
                    'Erro ao carregar dados do supervisor. Verifique o console para mais detalhes.'
                    );
            }
        });
    });

    // Fechar Modais ao clicar no botão de fechar ou fora da área do modal
    $('.close, .modal').click(function(event) {
        if ($(event.target).hasClass('modal') || $(event.target).hasClass('close')) {
            $('.modal').css('display', 'none');
        }
    });

    // Fechar Modal de Feedback ao clicar no botão de fechar ou fora da área do modal
    $('.close-feedback, .modal').click(function(event) {
        if ($(event.target).hasClass('modal') || $(event.target).hasClass('close-feedback')) {
            $('#modal-feedback').css('display', 'none');
        }
    });

    // Enviar formulário de edição de supervisor via AJAX
    $('#form-edit-supervisor').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: 'edit_supervisor.php?id=' + $('#supervisor_id').val(),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.status === 'success') {
                    $('#modal-edit-supervisor').css('display', 'none');
                    $('#feedback-message').html(
                        'Dados do supervisor atualizados com sucesso!');
                    $('#modal-feedback').css('display', 'block');
                    setTimeout(function() {
                        $('#modal-feedback').css('display', 'none');
                    }, 30000); // Fechar modal de feedback após 30 segundos
                } else {
                    $('#modal-edit-supervisor').css('display', 'none');
                    $('#feedback-message').html('Erro ao atualizar supervisor: ' + data
                        .message);
                    $('#modal-feedback').css('display', 'block');
                    setTimeout(function() {
                        $('#modal-feedback').css('display', 'none');
                    }, 30000); // Fechar modal de feedback após 30 segundos
                }
            },
            error: function(xhr, status, error) {
                console.error('Erro:', error);
                alert(
                    'Erro ao atualizar supervisor. Verifique o console para mais detalhes.'
                    );
            }
        });
    });
});
</script>