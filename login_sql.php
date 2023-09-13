<?php
require "conexoes/conexao.php";
require "conexoes/conexao_pdo.php";

if (empty($_POST['email']) || empty($_POST['senha'])) {
  echo "<p style='color:red;'>Error: Por favor, preencha todos os campos obrigatórios.</p>";
} else {
  $email = $mysqli->real_escape_string($_POST['email']);
  $senha = $mysqli->real_escape_string(md5($_POST['senha']));

  $sql_code =
    "SELECT
      u.id as id,
      p.nome as nome,
      p.email as email,
      u.senha as senha,
      u.empresa_id as empresa_id,
      u.permissao_visualiza_chamado as 'permissao_visualiza_chamado',
      u.permissao_abrir_chamado as 'permissao_abrir_chamado',
      u.permissao_apropriar_chamado as 'permissao_apropriar_chamado',
      u.permissao_encaminhar_chamado as 'permissao_encaminhar_chamado',
      u.permissao_interessados_chamados as 'permissao_interessados_chamados',
      u.permissao_selecionar_competencias as 'permissao_selecionar_competencias',
      u.permissao_selecionar_solicitante as 'permissao_selecionar_solicitante',
      u.permissao_selecionar_atendente as 'permissao_selecionar_atendente',
      u.permissao_privacidade_credenciais as 'permissao_privacidade_credenciais',
      u.permissao_configuracoes_chamados as 'permissao_configuracoes_chamados',
      u.reset_password as reset_password,
      u.tipo_usuario as tipo_usuario,
      u.dashboard as dashboard,
      u.perfil_id as perfil,
      u.active as active,
      pe.perfil as nome_perfil
    FROM
      usuarios as u
    LEFT JOIN
      pessoas as p
    ON
      p.id = u.pessoa_id
    LEFT JOIN
      perfil as pe
    ON
      u.perfil_id = pe.id
    WHERE
      p.email = '$email' 
    AND 
      u.senha = '$senha'";

  $resultado = mysqli_query($mysqli, $sql_code) or die("Erro ao retornar dados");
  $quantidade_linhas = mysqli_num_rows($resultado);

  if ($quantidade_linhas == 1) {
    $usuario = $resultado->fetch_array();

    if ($usuario['active'] == "1" && $usuario['reset_password'] == "0") {

      if (!isset($_SESSION)) {
        session_start();
      }

      $_SESSION['id'] = $usuario['id'];
      $_SESSION['nome'] = $usuario['nome'];
      $_SESSION['empresa_id'] = $usuario['empresa_id'];
      $_SESSION['perfil'] = $usuario['perfil'];
      $_SESSION['nome_perfil'] = $usuario['nome_perfil'];
      $_SESSION['dashboard'] = $usuario['dashboard'];
      $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
      $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
      $_SESSION['permissao_visualiza_chamado'] = $usuario['permissao_visualiza_chamado'];
      $_SESSION['permissao_abrir_chamado'] = $usuario['permissao_abrir_chamado'];
      $_SESSION['permissao_apropriar_chamado'] = $usuario['permissao_apropriar_chamado'];
      $_SESSION['permissao_encaminhar_chamado'] = $usuario['permissao_encaminhar_chamado'];
      $_SESSION['permissao_interessados_chamados'] = $usuario['permissao_interessados_chamados'];
      $_SESSION['permissao_selecionar_competencias'] = $usuario['permissao_selecionar_competencias'];
      $_SESSION['permissao_selecionar_solicitante'] = $usuario['permissao_selecionar_solicitante'];
      $_SESSION['permissao_selecionar_atendente'] = $usuario['permissao_selecionar_atendente'];
      $_SESSION['permissao_privacidade_credenciais'] = $usuario['permissao_privacidade_credenciais'];
      $_SESSION['permissao_configuracoes_chamados'] = $usuario['permissao_configuracoes_chamados'];

      $usuario_id = $_SESSION['id'];
      $ip_address = $_SESSION['ip_address'];

      $insert_log = "INSERT INTO log_acesso (usuario_id, ip_address, horario) VALUES ('$usuario_id', '$ip_address', NOW())";
      mysqli_query($mysqli, $insert_log);

      echo "<p style='color:green;'>Code001: Acesso permitido.</p>";
    } else if ($usuario['active'] == "1" && $usuario['reset_password'] == "1") {
      echo "<p style='color:green;'>Code002: Reset Password.</p>";
    } else {
      echo "<p style='color:red;'>Error: Usuário inativo.</p>";
    }
  } else {
    echo "<p style='color:red;'>Error: Usuário ou senha incorreto.</p>";
  }
}
