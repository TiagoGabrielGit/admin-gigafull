<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
$id_chamado = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
require "sql.php";

$id_usuario = $_SESSION['id'];
$sql_captura_id_pessoa =
    "SELECT
    u.pessoa_id as pessoaID,
    u.tipo_usuario as tipoUsuario,
    u.parceiroRN_id as parceiroRN_id,
    rnp.empresa_id as idEmpresa
    FROM
    usuarios as u
    LEFT JOIN
    redeneutra_parceiro as rnp
    ON
    rnp.id = u.parceiroRN_id
    WHERE
    u.id = '$id_usuario'";

$result_cap_pessoa = mysqli_query($mysqli, $sql_captura_id_pessoa);
$pessoaID = mysqli_fetch_assoc($result_cap_pessoa);
$tipoUsuario = $pessoaID['tipoUsuario'];
$idEmpresa = $pessoaID['idEmpresa'];

$resut_chamado1 = mysqli_query($mysqli, $sql_chamado1);
$chamado = mysqli_fetch_assoc($resut_chamado1);
$idEmpresaChamado = $chamado['idEmpresa'];


$resut_solicitante = mysqli_query($mysqli, $sql_solicitante);
$solicitante = mysqli_fetch_assoc($resut_solicitante);

$resut_atendente = mysqli_query($mysqli, $sql_atendente);
$atendente = mysqli_fetch_assoc($resut_atendente);

if (empty($atendente['atendente'])) {
    $atendente = "Sem atendente";
} else {
    $atendente = $atendente['atendente'];
}

if ($tipoUsuario == "1") {
    require "code_view.php";
} else if ($tipoUsuario == "3" && $idEmpresa == $idEmpresaChamado) {
    require "code_view.php";
} else { ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Operação não permitida!</h1>
        </div>
    </main>
<?php
    require "../../includes/footer.php";
}
