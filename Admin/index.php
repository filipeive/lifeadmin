<?php
session_start();
include '../partials/conn.php';

if (!isset($_SESSION['user_id']) || $_SESSION['perfil'] != 'admin') {
    $_SESSION['login_error'] = 'Acesso proibido: você precisa se autenticar.';
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM usuarios WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$nome_usuario = $user['nome'];
$email_usuario = $user['email'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Life Church Admin 0.1</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/feather/feather.css">
    <link rel="stylesheet" href="../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/typicons/typicons.css">
    <link rel="stylesheet" href="../vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../images/favicon.png" />
</head>

<body>
    <div class="container-scroller" style="margin-top:-50px">
        <?php include '../partials/navbar.php'; ?>

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <?php include '../partials/sidebar.php'; ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row mt-4">
                        <div class="col-12" id="main-content">
                            <!-- Conteúdo dinâmico será carregado aqui -->
                            <h3>Bem-vindo, <?php echo $_SESSION['perfil'] == 'admin' ? 'Admin' : 'Usuário'; ?>!</h3>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <?php include '../partials/footer.php'; ?>
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../vendors/chart.js/Chart.min.js"></script>
    <script src="../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="../vendors/progressbar.js/progressbar.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../js/off-canvas.js"></script>
    <script src="../js/hoverable-collapse.js"></script>
    <script src="../js/template.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="../js/dashboard.js"></script>
    <script src="../js/Chart.roundedBarCharts.js"></script>
    <!-- End custom js for this page-->

    <script>
    // Inicialize o gráfico quando a página carregar
    $(document).ready(function() {
        // Função para carregar conteúdo dinamicamente
        function loadContent(page) {
            $("#main-content").load(page);
        }

        // Carregar o conteúdo inicial
        loadContent('dashboard.php');

        // Adicionar evento de clique para os links do menu
        $("#sidebar .nav-link").on('click', function(e) {
            e.preventDefault();
            var page = $(this).attr('href');
            loadContent(page);
        });
    });
    $(document).ready(function() {
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        $(".list-group-item").click(function(e) {
            e.preventDefault();
            var page = $(this).data("page");
            loadPage(page);
        });

        // Load initial content
        loadPage('dashboard',initializeChart);

        function loadPage(page) {
            fetchContent(page);
        }

        function fetchContent(page) {
            fetch('../admin/load_content.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'page=' + page,
                })
                .then(response => response.text())
                .then(data => {
                    $("#main-content").html(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    });
    </script>
</body>

</html>