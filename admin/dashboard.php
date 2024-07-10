<?php
//session_start();
include "../partials/conn.php";
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['perfil'] != 'admin') {
    $_SESSION['login_error'] = 'Acesso proibido: você precisa se autenticar.';
    header('Location: ../index.php');
    exit();
}

// Obter contagens totais
$totalLeaders = $conn->query("SELECT COUNT(*) AS count FROM lideres")->fetch_assoc()['count'];
$totalSupervisors = $conn->query("SELECT COUNT(*) AS count FROM supervisores")->fetch_assoc()['count'];
$totalCells = $conn->query("SELECT COUNT(*) AS count FROM celula")->fetch_assoc()['count'];
$totalMembers = $conn->query("SELECT COUNT(*) AS count FROM membros")->fetch_assoc()['count'];

// Obter dados de participação para o gráfico
$participationData = array();
$sql = "SELECT data_relatorio AS data, 
               (membros_presentes_criancas + membros_presentes_adultos + visitantes_presentes_criancas + visitantes_presentes_adultos) AS participacao 
        FROM relatorios_participacao 
        ORDER BY data_relatorio DESC LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $participationData[] = $row;
    }
}
?>
<div class="home-tab" style="margin-top:-30px;">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom" style="margin-bottom: 15px;">
        <h3 class="mb-0">Dashboard</h3>
    </div>
</div>

<div class="row mt-4">
    <!-- Gráficos de Resumo -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-user-tie"></i> Líderes, Supervisores, Células e Membros
            </div>
            <div class="card-body">
                <canvas id="summaryChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Gráfico de Participação -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <i class="fas fa-chart-line"></i> Participação nos Últimos 10 Cultos
            </div>
            <div class="card-body">
                <canvas id="participationChart"></canvas>
            </div>
        </div>
    </div>
</div>
    <!-- Calendário de Eventos e Cultos -->
    <!--<div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="far fa-calendar-alt"></i> Calendário de Eventos e Cultos
            </div>
            <div class="card-body">
                <ul class="event-list">
                    <li><i class="fas fa-calendar-day"></i> Evento 1 - Data: 01/07/2024</li>
                    <li><i class="fas fa-calendar-day"></i> Culto Especial - Data: 10/07/2024</li>
                </ul>
            </div>
        </div>
    </div>
</div>-->

<div class="row mt-4">
    <!-- Notícias e Informações -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <i class="fas fa-info-circle"></i> Notícias e Informações
            </div>
            <div class="card-body">
                <ul class="news-list">
                    <li><i class="fas fa-newspaper"></i> Notícia 1: Nova série de pregações iniciada.</li>
                    <li><i class="fas fa-newspaper"></i> Informação 1: Reunião de líderes agendada para 15/07/2024.</li>
                </ul>
            </div>
        </div>
    </div>
    <!--Relatórios de Células e Participação -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <i class="fas fa-chart-pie"></i> Relatório de Células
            </div>
            <div class="card-body">
                <p>Aqui você pode adicionar o relatório das células.</p>
                <button class="btn btn-outline-danger"><i class="fas fa-file-alt"></i> Ver Relatório de Células</button>
            </div>
        </div>
    </div>
    <!--<div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-chart-line"></i> Relatório de Participação do Último Culto
            </div>
            <div class="card-body">
                <p>Aqui você pode adicionar o relatório de participação do último culto.</p>
                <button class="btn btn-outline-primary"><i class="fas fa-file-alt"></i> Ver Relatório de Participação</button>
            </div>
        </div>
    </div>
</div> -->

<script src="../chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="../vendors/chart.js/Chart.min.js"></script>
<script>
// Função para inicializar os gráficos
function inicializar_graficos() {
    // Gráfico de Resumo
    const summaryCtx = document.getElementById('summaryChart').getContext('2d');
    const summaryChart = new Chart(summaryCtx, {
        type: 'pie',
        data: {
            labels: ['Líderes', 'Supervisores', 'Células', 'Membros'],
            datasets: [{
                data: [<?php echo $totalLeaders; ?>, <?php echo $totalSupervisors; ?>, <?php echo $totalCells; ?>, <?php echo $totalMembers; ?>],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(255, 99, 132, 0.8)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.raw;
                            return label;
                        }
                    }
                }
            }
        }
    });

    // Gráfico de Participação
    const participationCtx = document.getElementById('participationChart').getContext('2d');
    const participationChart = new Chart(participationCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($participationData, 'data')); ?>,
            datasets: [{
                label: 'Participação',
                data: <?php echo json_encode(array_column($participationData, 'participacao')); ?>,
                backgroundColor: 'rgba(255, 159, 75, 0.8)', // Cor de fundo do gráfico
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
};
inicializar_graficos();
