<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
$uid = $_SESSION['id'];

$submenu_id = "32";

$permissions =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();
$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {
    $olt_id = $_GET['olt_id'];
?>


    <main id="main" class="main">
        <div class="pagetitle">
            <h1>PONs</h1>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Interessados</h5>

                    <form method="POST" action="processa/adicionar_interessados.php" class="row g-3">
                        <hr class="sidebar-divider">

                        <div class="row">
                            <div class="col-4">
                                <input readonly hidden id="oltInteressado" name="oltInteressado" value="<?= $olt_id ?>"></input>
                            </div>

                            <div class="col-4">
                                <label for="empresaInteressada" class="form-label">Interessado</label>
                                <select required id="empresaInteressada" name="empresaInteressada" class="form-select">
                                    <option value="" disabled selected>Selecione...</option>
                                    <?php
                                    $lista_interessados =
                                        "SELECT
                        e.id as idEmpresa,
                        e.fantasia as fantasia
                        FROM empresas as e
                        WHERE e.atributoCliente = 1 OR e.atributoEmpresaPropria = 1
                        ORDER BY e.fantasia ASC";

                                    $r_interessados = mysqli_query($mysqli, $lista_interessados) or die("Erro ao retornar dados");
                                    while ($c_interessados = mysqli_fetch_assoc($r_interessados)) {
                                        $idEmpresa = $c_interessados['idEmpresa'];
                                        $fantasia = $c_interessados['fantasia'];
                                    ?>
                                        <option value="<?= $idEmpresa ?>"><?= $fantasia ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-4">
                                <button style="margin-top: 35px;" type="submit" class="btn btn-sm btn-danger">Adicionar</button>
                            </div>
                        </div>
                    </form>
                    <hr class="sidebar-divider">

                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">OLT</th>
                                <th scope="col">Interessado</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $interessados_cadastrados =
                                "SELECT
                goi.id as interessadoID,
                gpo.olt_name as olt_name,
                e.fantasia as fantasia
                FROM gpon_olts_interessados as goi
                LEFT JOIN empresas as e ON e.id = goi.interessado_empresa_id
                LEFT JOIN gpon_olts as gpo ON gpo.id = goi.gpon_olt_id
                WHERE goi.active = 1 AND gpo.id = $olt_id
                ORDER BY gpo.olt_name ASC, e.fantasia ASC";
                            $r_cadastrados = mysqli_query($mysqli, $interessados_cadastrados) or die("Erro ao retornar dados");
                            while ($c_cadastrados = $r_cadastrados->fetch_array()) {
                                $interessadoID = $c_cadastrados['interessadoID'];
                            ?>
                                <tr id="tabelaLista">
                                    <td><?= $c_cadastrados['olt_name'] ?></td>
                                    <td><?= $c_cadastrados['fantasia'] ?></td>
                                    <td>
                                        <form method="POST" action="processa/excluir_interessado.php">
                                        <input hidden readonly id="oltID" name="oltID" value="<?= $olt_id ?>"></input>

                                            <input hidden readonly id="intID" name="intID" value="<?= $interessadoID ?>"></input>
                                            <button class="btn btn-sm btn-danger">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="modalAdicionarPON" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar PONs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="card-body">
                        <form action="processa/adicionar_pon.php" method="POST" class="row g-3" id="formulario">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="col-12">

                                        <input hidden readonly id="olt" name="olt" value="<?= $olt_id ?>"></input>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="col-12">
                                        <div style="margin-top: 15px;" class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-sm btn-info" id="adicionar-campo">Adicionar Mais</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="campos-dinamicos">
                                <!-- Os campos de entrada dinâmicos serão adicionados aqui -->
                            </div>

                            <hr class="sidebar-divider">

                            <div class="text-center">
                                <button type="submit" class="btn btn-danger">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Função para adicionar campos de entrada dinamicamente
        document.getElementById('adicionar-campo').addEventListener('click', function() {
            var camposDinamicos = document.getElementById('campos-dinamicos');

            // Crie os elementos de entrada dinâmicos
            var novoCampo = document.createElement('div');
            novoCampo.classList.add('row');

            novoCampo.innerHTML = `
        <div class="col-3">
            <label for="slot" class="form-label">SLOT*</label>
            <input name="slot[]" class="form-control" type="text" required>
        </div>
        <div class="col-3">
            <label for="pon" class="form-label">PON*</label>
            <input name="pon[]" class="form-control" type="text" required>
        </div>
        <div class="col-3">
            <label for="codigo" class="form-label">Código Integração*</label>
            <input name="codigo[]" class="form-control" type="text" required>
        </div>
        <div style="margin-top: 35px;" class="col-3">
            <button type="button" class="btn btn-sm btn-danger" onclick="removerLinha(this)">Excluir</button>
        </div>
    `;

            camposDinamicos.appendChild(novoCampo);
        });

        // Função para remover a linha quando o botão "Excluir" é clicado
        function removerLinha(botaoExcluir) {
            var linha = botaoExcluir.parentNode.parentNode;
            var camposDinamicos = document.getElementById('campos-dinamicos');
            camposDinamicos.removeChild(linha);
        }
    </script>

<?php } else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>