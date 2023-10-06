<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

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
                                    if (isset($c_man_prog_af_gpon['qtde']) && $stateIncident == 0 || isset($c_man_prog_af_backbone['qtde']) && $_POST['stateIncident'] == 0) {    ?>
                                        <span class="badge bg-danger text-white"><i class="bi bi-exclamation-triangle"></i></span>
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