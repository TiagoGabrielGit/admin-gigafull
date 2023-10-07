<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="refresh" content="60"> <!-- Atualiza a página a cada 40 segundos -->

    <title>SmartControl</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="../../../assets/img/favicon.png" rel="icon">
    <link href="../../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="../../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../../../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../../../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../../../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../../../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <link href="../../../assets/css/style.css" rel="stylesheet">
    <link href="../../../assets/css/stylesheet.css" rel="stylesheet">
</head>

<body>

    <style>
        .section {
            margin: 20px;
            /* Defina a quantidade de espaço desejada (20px no exemplo) */
        }
    </style>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <div class="row">
                            <div class="col-lg-9">
                                <form method="POST" action="#">
                                    <div class="row">
                                        <div class="col-4">
                                            <label class="form-label" for="stateIncident">Status Incidente</label>
                                            <select id="stateIncident" name="stateIncident" class="form-select">
                                                <option value="1" <?php if (isset($_POST['stateIncident']) && $_POST['stateIncident'] == '1') echo 'selected'; ?>>Normalizado</option>
                                                <option value="0" <?php if (!isset($_POST['stateIncident']) || (isset($_POST['stateIncident']) && $_POST['stateIncident'] == '0')) echo 'selected'; ?>>Alarmando</option>
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-center">
                                                <button style="margin-top: 40px;" class="btn btn-sm btn-danger" type="submit">Filtrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-3">
                                <div class="text-end">
                                    <span>Intervalo Atualização: 60s</span>
                                </div>
                            </div>
                        </div>

                        <?php
                        if (isset($_POST['stateIncident'])) {
                            $stateIncident = $_POST['stateIncident'];
                        } else {
                            $stateIncident = "0";
                        }

                        ?>

                        <br><br>
                        <!-- Bordered Tabs Justified -->
                        <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                            <li class="nav-item flex-fill" role="presentation">

                                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-home" type="button" role="tab" aria-controls="home" aria-selected="true">
                                    <?php
                                    if ($c_inc_gpon['qtde'] > 0 && $stateIncident == 0) {    ?>
                                        <span class="badge bg-danger text-white"><?= $c_inc_gpon['qtde'] ?></span>
                                    <?php } ?>
                                    Incidentes GPON</button>
                            </li>

                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
                                    <?php
                                    if ($c_inc_backb['qtde'] > 0 && $stateIncident == 0) {    ?>
                                        <span class="badge bg-danger text-white"><?= $c_inc_backb['qtde'] ?></span>
                                    <?php } ?>

                                    Incidentes Backbone</button>
                            </li>

                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">

                                    <?php
                                    if ($total_mp > 0) {    ?>
                                        <span class="badge bg-danger text-white"><?= $total_mp ?></span>
                                    <?php } ?>


                                    Manutenções Programadas</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                            <div class="tab-pane fade show active" id="bordered-justified-home" role="tabpanel" aria-labelledby="home-tab">
                                <?php
                                if ($stateIncident == 0) {
                                    require "../tabs/aberto_gpon.php";
                                } else {
                                    require "../tabs/normalizado_gpon.php";
                                } ?>
                            </div>
                            <div class="tab-pane fade" id="bordered-justified-contact" role="tabpanel" aria-labelledby="contact-tab">
                                <?php
                                if ($stateIncident == 0) {
                                    require "../tabs/aberto_backbone.php";
                                } else {
                                    require "../tabs/normalizado_backbone.php";
                                } ?>

                            </div>
                            <div class="tab-pane fade" id="bordered-justified-profile" role="tabpanel" aria-labelledby="profile-tab">

                                <?php
                                if ($stateIncident == 0) {
                                    require "../tabs/aberto_man_programada.php";
                                } ?>

                            </div>

                        </div><!-- End Bordered Tabs Justified -->

                    </div>
                </div>
            </div>
        </div>
    </section>


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../../../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../../../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../../../assets/vendor/quill/quill.min.js"></script>
    <script src="../../../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../../../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../../../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../../../assets/js/main.js"></script>
    <script src="../../../assets/js/multiselect-dropdown.js"></script>

</body>

</html>

<script>
    // Função para alternar as abas
    function alternarAbas() {
        let abas = document.querySelectorAll('.nav-link[data-bs-toggle="tab"]'); // Seleciona todas as abas
        let abaAtiva = document.querySelector('.nav-link.active[data-bs-toggle="tab"]'); // Pega a aba ativa

        let idAbaAtiva = abaAtiva.getAttribute('href'); // Pega o ID da aba ativa
        let indexAbaAtiva = Array.from(abas).indexOf(abaAtiva); // Pega o índice da aba ativa

        // Calcula o próximo índice da aba a ser ativada
        let proximoIndex = (indexAbaAtiva + 1) % abas.length;

        let proximaAba = abas[proximoIndex];
        let idProximaAba = proximaAba.getAttribute('href');

        // Remove a classe "active" da aba atual
        abaAtiva.classList.remove('active');
        // Adiciona a classe "active" à próxima aba
        proximaAba.classList.add('active');

        // Remove a classe "show" da aba atual
        document.querySelector(idAbaAtiva).classList.remove('show', 'active');
        // Adiciona a classe "show" à próxima aba
        document.querySelector(idProximaAba).classList.add('show', 'active');

        // Carrega o conteúdo da próxima aba
        carregarConteudo(idProximaAba);
    }

    // Função para carregar o conteúdo da aba
    function carregarConteudo(idAba) {
        let conteudo = document.querySelector(idAba);
        if (conteudo) {
            // Coloque aqui a lógica para carregar o conteúdo da aba se necessário
        }
    }

    // Chama a função para alternar as abas a cada 20 segundos
    setInterval(alternarAbas, 20000); // 20000 milissegundos = 20 segundos
</script>
