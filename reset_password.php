<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica se o campo "dadosLogin" existe na requisição POST
    if (isset($_POST["dadosLogin"])) {
        // Recupera os dados do formulário
        $dadosLogin = $_POST["dadosLogin"];

        // Decodifica os dados do formulário, se necessário
        $dadosLogin = urldecode($dadosLogin);

        // Separa os dados em um array associativo
        parse_str($dadosLogin, $dados);

        // A partir daqui, você pode acessar os dados do formulário
        $email = $dados["email"];

        // Agora você pode realizar a lógica de redefinição de senha ou qualquer outra operação necessária
        // ...
    }
}
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Reset Password</title>
    <meta name="robots" content="noindex, nofollow">
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="/assets/img/favicon.png" rel="icon">
    <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
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
                                    <img src="/assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">SmartControl</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Redefinir a Senha</h5>
                                        <p class="text-center small">Redefinia sua senha de acesso, ou caso seja seu primeiro acesos, defina sua senha.</p>
                                    </div>

                                    <form id="formResetPassword" action="POST" class="row g-3">

                                        <input id="email" name="email" type="text" readonly hidden value="<?= $email ?>"></input>
                                        

                                        <div class="col-12">
                                            <label for="confirmEmail" class="form-label">Confirme seu e-mail</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" name="confirmEmail" class="form-control" id="confirmEmail">
                                                <div class="invalid-feedback">Please choose a username.</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="senha" class="form-label">Senha</label>
                                            <input type="password" name="senha" class="form-control" id="senha">
                                            <div class="invalid-feedback">Please enter your password!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="confirmPassword" class="form-label">Confirme a senha</label>
                                            <input type="password" name="confirmPassword" class="form-control" id="confirmPassword">
                                            <div class="invalid-feedback">Please enter your password!</div>
                                        </div>

                                        <div class="col-12">
                                            <span id="msgReset"></span>
                                            <input id="btnReset" name="btnReset" type="button" value="Resetar Senha" class="btn btn-danger w-100"></input>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="credits">
                                <!-- All the links in the footer should remain intact. -->
                                <!-- You can delete the links only if you purchased the pro version. -->
                                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                                Desenvolvido por <a href="https://gigafull.com.br/">Gigafull Soluções Tecnológicas</a>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="/assets/vendor/echarts/echarts.min.js"></script>
    <script src="/assets/vendor/quill/quill.min.js"></script>
    <script src="/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="/assets/js/main.js"></script>

    <script async="" src="https://www.googletagmanager.com/gtag/js?id=G-P7JSYB1CSP"></script>
    <script>
        if (window.self == window.top) {
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'G-P7JSYB1CSP');
        }
    </script>
    <script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/v52afc6f149f6479b8c77fa569edb01181681764108816" integrity="sha512-jGCTpDpBAYDGNYR5ztKt4BQPGef1P0giN6ZGVUi835kFF88FOmmn8jBQWNgrNd8g/Yu421NdgWhwQoaOPFflDw==" data-cf-beacon="{&quot;rayId&quot;:&quot;7cb8ddbd8c3da4d8&quot;,&quot;token&quot;:&quot;68c5ca450bae485a842ff76066d69420&quot;,&quot;version&quot;:&quot;2023.4.0&quot;,&quot;si&quot;:100}" crossorigin="anonymous"></script>


    <svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
        <defs id="SvgjsDefs1002"></defs>
        <polyline id="SvgjsPolyline1003" points="0,0"></polyline>
        <path id="SvgjsPath1004" d="M0 0 "></path>
    </svg>
</body>

<?php
require "reset_password_js.php";
?>

</html>