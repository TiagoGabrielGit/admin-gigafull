<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao.php";
require "../../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];

$submenu_id = "55";

$permissions =
    "SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {

    $statusChamadoValue = "";
    $ativoValue = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Se sim, atribua os valores dos campos de filtro às variáveis correspondentes
        $statusChamadoValue = isset($_POST['statusChamado']) ? $_POST['statusChamado'] : "";
        $ativoValue = isset($_POST['ativo']) ? $_POST['ativo'] : "";

    }
?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Status de chamados</h1>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">

                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div style="margin-top: 50px;" class="col-lg-9">
                                        <form action="#" method="POST">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="statusChamado" class="form-label">Status de Chamado</label>
                                                    <input id="statusChamado" name="statusChamado" class="form-control" value="<?php echo $statusChamadoValue; ?>"></input>
                                                </div>
                                                <div class="col-3">
                                                    <label for="ativo" class="form-label">Ativo</label>
                                                    <select class="form-select" id="ativo" name="ativo">
                                                        <option value="">Todos</option>
                                                        <option value="1" <?php if ($ativoValue == "1") echo "selected"; ?>>Sim</option>
                                                        <option value="0" <?php if ($ativoValue == "0") echo "selected"; ?>>Não</option>
                                                    </select>
                                                </div>
                                                <div style="margin-top: 35px;" class="col-3">
                                                    <button type="submit" class="btn btn-sm btn-danger">Aplicar Filtros</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="card">
                                            <button style="margin-top: 15px" type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                                Novo
                                            </button>
                                        </div>
                                    </div>



                                    <div class="modal fade" id="basicModal" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Novo Status</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <form action="processa/adicionar.php" method="POST" class="row g-3 needs-validation">


                                                            <div class="col-6">
                                                                <label for="statusChamado" class="form-label">Status</label>
                                                                <input id="statusChamado" name="statusChamado" class="form-control" required></input>
                                                            </div>

                                                            <div class="col-6">
                                                                <label for="statusColor" class="form-label">Cor Referência</label>
                                                                <input type="color" class="form-control form-control-color" name="statusColor" id="statusColor" value="#4154f1">
                                                            </div>

                                                            <hr class="sidebar-divider">

                                                            <div class="text-center">
                                                                <button type="submit" class="btn btn-sm btn-danger">Salvar</button>

                                                                <a href="/servicedesk/tipos_chamados/status/index.php"> <input type="button" value="Voltar" class="btn btn-sm btn-secondary"></input></a>
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
                                        <th style="text-align: center;" scope="col">Status de chamado</th>
                                        <th style="text-align: center;" scope="col">Cor Referência</th>
                                        <th style="text-align: center;" scope="col">Default</th>
                                        <th style="text-align: center;" scope="col">Ativo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_lista_status =
                                        "SELECT
                                            cs.id as id_status,
                                            cs.status_chamado as status_chamado,
                                            cs.color as color,
                                            CASE
                                                WHEN cs.cadastroDefault = 1 THEN 'Sim'
                                                WHEN cs.cadastroDefault = 0 THEN 'Não'
                                            END as cadastroDefault,
                                            CASE
                                                WHEN cs.active = 1 THEN 'Ativado'
                                                WHEN cs.active = 0 THEN 'Inativado'
                                            END as active_status
                                        FROM chamados_status as cs
                                        WHERE 1=1";

                                    // Adicionando condições dinâmicas baseadas nos valores do formulário
                                    if (!empty($_POST['statusChamado'])) {
                                        $statusChamado = $_POST['statusChamado'];
                                        $sql_lista_status .= " AND cs.status_chamado LIKE '%$statusChamado%'";
                                    }

                                    if (isset($_POST['ativo'])) {
                                        $ativo = $_POST['ativo'];
                                        // Se $ativo não estiver vazio, ou seja, foi selecionado um valor no filtro
                                        if ($ativo !== '') {
                                            $sql_lista_status .= " AND cs.active = '$ativo'";
                                        }
                                    }

                                    $sql_lista_status .= " ORDER BY cs.status_chamado ASC";

                                    $resultado = mysqli_query($mysqli, $sql_lista_status) or die("Erro ao retornar dados");

                                    while ($campos = $resultado->fetch_array()) {
                                        $id = $campos['id_status'];

                                    ?>
                                        <tr>
                                            <td style="text-align: center;">
                                                <?php
                                                if ($campos['cadastroDefault'] == 'Sim') { ?>
                                                    <?= $campos['status_chamado']; ?>
                                                <?php } else { ?>
                                                    <a style="color: red;" href="view.php?id=<?= $id ?>">
                                                        <?= $campos['status_chamado']; ?>
                                                    </a>
                                                <?php }
                                                ?>
                                            </td>
                                            <td style="text-align: center;"><?= $campos['color']; ?></td>
                                            <td style="text-align: center;"><?= $campos['cadastroDefault']; ?></td>

                                            <td style="text-align: center;"><?= $campos['active_status']; ?></td>
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
} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php"; ?>