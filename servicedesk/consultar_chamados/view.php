<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
$id_chamado = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
require "sql.php";

$id_usuario = $_SESSION['id'];
$sql_captura_dados_usuario =
    "SELECT
u.id as idUsuario,
u.pessoa_id as idPessoa,
u.empresa_id as idEmpresa,
u.tipo_usuario as tipoUsuario,
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


$resut_chamado1 = mysqli_query($mysqli, $sql_chamado1);
$chamado = mysqli_fetch_assoc($resut_chamado1);
$idEmpresaChamado = $chamado['idEmpresa'];


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
    require "code_view_smart.php";
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
