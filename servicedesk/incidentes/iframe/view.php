<?php
$token = $_GET['token'];
$ip = $_SERVER['REMOTE_ADDR'];
$permissaoGerenciar = "0";
require "../../../conexoes/conexao_pdo.php"; // Certifique-se de que esta linha está correta
require "../../../conexoes/conexao.php"; // Certifique-se de que esta linha está correta

try {
    $query_frame = "SELECT ii.id as id_iframe, it.codigo, ii.empresa_id as empresa_id, e.atributoEmpresaPropria as empresaPropria, ii.protocoloERP as protocoloERP
                    FROM incidentes_iframe as ii
                    LEFT JOIN incidentes_types as it ON it.id = ii.tipo_incidente_id
                    LEFT JOIN empresas as e ON e.id = ii.empresa_id
                    WHERE ii.active = 1 and ii.token = :token";

    $stmt = $pdo->prepare($query_frame);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        $empresa_id = $result[0]['empresa_id'];
        $empresaPropria = $result[0]['empresaPropria'];
        $id_iframe = $result[0]['id_iframe'];
        $empresaID = $empresa_id;
        $tipo_incidente_codigo = $result[0]['codigo'];
        $protocoloERP = $result[0]['protocoloERP'];


        $all_open =
            "SELECT count(*) as qtde
        FROM incidentes_iframe_ip_address as iiip
        WHERE iiip.incidentes_iframe_id = :id_iframe and ip = '0.0.0.0'
        ";

        $stmt_all_open = $pdo->prepare($all_open);
        $stmt_all_open->bindParam(':id_iframe', $id_iframe, PDO::PARAM_INT);
        $stmt_all_open->execute();
        $result_all_open = $stmt_all_open->fetchAll(PDO::FETCH_ASSOC);

        $query_ip = "SELECT count(*) as qtde
                     FROM incidentes_iframe_ip_address AS iiip
                     WHERE iiip.incidentes_iframe_id = :id_iframe and iiip.ip = :ip";

        $stmt_ip = $pdo->prepare($query_ip);
        $stmt_ip->bindParam(':id_iframe', $id_iframe, PDO::PARAM_INT);
        $stmt_ip->bindParam(':ip', $ip, PDO::PARAM_STR);
        $stmt_ip->execute();
        $result_ip = $stmt_ip->fetchAll(PDO::FETCH_ASSOC);

        if ($result_ip[0]['qtde'] > 0 || $result_all_open[0]['qtde'] > 0) { ?>

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
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9">
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="text-end">
                                                <span>Intervalo Atualização: 60s</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="sidebar-divider">
                        <?php
                            if ($tipo_incidente_codigo == 100) {
                            require "view_gpon.php";
                            } else if ($tipo_incidente_codigo == 102) {
                                require "view_backbone.php";
                            } else {
                                require "view_outros.php";
                            }
                        ?>
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


<?php } else {
            echo "IP: $ip - Não autorizado.";
        }
    } else {
        echo "Token não encontrado!";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
