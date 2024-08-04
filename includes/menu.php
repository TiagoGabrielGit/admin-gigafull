<?php
session_start();
// Verifica se existe os dados da sessão de login
if (!isset($_SESSION["id"])) {
  // Salvar a URL da página atual para redirecionamento após o login
  $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

  // Redirecionar para a página de login
  header("Location: /login.php");
  exit();
}
$nome = $_SESSION['nome'];
$id = $_SESSION['id'];
$usuario_id = $id;
$perfil = $_SESSION['nome_perfil'];
$user_ip = $_SESSION['ip_address'];
$horario = date('d/m/Y H:i');

require_once($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao.php');

//$url_new_chamado = $_SERVER['DOCUMENT_ROOT'] . '/' . 'check_new_calls.php';
$url_new_chamado = "http://smartcontrol.dominio.com.br/check_new_calls.php";
$sql_pessoa =
  "SELECT p.id as id_pessoa, u.tipo_usuario as usuarioTipo
FROM usuarios as u
LEFT JOIN pessoas as p ON p.id = u.pessoa_id
WHERE u.id = '$id'";

$result_pessoa = mysqli_query($mysqli, $sql_pessoa);
$pessoa = mysqli_fetch_assoc($result_pessoa);
$pessoa_id = $pessoa['id_pessoa'];
$userType = $pessoa['usuarioTipo'];

$sql_chamado =
  "SELECT c.in_execution_atd_id as execucao, c.id as id_chamado
FROM chamados as c 
WHERE c.in_execution_atd_id = '$pessoa_id'";

$result_chamado = mysqli_query($mysqli, $sql_chamado);
$chamado = mysqli_fetch_assoc($result_chamado);

if (empty($chamado['execucao'])) {
  $chamado_exec = "";
} else {
  $chamado_exec = $chamado['execucao'];
}

$note = "";

$sql_bloco_de_notas = "SELECT note FROM bloco_de_notas WHERE user_id = ?";
$stmt = $mysqli->prepare($sql_bloco_de_notas);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $resp_note = $result->fetch_assoc();
  $note = $resp_note['note'];
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SmartControl</title>
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
  <link href="/assets/css/stylesheet.css" rel="stylesheet">

</head>



<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="/index.php" class="logo d-flex align-items-center">
        <img src="/assets/img/logo.png" alt="">
        <span class="d-none d-lg-block"><u> SmartControl </u></span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->
        <?php

        //require_once($_SERVER['DOCUMENT_ROOT'] . '/alert_new_Call/alert.php');

        if ($chamado_exec == $pessoa_id) {
          $id_chamado = $chamado['id_chamado'];
          $seconds_in_execution =
            "SELECT TIMESTAMPDIFF(SECOND, in_execution_start, NOW()) as tempo
          from chamados
          where id = $id_chamado;
          ";
          $seconds_execution = mysqli_query($mysqli, $seconds_in_execution);
          $res_seconds_execution = $seconds_execution->fetch_array();
          $sec_exec = $res_seconds_execution['tempo']; ?>

          <a href="/servicedesk/chamados/visualizar_chamado.php?id=<?= $id_chamado ?>">
            <button type="button" class="btn btn-success">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.79 5.093A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814l-3.5-2.5z"></path>
              </svg>
              Chamado em execução - <?= gmdate("H:i:s", $sec_exec) ?>
            </button>
          </a>
        <?php } else {
        } ?>

        <a class="nav-link nav-icon" href="#" data-bs-toggle="modal" data-bs-target="#modalAnotacoes">
          <i class="bi bi-stickies"></i>
        </a>

        <?php
        $total_notificacoes_query =
          "SELECT COUNT(*) AS total_notificacoes
          FROM smart_notification 
          WHERE status = 1 AND usuario_id = $usuario_id";

        $result_total_notificacoes = mysqli_query($mysqli, $total_notificacoes_query);

        if ($result_total_notificacoes) {
          $row = mysqli_fetch_assoc($result_total_notificacoes);
          $total_notificacoes = $row['total_notificacoes'];
        } else {
          $total_notificacoes = 0;
        }
        ?>

        <li class="nav-item dropdown">
          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <?php
            if ($total_notificacoes > 0) { ?>
              <span class="badge bg-warning badge-number"><?= $total_notificacoes ?></span>

            <?php  } else {  ?>
              <span class="badge bg-primary badge-number"><?= $total_notificacoes ?></span>
            <?php }
            ?>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              <?= '####### ' . 'Você tem ' . $total_notificacoes . ' notificações' . ' #######' ?>
              <a href="#"></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <?php
            $notificacoes_query =
              "SELECT
              CASE
              WHEN sn.mensagem_tipo = 3 THEN 'Novo relato adicionado'
              END as titulo,
              sn.mensagem as mensagem,
              DATE_FORMAT(sn.date, '%d/%m/%Y %H:%i') as date_formatted,
              sn.id as 'id'
            FROM smart_notification as sn
            WHERE sn.status = 1 AND sn.usuario_id = $usuario_id
            ORDER BY sn.id desc
            LIMIT 4";
            $result_notificacoes = mysqli_query($mysqli, $notificacoes_query);

            if (mysqli_num_rows($result_notificacoes) > 0) {
              while ($notificacao = mysqli_fetch_assoc($result_notificacoes)) { ?>
                <li class="notification-item">
                  <i class="bi bi-exclamation-circle text-warning"></i>
                  <div>
                    <h4><?= $notificacao['titulo']; ?></h4>
                    <p><?= $notificacao['mensagem']; ?></p>
                    <br>
                    <p><?= $notificacao['date_formatted']; ?></p>
                    <p>
                      <a href="/includes/processa/marcar_como_lido.php?id=<?= $notificacao['id'] ?>" class="btn btn-info rounded-pill" style="padding: 3px 10px; font-size: 10px;">Marcar como Lido</a>
                      <a href="/includes/processa/ir_para_chamado.php?id=<?= $notificacao['id'] ?>" class="btn btn-info rounded-pill" style="padding: 3px 10px; font-size: 10px;">Ir para Chamado</a>
                    </p>
                  </div>
                </li>

                <li>
                  <hr class="dropdown-divider">
                </li>

              <?php }
            } else { ?>
              <li class="notification-item">
                <div>
                  <p>Você não tem notificações</p>
                </div>
              </li>
            <?php }
            ?>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="/all_notification/index.php">Ver todas notificações</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="/assets/img/3135715.png" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $nome; ?></span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= $nome; ?></h6>
              <span><?= $perfil; ?></span> <br>
              <span><?= $user_ip; ?></span> <br>
              <span><?= $horario ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/gerenciamento/usuarios/profile.php?id=<?= $id ?>">
                <i class="bi bi-person"></i>
                <span>Meu perfil</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul>
        </li>

      </ul>
    </nav>
  </header>

  <div class="modal fade" id="modalAnotacoes" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Bloco de Notas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <textarea id="notaTextarea" class="form-control" rows="25" style="resize: none;"><?php echo htmlspecialchars($note); ?></textarea>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

  <script>
    $(document).ready(function() {
      function saveNote() {
        var noteContent = $('#notaTextarea').val();

        $.ajax({
          url: '/includes/processa/salvarnota.php', // URL do seu endpoint no servidor
          method: 'POST',
          data: {
            note: noteContent
          },
        });
      }

      $('#modalAnotacoes').on('hide.bs.modal', function() {
        saveNote();
      });
    });
  </script>

  <?php
  require "navbar_type_1.php";
  ?>