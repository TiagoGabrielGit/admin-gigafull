<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Login - SmartControl</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
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
      <?php
      require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

      function isServerReachable($url)
      {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout de 10 segundos
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Retorna um array com o código HTTP e a mensagem de erro, se houver
        return array('code' => $http_code, 'error' => $error);
      }

      $api_url = "https://gestao.gigafull.com.br/api/valida_licenca.php";
      $server_status = isServerReachable($api_url);
      $server_reachable = ($server_status['code'] >= 200 && $server_status['code'] < 300);

      if ($server_reachable) {
        try {
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
        } catch (Exception $e) {
          $licenca_valida = false;
          $server_status['error'] = $e->getMessage();
        }
      } else {
        $licenca_valida = false;
      }

      if ($licenca_valida || !$server_reachable) {
      ?>
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                <div class="d-flex justify-content-center py-4">
                  <a href="index.php" class="logo d-flex align-items-center w-auto">
                    <img src="assets/img/logo.png" alt="">
                    <span class="d-none d-lg-block">SmartControl</span>
                  </a>
                </div>
                <div class="card mb-3">
                  <div class="card-body">
                    <div class="pt-4 pb-2">
                      <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                      <p class="text-center small">
                        <?php
                        if ($server_reachable) {
                          echo "Digite seu usuário e senha para entrar";
                        } else {
                          echo "Servidor de validação indisponível.";
                          echo "<br>Erro: " . htmlspecialchars($server_status['error']);
                          echo "<br>Digite seu usuário e senha para entrar";
                        }
                        ?>
                      </p>
                    </div>
                    <form id="formLogin" method="POST" class="row g-3">
                      <div class="col-12">
                        <label for="yourUsername" class="form-label">Usuário</label>
                        <div class="input-group has-validation">
                          <span class="input-group-text" id="inputGroupPrepend">@</span>
                          <input type="text" name="email" class="form-control" id="yourUsername" required>
                          <div class="invalid-feedback">Digite seu usuário.</div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label for="yourPassword" class="form-label">Senha</label>
                        <input type="password" name="senha" class="form-control" id="yourPassword" required>
                        <div class="invalid-feedback">Digite sua senha.</div>
                      </div>
                      <div class="text-center">
                        <div id="carregandoLogin" class="spinner-border text-success" role="status" hidden>
                          <span class="visually-hidden">Loading...</span>
                        </div>
                        <span id="msgLogin" style="text-align: center;"></span>
                      </div>
                      <div class="text-center">
                        <input id="btnLogin" name="btnLogin" type="button" value="Login" class="btn btn-danger w-50"></input>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="credits">
                  Desenvolvido por <a href="https://gigafull.com.br/">Gigafull Soluções Tecnológicas</a>
                </div>
              </div>
            </div>
          </div>
        </section>
      <?php } else {
        header("Location: /bloqueio.php");
        exit();
      } ?>
    </div>
  </main>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <?php require "login_js.php"; ?>
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
