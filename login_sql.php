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
    p.id as id_pessoa,
    u.senha as senha,
    u.control as control,
    u.empresa_id as empresa_id,
    up.permite_interagir_chamados as 'permite_interagir_chamados',
    up.permite_abrir_chamados_outras_empresas as 'permite_abrir_chamados_outras_empresas',
    up.permite_atender_chamados_outras_empresas as 'permite_atender_chamados_outras_empresas',
    up.permite_atender_chamados as 'permite_atender_chamados',
    up.permite_encaminhar_chamados as 'permite_encaminhar_chamados',
    up.permite_gerenciar_interessados as 'permite_gerenciar_interessados',
    up.permite_selecionar_competencias_abertura_chamado as 'permite_selecionar_competencias_abertura_chamado',
    up.permite_selecionar_solicitantes_abertura_chamado as 'permite_selecionar_solicitantes_abertura_chamado',
    up.permite_selecionar_atendente_abertura_chamado as 'permite_selecionar_atendente_abertura_chamado',
    up.permite_alterar_configuracoes_chamado as 'permite_alterar_configuracoes_chamado',
    up.permite_visualizar_protocolo_erp as 'permite_visualizar_protocolo_erp',
    up.permite_configurar_privacidade_equipamentos as 'permite_configurar_privacidade_equipamentos',
    up.permite_configurar_privacidade_credenciais as 'permite_configurar_privacidade_credenciais',
    up.permite_gerenciar_incidente as 'permite_gerenciar_incidente',
    up.permissao_equipamentos_pop as 'permissao_equipamentos_pop',
    up.permissao_vms as 'permissao_vms',
    up.permissao_email as 'permissao_email',
    up.permissao_portal as 'permissao_portal',
    up.permissao_pop_site as 'permissao_pop_site',
    u.reset_password as reset_password,
    u.tipo_usuario as tipo_usuario,
    u.dashboard as dashboard,
    u.perfil_id as perfil,
    u.active as active, 
    ei.equipe_id as equipe_id,
    pe.perfil as nome_perfil,
    e.atributoEmpresaPropria as atributoEmpresaPropria
  FROM usuarios as u
  LEFT JOIN pessoas as p ON p.id = u.pessoa_id
  LEFT JOIN perfil as pe ON u.perfil_id = pe.id
  LEFT JOIN equipes_integrantes as ei ON u.id = ei.integrante_id
  LEFT JOIN usuarios_permissoes as up ON u.id = up.usuario_id
  LEFT JOIN empresas as e ON e.id = u.empresa_id
    WHERE p.email = '$email' AND u.senha = '$senha'";

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


      $_SESSION['permite_interagir_chamados'] = $usuario['permite_interagir_chamados'];
      $_SESSION['permite_abrir_chamados_outras_empresas'] = $usuario['permite_abrir_chamados_outras_empresas'];
      $_SESSION['permite_atender_chamados_outras_empresas'] = $usuario['permite_atender_chamados_outras_empresas'];
      $_SESSION['permite_atender_chamados'] = $usuario['permite_atender_chamados'];
      $_SESSION['permite_encaminhar_chamados'] = $usuario['permite_encaminhar_chamados'];
      $_SESSION['permite_gerenciar_interessados'] = $usuario['permite_gerenciar_interessados'];
      $_SESSION['permite_selecionar_competencias_abertura_chamado'] = $usuario['permite_selecionar_competencias_abertura_chamado'];
      $_SESSION['permite_selecionar_solicitantes_abertura_chamado'] = $usuario['permite_selecionar_solicitantes_abertura_chamado'];
      $_SESSION['permite_selecionar_atendente_abertura_chamado'] = $usuario['permite_selecionar_atendente_abertura_chamado'];
      $_SESSION['permite_alterar_configuracoes_chamado'] = $usuario['permite_alterar_configuracoes_chamado'];
      $_SESSION['permite_visualizar_protocolo_erp'] = $usuario['permite_visualizar_protocolo_erp'];
      $_SESSION['permite_configurar_privacidade_equipamentos'] = $usuario['permite_configurar_privacidade_equipamentos'];
      $_SESSION['permite_configurar_privacidade_credenciais'] = $usuario['permite_configurar_privacidade_credenciais'];
      $_SESSION['atributoEmpresaPropria'] = $usuario['atributoEmpresaPropria'];
      $_SESSION['id_pessoa'] = $usuario['id_pessoa'];
      $_SESSION['permite_gerenciar_incidente'] = $usuario['permite_gerenciar_incidente'];
      $_SESSION['permissao_equipamentos_pop'] = $usuario['permissao_equipamentos_pop'];
      $_SESSION['permissao_vms'] = $usuario['permissao_vms'];
      $_SESSION['permissao_email'] = $usuario['permissao_email'];
      $_SESSION['permissao_portal'] = $usuario['permissao_portal'];
      $_SESSION['permissao_pop_site'] = $usuario['permissao_pop_site'];



      $empresaID = $_SESSION['empresa_id'];
      $_SESSION['equipe_id'] = $usuario['equipe_id'];


      $usuario_id = $_SESSION['id'];
      $ip_address = $_SESSION['ip_address'];

      if ($usuario['control'] == "1") {
        $insert_log = "INSERT INTO log_acesso (usuario_id, ip_address, plataforma, horario) VALUES ('$usuario_id', '$ip_address', 'SmartControl', NOW())";
        mysqli_query($mysqli, $insert_log);

        echo "<p style='color:green;'>Code001: Acesso permitido.</p>";
      } else {
        echo "<p style='color:red;'>Error: Usuário não habilitado para acesso ao SmartControl.</p>";
      }
    } else if ($usuario['active'] == "1" && $usuario['reset_password'] == "1") {
      echo "<p style='color:green;'>Code002: Reset Password.</p>";
    } else {
      echo "<p style='color:red;'>Error: Usuário inativo.</p>";
    }
  } else {
    echo "<p style='color:red;'>Error: Usuário ou senha incorreto.</p>";
  }
}
