<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao.php";
require "../../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];

$submenu_id = "52";

$permissions =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {
?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Tipos de chamados</h1>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">

                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-9"></div>
                                    <div class="col-3">
                                        <div class="card">
                                            <button style="margin-top: 15px" type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                                Novo
                                            </button>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="basicModal" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Novo tipo</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <form id="cadastraTipoChamado" method="POST" class="row g-3 needs-validation">

                                                            <span id="msg"></span>

                                                            <div class="col-12">
                                                                <label for="tipoChamado" class="form-label">Tipo de chamado</label>
                                                                <input id="tipoChamado" name="tipoChamado" class="form-control" required></input>
                                                            </div>

                                                            <hr class="sidebar-divider">

                                                            <div class="text-center">
                                                                <input id="btnSalvar" name="btnSalvar" type="button" value="Salvar" class="btn btn-sm btn-sm btn-danger"></input>
                                                                <a href="/servicedesk/tipos_chamados/tipos/index.php"> <input type="button" value="Voltar" class="btn btn-sm btn-secondary"></input></a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="sidebar-divider">

                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;" scope="col">Tipo de chamado</th>
                                        <th style="text-align: center;" scope="col">Ativo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_lista_tipos_chamados =
                                        "SELECT
                                tc.id as id_tipo,
                                tc.tipo as nome_tipo,
                                CASE
                                    WHEN tc.active = 1 THEN 'Ativado'
                                    WHEN tc.active = 0 THEN 'Inativado'
                                END as ativo_tipo
                                FROM
                                tipos_chamados as tc
                                ORDER BY
                                tc.tipo ASC
                                ";

                                    $resultado = mysqli_query($mysqli, $sql_lista_tipos_chamados) or die("Erro ao retornar dados");

                                    while ($campos = $resultado->fetch_array()) {
                                        $id = $campos['id_tipo'];

                                    ?>
                                        <tr>
                                            <td style="text-align: center;">
                                                <a style="color: red;" href="view.php?id=<?= $id ?>"><?= $campos['nome_tipo']; ?></a>
                                            </td>
                                            <td style="text-align: center;"><?= $campos['ativo_tipo']; ?></td>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php
    require "js.php";
} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php"; ?>