<?php
include "../partials/conn.php";

// Consulta para obter os dados combinados das tabelas cultos, entradas e relatorios_participacao
$sql = "SELECT cultos.*, SUM(entradas.valor) AS total_ofertas, 
               SUM(CASE WHEN entradas.tipo = 'Dízimo' THEN entradas.valor ELSE 0 END) AS total_dizimos,
               SUM(relatorios_participacao.membros_presentes_criancas + relatorios_participacao.membros_presentes_adultos) AS total_participantes,
               SUM(relatorios_participacao.visitantes_presentes_criancas + relatorios_participacao.visitantes_presentes_adultos) AS total_visitantes
        FROM cultos
        LEFT JOIN entradas ON cultos.id = entradas.culto_id
        LEFT JOIN relatorios_participacao ON cultos.id = relatorios_participacao.culto_id
        GROUP BY cultos.id";
$result = $conn->query($sql);
?>
<!-- cultos.php -->
<div class="home-tab">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom" style="margin-bottom:5px 5px">
        <h3 class="mb-0">Gerenciar Relatórios de Culto</h3>
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
                <?php 
            if($result && mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['data'] . '</td>';
                    echo '<td>' . $row['hora'] . '</td>';
                    echo '<td>' . $row['tema'] . '</td>';
                    echo '<td>' . $row['total_participantes'] . '</td>';
                    echo '<td>' . $row['total_visitantes'] . '</td>';
                    echo '<td>MT ' . number_format($row['total_ofertas'], 2, ',', '.') . '</td>';
                    echo '<td>MT ' . number_format($row['total_dizimos'], 2, ',', '.') . '</td>';
                    echo '<td>';
                    echo '<button class="btn btn-sm btn-warning btn-edit" data-id="' . $row['id'] . '">Editar</button>';
                    echo '<button class="btn btn-sm btn-danger btn-delete" data-id="' . $row['id'] . '">Excluir</button>';
                    echo '<button class="btn btn-sm btn-info btn-view" data-id="' . $row['id'] . '">Visualizar</button>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="8">Nenhum culto cadastrado.</td></tr>';
            }
        ?>
            </tbody>
        </table>
        <hr>
        <!-- Formulário para Adicionar Culto -->
        <div id="form-add-culto" style="display: none;">
            <h2>Adicionar Culto</h2>
            <form id="add-culto-form">
                <div class="form-group">
                    <label for="data">Data:</label>
                    <input type="date" class="form-control" id="data" name="data" required>
                </div>
                <div class="form-group">
                    <label for="pregador">Pregador:</label>
                    <input type="text" class="form-control" id="pregador" name="pregador" placeholder="Nome do Pregador"
                        required>
                </div>
                <div class="form-group">
                    <label for="numero">Hora:</label>
                    <input type="time" class="form-control" id="numero" name="numero" required>
                </div>
                <div class="form-group">
                    <label for="tema">Tema da Mensagem:</label>
                    <input type="text" class="form-control" id="tema" name="tema" placeholder="Tema da Mensagem"
                        required>
                </div>
                <div class="form-group">
                    <label for="participantes_adultos">Número de Participantes (Adultos):</label>
                    <input type="number" class="form-control" id="participantes_adultos" name="participantes_adultos"
                        required>
                </div>
                <div class="form-group">
                    <label for="participantes_criancas">Número de Participantes (Crianças):</label>
                    <input type="number" class="form-control" id="participantes_criancas" name="participantes_criancas"
                        required>
                </div>
                <div class="form-group">
                    <label for="visitantes_adultos">Número de Visitantes (Adultos):</label>
                    <input type="number" class="form-control" id="visitantes_adultos" name="visitantes_adultos"
                        required>
                </div>
                <div class="form-group">
                    <label for="visitantes_criancas">Número de Visitantes (Crianças):</label>
                    <input type="number" class="form-control" id="visitantes_criancas" name="visitantes_criancas"
                        required>
                </div>
                <div class="form-group">
                    <label for="ofertas">Total de Ofertas (MT):</label>
                    <input type="text" class="form-control" id="ofertas" name="ofertas" placeholder="MT" required>
                </div>
                <div class="form-group">
                    <label for="dizimos">Total de Dízimos (MT):</label>
                    <input type="text" class="form-control" id="dizimos" name="dizimos" placeholder="MT" required>
                </div>
                <div class="form-group">
                    <label for="observacoes">Observações Gerais:</label>
                    <textarea class="form-control" id="observacoes" name="observacoes" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-danger" id="fechar-culto">Cancelar</button>
            </form>
        </div>
    </div>
</div>
<!-- Modal para Editar Culto -->
<div class="modal fade" id="editCultoModal" tabindex="-1" role="dialog" aria-labelledby="editCultoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCultoModalLabel">Editar Culto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editCultoForm">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="form-group">
                        <label for="edit-data">Data</label>
                        <input type="date" id="edit-data" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-pregador">Pregador</label>
                        <input type="text" id="edit-pregador" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-numero">Hora</label>
                        <input type="time" id="edit-numero" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-tema">Tema</label>
                        <input type="text" id="edit-tema" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-participantes_adultos">Participantes Adultos</label>
                        <input type="number" id="edit-participantes_adultos" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-participantes_criancas">Participantes Crianças</label>
                        <input type="number" id="edit-participantes_criancas" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-visitantes_adultos">Visitantes Adultos</label>
                        <input type="number" id="edit-visitantes_adultos" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-visitantes_criancas">Visitantes Crianças</label>
                        <input type="number" id="edit-visitantes_criancas" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-ofertas">Ofertas</label>
                        <input type="number" id="edit-ofertas" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-dizimos">Dízimos</label>
                        <input type="number" id="edit-dizimos" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-observacoes">Observações</label>
                        <textarea id="edit-observacoes" class="form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#editCultoModal').modal('hide');"">Fechar</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Visualizar e Editar Culto -->
<div class="modal fade" id="viewCultoModal" tabindex="-1" role="dialog" aria-labelledby="viewCultoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCultoModalLabel">Detalhes do Culto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="culto-details">
                <!-- Os detalhes do culto serão carregados aqui -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="printCulto">Imprimir</button>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('btn-add-culto').addEventListener('click', function() {
    document.getElementById('form-add-culto').style.display = 'block';
});

document.getElementById('fechar-culto').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('form-add-culto').style.display = 'none';
});

document.getElementById('add-culto-form').addEventListener('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    fetch('cadastrar_culto.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Culto adicionado com sucesso!');
                document.getElementById('form-add-culto').style.display = 'none';
                document.querySelector('a[href="cultos.php"]').click(); // Simula o clique no menu "Cultos"
            } else {
                alert('Erro ao adicionar culto: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao adicionar culto. Verifique o console para mais detalhes.');
        });
});

// Função para excluir culto
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function() {
        if (confirm('Tem certeza que deseja excluir este culto?')) {
            var cultoId = this.getAttribute('data-id');
            var formData = new FormData();
            formData.append('action', 'delete');
            formData.append('culto_id', cultoId);

            fetch('cadastrar_culto.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Culto excluído com sucesso!');
                        document.querySelector('a[href="cultos.php"]')
                    .click(); // Simula o clique no menu "Cultos"
                    } else {
                        alert('Erro ao excluir culto: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao excluir culto. Verifique o console para mais detalhes.');
                });
        }
    });
});
// Função para editar o Culto
document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', function() {
        var cultoId = this.getAttribute('data-id');
        console.log('Culto ID:', cultoId);

        if (cultoId) {
            fetch('visualizar_c.php?id=' + cultoId)
            .then(response => response.json())
            .then(data => {
                console.log('Dados recebidos:', data);
                if (data.error) {
                    alert(data.error);
                } else {
                    document.getElementById('edit-id').value = data.id;
                    document.getElementById('edit-data').value = data.data;
                    document.getElementById('edit-pregador').value = data.pregador;
                    document.getElementById('edit-numero').value = data.hora;
                    document.getElementById('edit-tema').value = data.tema;
                    document.getElementById('edit-participantes_adultos').value = data.participantes_adultos;
                    document.getElementById('edit-participantes_criancas').value = data.participantes_criancas;
                    document.getElementById('edit-visitantes_adultos').value = data.visitantes_adultos;
                    document.getElementById('edit-visitantes_criancas').value = data.visitantes_criancas;
                    document.getElementById('edit-ofertas').value = data.ofertas;
                    document.getElementById('edit-dizimos').value = data.dizimos;
                    document.getElementById('edit-observacoes').value = data.observacoes;
                    $('#editCultoModal').modal('show');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao carregar detalhes do culto. Verifique o console para mais detalhes.');
            });
        } else {
            console.error('ID do culto não está definido!');
            alert('Erro ao obter o ID do culto. Verifique o console para mais detalhes.');
        }
    });
});

// Função para salvar culto
document.getElementById('saveChanges').addEventListener('click', function() {
    // Capture os dados do formulário
    var cultoId = document.getElementById('edit-id').value;
    var data = document.getElementById('edit-data').value;
    var pregador = document.getElementById('edit-pregador').value;
    var hora = document.getElementById('edit-numero').value;
    var tema = document.getElementById('edit-tema').value;
    var participantes_adultos = document.getElementById('edit-participantes_adultos').value;
    var participantes_criancas = document.getElementById('edit-participantes_criancas').value;
    var visitantes_adultos = document.getElementById('edit-visitantes_adultos').value;
    var visitantes_criancas = document.getElementById('edit-visitantes_criancas').value;
    var ofertas = document.getElementById('edit-ofertas').value;
    var dizimos = document.getElementById('edit-dizimos').value;
    var observacoes = document.getElementById('edit-observacoes').value;

    console.log({
        id: cultoId,
        data: data,
        pregador: pregador,
        hora: hora,
        tema: tema,
        participantes_adultos: participantes_adultos,
        participantes_criancas: participantes_criancas,
        visitantes_adultos: visitantes_adultos,
        visitantes_criancas: visitantes_criancas,
        ofertas: ofertas,
        dizimos: dizimos,
        observacoes: observacoes
    });

    // Envie os dados para o backend
    fetch('editar_culto.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: cultoId,
            data: data,
            pregador: pregador,
            hora: hora,
            tema: tema,
            participantes_adultos: participantes_adultos,
            participantes_criancas: participantes_criancas,
            visitantes_adultos: visitantes_adultos,
            visitantes_criancas: visitantes_criancas,
            ofertas: ofertas,
            dizimos: dizimos,
            observacoes: observacoes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Culto atualizado com sucesso!');
            // Fechar o modal
            $('#editCultoModal').modal('hide');
            // Atualizar a tabela, se necessário
            document.querySelector('a[href="cultos.php"]')
            //location.reload();
        } else {
            alert('Erro ao atualizar culto: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao atualizar culto. Verifique o console para mais detalhes.');
    });
});
// Função para imprimir o relatório do culto
document.getElementById('printCulto').addEventListener('click', function() {
    var printContent = document.getElementById('culto-details').innerHTML;
    var originalContent = document.body.innerHTML;

    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;

    window.location.reload(); // Recarrega a página após a impressão
});
document.querySelectorAll('.btn-view').forEach(button => {
    button.addEventListener('click', function() {
        var cultoId = this.getAttribute('data-id');

        fetch('visualizar_culto.php?id=' + cultoId)
            .then(response => response.text())
            .then(data => {
                document.getElementById('culto-details').innerHTML = data;
                $('#viewCultoModal').modal('show');
            })
            .catch(error => {
                console.error('Erro:', error);
                alert(
                'Erro ao carregar detalhes do culto. Verifique o console para mais detalhes.');
            });
    });
});
</script>