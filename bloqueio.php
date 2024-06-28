<?php
require "conexoes/conexao_pdo.php";
$api_url = "https://gestao.gigafull.com.br/api/valida_licenca.php";

$stmt = $pdo->prepare("SELECT licenca FROM licenca WHERE id = 1");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $id_licenca = $result['licenca'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['licenca' => $id_licenca]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        throw new Exception('Erro na chamada da API: ' . curl_error($ch));
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['status']) && $data['status'] == 'success') {
        $licenca_valida = true;
    } else {
        $licenca_valida = false;
    }
} else {
    throw new Exception('Licença não encontrada no banco de dados.');
}

if ($licenca_valida) {
    header("Location: /index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Bloqueado - SmartControl</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
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
            <!-- Seção de bloqueio -->
            <section class="section error-404 d-flex flex-column align-items-center justify-content-center min-vh-100">
                <div class="text-center">
                    <h2>Servidor Indisponivel</h2>

                    <?php
                    if (is_array($data) && isset($data['message'])) {
                        echo "<p>" . "Erro: " . htmlspecialchars($data['message']) . "</p>";
                    } else {
                        echo "<p>Erro inesperado ao validar a licença. Por favor, tente novamente mais tarde.</p>";
                    }
                    ?>
                    <button data-bs-toggle="modal" data-bs-target="#carregarLicenca" type="button" class="btn btn-info btn-sm mt-4 mb-3">Carregar Nova Licença</button>
                    <br>
                    <img src="assets/img/not-found.svg" class="img-fluid" style="max-width: 400px;" alt="Bloqueio">
                    <div class="credits mt-3">
                        Desenvolvido por <a href="https://gigafull.com.br/">Gigafull Soluções Tecnológicas</a>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Modal para carregar nova licença -->
    <div class="modal fade" id="carregarLicenca" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Carregar Nova Licença</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="carregar_licenca.php" method="POST">
                    <div class="modal-body">
                        <div class="col-12">
                            <label for="nova_licenca" class="form-label">Nova Licença</label>
                            <textarea id="nova_licenca" name="nova_licenca" rows="5" style="resize: none;" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Carregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
</body>

</html>