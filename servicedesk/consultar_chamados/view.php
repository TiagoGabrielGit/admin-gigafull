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
u.permissao_visualiza_chamado as permissao_visualiza_chamado,

rnp.id as idParceiro
FROM
usuarios as u
LEFT JOIN
redeneutra_parceiro as rnp
ON
rnp.empresa_id = u.empresa_id
WHERE
u.active = 1
and
u.id = $id_usuario";

$r_dados_usuario = mysqli_query($mysqli, $sql_captura_dados_usuario);
$c_dados_usuario = mysqli_fetch_assoc($r_dados_usuario);
$idUsuario = $c_dados_usuario['idUsuario'];
$idPessoa = $c_dados_usuario['idPessoa'];
$pessoaID = $c_dados_usuario['idPessoa'];
$idEmpresa = $c_dados_usuario['idEmpresa'];
$idParceiro = $c_dados_usuario['idParceiro'];
$tipoUsuario = $c_dados_usuario['tipoUsuario'];
$permissao_visualiza_chamado = $c_dados_usuario['permissao_visualiza_chamado'];
$empresa_usuario = $c_dados_usuario['empresa_id'];

$resut_chamado1 = mysqli_query($mysqli, $sql_chamado1);
$chamado = mysqli_fetch_assoc($resut_chamado1);
$idEmpresaChamado = $chamado['idEmpresa'];
$tipo_chamado = $chamado['tipo_id'];

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

if ($tipoUsuario == "1") {
    if ($permissao_visualiza_chamado == 1 && ($chamado['idEmpresa'] == $empresa_usuario)) { // Visualiza somente chamados da empresa
        require "code_view_smart.php";
    } else if ($permissao_visualiza_chamado == 2) {
        $permissao_equipe = "SELECT DISTINCT ei.equipe_id
        FROM equipes_integrantes ei
        JOIN chamados_autorizados_by_equipe cae ON ei.equipe_id = cae.equipe_id
        WHERE ei.integrante_id = $idUsuario
        AND cae.tipo_id = $tipo_chamado";

        $r_permissao_equipe = $pdo->query($permissao_equipe);
        if ($r_permissao_equipe) {
            if ($r_permissao_equipe->rowCount() > 0) {
                require "code_view_smart.php";
            } else {
                require "../../acesso_negado.php";
                require "../../includes/footer.php";
            }
        } else {
            echo "Erro na execução da consulta: " . $pdo->errorInfo()[2];
        }
    } else if ($permissao_visualiza_chamado == 3) { //Visuliza todos chamados
        require "code_view_smart.php";
    } else {
        require "../../acesso_negado.php";
        require "../../includes/footer.php";
    }
} else if ($tipoUsuario == "2" && $idEmpresa == $idEmpresaChamado) {
    require "code_view_cliente.php";
} else if ($tipoUsuario == "3" && $idEmpresa == $idEmpresaChamado) {
    require "code_view_tenant.php";
} else { ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Operação não permitida!</h1>
        </div>
    </main>
<?php
    require "../../includes/footer.php";
}
