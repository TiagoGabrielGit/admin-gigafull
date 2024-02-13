<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "../../conexoes/conexao_pdo.php";
$id_chamado = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$s_empresaID = $_SESSION['empresa_id'];


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

$sql_chamado1 =
    "SELECT
c.id as id_chamado,
c.assuntoChamado as assunto,
c.relato_inicial as relato_inicial,
c.solicitante_equipe_id as solicitante_equipe_id,
c.prioridade as prioridade,
tc.afericao as afericao,
date_format(c.data_abertura,'%H:%i:%s %d/%m/%Y') as abertura,
date_format(c.data_fechamento,'%H:%i:%s %d/%m/%Y') as fechado,
c.atendente_id as id_atendente,
c.in_execution as in_execution,
c.in_execution_atd_id as in_execution_atd_id,
c.in_execution_start as in_execution_start,
c.data_prevista_conclusao as 'data_prevista_conclusao',
c.melhoria_recomendada as 'melhoria_recomendada',
tc.tipo as tipo,
tc.id as tipo_id,
cs.status_chamado as status,
e.fantasia as empresa,
e.id as idEmpresa,
s.service as service,
ise.item as itemService  
FROM chamados as c 
LEFT JOIN chamado_relato as cr ON c.id = cr.chamado_id
LEFT JOIN tipos_chamados as tc ON c.tipochamado_id = tc.id
LEFT JOIN chamados_status as cs ON c.status_id = cs.id
LEFT JOIN portal_user as pu ON pu.id = c.solicitante_id
LEFT JOIN pessoas as p ON p.id = c.solicitante_id
LEFT JOIN empresas as e ON e.id = c.empresa_id
LEFT JOIN contract_service as cser ON cser.id = c.service_id
LEFT JOIN service as s ON s.id = cser.service_id
LEFT JOIN contract_iten_service as cis ON cis.id = c.iten_service_id
LEFT JOIN iten_service as ise ON ise.id = cis.iten_service
WHERE c.id = '$id_chamado'";


$resut_chamado1 = mysqli_query($mysqli, $sql_chamado1);
$chamado = mysqli_fetch_assoc($resut_chamado1);
$idEmpresaChamado = $chamado['idEmpresa'];
$tipo_chamado = $chamado['tipo_id'];
$solicitante_equipe_id = $chamado['solicitante_equipe_id'];

$sql_solicitante =
    "SELECT p.nome as solicitante
FROM chamados as c
LEFT JOIN usuarios as u ON c.solicitante_id = u.id
LEFT JOIN pessoas as p ON u.pessoa_id = p.id
WHERE c.id = '$id_chamado'";

$resut_solicitante = mysqli_query($mysqli, $sql_solicitante);
$solicitante = mysqli_fetch_assoc($resut_solicitante);

$sql_atendente =
    "SELECT p.nome as atendente
FROM chamados as c
LEFT JOIN usuarios as u ON u.id = c.atendente_id
LEFT JOIN pessoas as p ON p.id = u.pessoa_id
WHERE c.id = '$id_chamado'";

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
