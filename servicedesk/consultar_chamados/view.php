<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "../../conexoes/conexao_pdo.php";
$id_chamado = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$s_empresaID = $_SESSION['empresa_id'];
require "sql.php";

$id_usuario = $_SESSION['id'];

$sql_captura_dados_usuario =
    "SELECT
u.id as idUsuario,
u.pessoa_id as idPessoa,
u.empresa_id as idEmpresa,
u.empresa_id as empresa_id,
u.tipo_usuario as tipoUsuario,
ei.equipe_id as equipe_id,
u.permissao_visualiza_chamado as permissao_visualiza_chamado,
e.atributoEmpresaPropria as atributoEmpresaPropria
FROM usuarios as u
LEFT JOIN empresas as e ON e.id = u.empresa_id
LEFT JOIN equipes_integrantes as ei ON u.id = ei.integrante_id
WHERE u.active = 1 and u.id = $id_usuario";

$r_dados_usuario = mysqli_query($mysqli, $sql_captura_dados_usuario);
$c_dados_usuario = mysqli_fetch_assoc($r_dados_usuario);
$idUsuario = $c_dados_usuario['idUsuario'];
$idPessoa = $c_dados_usuario['idPessoa'];
$pessoaID = $c_dados_usuario['idPessoa'];
$idEmpresa = $c_dados_usuario['idEmpresa'];
$usuario_equipe_id = $c_dados_usuario['equipe_id'];

//$idParceiro = $c_dados_usuario['idParceiro'];
$tipoUsuario = $c_dados_usuario['tipoUsuario'];
$permissao_visualiza_chamado = $c_dados_usuario['permissao_visualiza_chamado'];
$empresa_usuario = $c_dados_usuario['empresa_id'];
$atributoEmpresaPropria = $c_dados_usuario['atributoEmpresaPropria'];



$resut_chamado1 = mysqli_query($mysqli, $sql_chamado1);
$chamado = mysqli_fetch_assoc($resut_chamado1);
$idEmpresaChamado = $chamado['idEmpresa'];
$tipo_chamado = $chamado['tipo_id'];
$solicitante_equipe_id = $chamado['solicitante_equipe_id'];

$resut_solicitante = mysqli_query($mysqli, $sql_solicitante);
$solicitante = mysqli_fetch_assoc($resut_solicitante);

$resut_atendente = mysqli_query($mysqli, $sql_atendente);
$atendente = mysqli_fetch_assoc($resut_atendente);

$usuario_ocupado =
    "SELECT
count(*) as qtde
FROM
chamados as c
WHERE
c.in_execution = 1 
and
c.in_execution_atd_id = $idPessoa";

$r_usuario_ocupado = mysqli_query($mysqli, $usuario_ocupado);
$c_usuario_ocupado = mysqli_fetch_assoc($r_usuario_ocupado);

if (empty($atendente['atendente'])) {
    $atendente = "Sem atendente";
} else {
    $atendente = $atendente['atendente'];
}

if ($permissao_visualiza_chamado == 1 && ($chamado['idEmpresa'] == $empresa_usuario)) { // Visualiza somente chamados da empresa
    require "code_view.php";
} else if ($permissao_visualiza_chamado == 2) {
    if ($solicitante_equipe_id == $usuario_equipe_id) {
        require "code_view.php";
    } else {
        require "../../acesso_negado.php";
        require "../../includes/footer.php";
    }
} else if ($permissao_visualiza_chamado == 3) { //Visuliza todos chamados
    require "code_view.php";
} else {
    require "../../acesso_negado.php";
    require "../../includes/footer.php";
}
