<?php
$token = $_GET['token'];

try {
    require "conexoes/conexao_pdo.php";

    // Prepara a consulta
    $stmt = $pdo->prepare("SELECT
        ui.validade_invite as 'validade',
        ui.active as 'active'
        FROM
        usuario_invite as ui
        WHERE
        ui.token = :token");

    // Executa a consulta
    $stmt->execute(['token' => $token]);

    // Obtém os resultados
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se encontrou algum resultado
    if ($result) {
        $validade = $result['validade'];
        $active = $result['active'];

        if ((strtotime($validade) > time()) && $active == 1) { ?>

            <!DOCTYPE html>
            <html lang="PT-BR">

            <head>
                <meta charset="utf-8">
                <meta content="width=device-width, initial-scale=1.0" name="viewport">

                <title>Criar Conta - SmartControl</title>
                <meta content="" name="description">
                <meta content="" name="keywords">

                <!-- Favicons -->
                <link href="assets/img/favicon.png" rel="icon">
                <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

                <!-- Google Fonts -->
                <link href="https://fonts.gstatic.com" rel="preconnect">
                <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

                <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
                <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
                <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
                <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
                <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
                <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
                <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

                <link href="assets/css/style.css" rel="stylesheet">
            </head>

            <body>
                <main>
                    <div class="container">
                        <section class="section">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="flex-column align-items-center justify-content-center">

                                        <div class="d-flex justify-content-center py-4">
                                            <a href="index.php" class="logo d-flex align-items-center w-auto">
                                                <img src="assets/img/logo.png" alt="">
                                                <span class="d-none d-lg-block">SmartControl</span>
                                            </a>
                                        </div><!-- End Logo -->

                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title pb-0 fs-4">Cadastro de usuário</h5>

                                                <form method="POST" action="invite_processa.php">
                                                    <input readonly hidden id="token" name="token" value="<?= $token ?>"></input>

                                                    <div class="row">
                                                        <div class="col-5">
                                                            <label for="nomePessoa" class="form-label">Nome</label>
                                                            <input name="nomePessoa" type="text" class="form-control" id="nomePessoa" required>
                                                        </div>

                                                        <div class="col-3">
                                                            <label for="cpf" class="form-label">CPF</label>
                                                            <input name="cpf" type="text" class="form-control" id="cpf" required>
                                                        </div>

                                                        <div class="col-4">
                                                            <label for="email" class="form-label">E-mail</label>
                                                            <input name="email" type="email" class="form-control" id="email" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <label for="telefone" class="form-label">Telefone</label>
                                                            <input name="telefone" type="text" class="form-control" id="telefone">
                                                        </div>

                                                        <div class="col-4">
                                                            <label for="celular" class="form-label">Celular</label>
                                                            <input name="celular" type="text" class="form-control" id="celular" required>
                                                        </div>
                                                    </div>

                                                    <hr class="sidebar-divider">

                                                    <div class="row">
                                                        <div class="col-4">
                                                            <label for="cep" class="form-label">CEP</label>
                                                            <input name="cep" type="text" class="form-control" id="cep" onblur="buscarEnderecoPorCep()" required>
                                                        </div>

                                                        <div class="col-4">
                                                            <label for="ibgecode" class="form-label">Código IBGE</label>
                                                            <input name="ibgecode" type="text" class="form-control" id="ibgecode" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <label for="inputLogradouro" class="form-label">Logradouro</label>
                                                            <input name="logradouro" type="text" class="form-control" id="logradouro" readonly required>
                                                        </div>

                                                        <div class="col-3">
                                                            <label for="inputBairro" class="form-label">Bairro</label>
                                                            <input name="bairro" type="text" class="form-control" id="bairro" required readonly>
                                                        </div>

                                                        <div class="col-3">
                                                            <label for="inputCidade" class="form-label">Cidade</label>
                                                            <input name="cidade" type="text" class="form-control" id="cidade" required readonly>
                                                        </div>

                                                        <div class="col-2">
                                                            <label for="inputEstado" class="form-label">Estado</label>
                                                            <input name="estado" type="text" class="form-control" id="estado" required readonly>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="numero" class="form-label">Número</label>
                                                            <input name="numero" type="number" class="form-control" id="numero" required>
                                                        </div>

                                                        <div class="col-3">
                                                            <label for="complemento" class="form-label">Complemento</label>
                                                            <input name="complemento" type="text" class="form-control" id="complemento">
                                                        </div>
                                                    </div>

                                                    <hr class="sidebar-divider">

                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-danger">Cadastrar</button>
                                                    </div>
                                                </form><!-- Vertical Form -->
                                            </div>
                                        </div>

                                        <div class="credits">
                                            Desenvolvido por <a href="https://www.gigafull.com.br/">Gigafull Soluções Tecnológicas</a>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </section>

                    </div>
                </main><!-- End #main -->

                <?php
                require "invite_js.php";
                ?>
                <!-- Vendor JS Files -->
                <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
                <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                <script src="assets/vendor/chart.js/chart.min.js"></script>
                <script src="assets/vendor/echarts/echarts.min.js"></script>
                <script src="assets/vendor/quill/quill.min.js"></script>
                <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
                <script src="assets/vendor/tinymce/tinymce.min.js"></script>
                <script src="assets/vendor/php-email-form/validate.js"></script>

                <!-- Template Main JS File -->
                <script src="assets/js/main.js"></script>

            </body>

            </html>

        <?php } else { ?>
            <!DOCTYPE html>
            <html lang="PT-BR">

            <head>
                <meta charset="utf-8">
                <meta content="width=device-width, initial-scale=1.0" name="viewport">

                <title>Criar Conta - SmartControl</title>
                <meta content="" name="description">
                <meta content="" name="keywords">

                <!-- Favicons -->
                <link href="assets/img/favicon.png" rel="icon">
                <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

                <!-- Google Fonts -->
                <link href="https://fonts.gstatic.com" rel="preconnect">
                <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

                <!-- Vendor CSS Files -->
                <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
                <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
                <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
                <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
                <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
                <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
                <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

                <!-- Template Main CSS File -->
                <link href="assets/css/style.css" rel="stylesheet">
            </head>

            <body>

                <main>
                    <div class="container">

                        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                                        <div class="d-flex justify-content-center py-4">
                                            <a href="index.php" class="logo d-flex align-items-center w-auto">
                                                <img src="assets/img/logo.png" alt="">
                                                <span class="d-none d-lg-block">SmartControl</span>
                                            </a>
                                        </div><!-- End Logo -->

                                        <?php
                                        if ($active == 0) { ?>
                                            <h5 class="card-title text-center">Este token foi inativado</h5>
                                        <?php } else { ?>
                                            <h5 class="card-title text-center">Este token expirou em <?= $validade ?></h5>
                                        <?php }
                                        ?>


                                        <div class="credits">
                                            Desenvolvido por <a href="https://www.gigafull.com.br/">Gigafull Soluções Tecnológicas</a>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </section>

                    </div>
                </main><!-- End #main -->

                <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


                <!-- Vendor JS Files -->
                <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
                <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                <script src="assets/vendor/chart.js/chart.min.js"></script>
                <script src="assets/vendor/echarts/echarts.min.js"></script>
                <script src="assets/vendor/quill/quill.min.js"></script>
                <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
                <script src="assets/vendor/tinymce/tinymce.min.js"></script>
                <script src="assets/vendor/php-email-form/validate.js"></script>

                <!-- Template Main JS File -->
                <script src="assets/js/main.js"></script>

            </body>

            </html>
        <?php }
    } else { ?>
        <!DOCTYPE html>
        <html lang="PT-BR">

        <head>
            <meta charset="utf-8">
            <meta content="width=device-width, initial-scale=1.0" name="viewport">

            <title>Criar Conta - SmartControl</title>
            <meta content="" name="description">
            <meta content="" name="keywords">

            <!-- Favicons -->
            <link href="assets/img/favicon.png" rel="icon">
            <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

            <!-- Google Fonts -->
            <link href="https://fonts.gstatic.com" rel="preconnect">
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

            <!-- Vendor CSS Files -->
            <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
            <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
            <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
            <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
            <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
            <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

            <!-- Template Main CSS File -->
            <link href="assets/css/style.css" rel="stylesheet">
        </head>

        <body>

            <main>
                <div class="container">

                    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                                    <div class="d-flex justify-content-center py-4">
                                        <a href="index.php" class="logo d-flex align-items-center w-auto">
                                            <img src="assets/img/logo.png" alt="">
                                            <span class="d-none d-lg-block">SmartControl</span>
                                        </a>
                                    </div><!-- End Logo -->
                                    <h5 class="card-title text-center">Token inválido ou não encontrado</h5>

                                    <div class="credits">
                                        <!-- All the links in the footer should remain intact. -->
                                        <!-- You can delete the links only if you purchased the pro version. -->
                                        <!-- Licensing information: https://bootstrapmade.com/license/ -->
                                        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                                        Desenvolvido por <a href="https://www.gigafull.com.br/">Gigafull Soluções Tecnológicas</a>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </section>

                </div>
            </main><!-- End #main -->

            <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


            <!-- Vendor JS Files -->
            <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
            <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="assets/vendor/chart.js/chart.min.js"></script>
            <script src="assets/vendor/echarts/echarts.min.js"></script>
            <script src="assets/vendor/quill/quill.min.js"></script>
            <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
            <script src="assets/vendor/tinymce/tinymce.min.js"></script>
            <script src="assets/vendor/php-email-form/validate.js"></script>

            <!-- Template Main JS File -->
            <script src="assets/js/main.js"></script>

        </body>

        </html>
<?php }
} catch (PDOException $e) {
    // Em caso de erro na conexão ou consulta
    echo "Erro: " . $e->getMessage();
}
?>