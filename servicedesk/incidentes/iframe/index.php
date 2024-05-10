<?php


require "../../../includes/menu.php";
require "../../../conexoes/conexao.php";
require "../../../conexoes/conexao_pdo.php";

$submenu_id = "41";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {

?>

    <style>
        #tabelaLista:hover {
            cursor: pointer;
            background-color: #E0FFFF;
        }
    </style>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>IFRAME INFORMATIVOS</h1>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <h5 class="card-title"></h5>
                                            </div>
                                            <div class="col-lg-2" style="margin-top: 10px;">
                                                <button style="margin-top: 15px" type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                                    Novo Iframe
                                                </button>
                                            </div>
                                        </div>


                                        <hr class="sidebar-divider">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <table class="table datatable" id="styleTable">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Código</th>
                                                                <th scope="col">Titulo</th>
                                                                <th scope="col">Tipo Informativo</th>
                                                                <th scope="col">Empresa</th>
                                                                <th scope="col">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $sql =
                                                                "SELECT ii.id as id, e.fantasia as fantasia, ii.titulo as titulo, it.type,
                                                                CASE
                                                                WHEN ii.active = 1 THEN 'Ativo'
                                                                WHEN ii.active = 0 THEN 'Inativo'
                                                                END AS active
                                                                FROM incidentes_iframe as ii
                                                                LEFT JOIN empresas as e ON e.id = ii.empresa_id
                                                                LEFT JOIN incidentes_types as it ON it.id = ii.tipo_incidente_id
                                                                ";

                                                            $r_sql = mysqli_query($mysqli, $sql);

                                                            while ($c_sql = $r_sql->fetch_array()) {
                                                            ?>
                                                                <tr id="tabelaLista" onclick="location.href='edit.php?id=<?= $c_sql['id'] ?>'">
                                                                    <td><?= $c_sql['id']; ?></td>
                                                                    <td><?= $c_sql['titulo']; ?></td>
                                                                    <td><?= $c_sql['type']; ?></td>
                                                                    <td><?= $c_sql['fantasia']; ?></td>
                                                                    <td><?= $c_sql['active']; ?></td>
                                                                </tr>

                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="basicModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Iframe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="card-body">
                        <form method="POST" action="processa/novo_iframe.php">
                            <div class="row">
                                <div class="col-6">
                                    <label for="titulo" class="form-label">Titulo</label>
                                    <input id="titulo" name="titulo" class="form-control" required>
                                </div>
                                <div class="col-6">
                                    <label for="tipo_informativo" class="form-label">Tipo Informativo</label>
                                    <select class="form-select" id="tipo_informativo" name="tipo_informativo" required>
                                        <option value="" selected>Selecione...</option>
                                        <?php
                                        try {
                                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            $sql_tipo_informativo = "SELECT it.id, type FROM incidentes_types as it WHERE it.active = 1 ORDER BY it.type ASC";
                                            $stmt = $pdo->prepare($sql_tipo_informativo);
                                            $stmt->execute();
                                            $tipos_informativos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($tipos_informativos as $tipos) {
                                                $id_ti = $tipos["id"];
                                                $tipo_ti = $tipos["type"];
                                                echo "<option value='$id_ti'>$tipo_ti</option>";
                                            }
                                        } catch (PDOException $e) {
                                            echo "Erro de conexão: " . $e->getMessage();
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="empresa" class="form-label">Empresa</label>
                                    <select class="form-select" id="empresa" name="empresa" required>
                                        <option value="" selected>Selecione...</option>
                                        <?php
                                        try {
                                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            $sql_empresa = "SELECT id, fantasia FROM empresas ORDER BY fantasia ASC";
                                            $stmt = $pdo->prepare($sql_empresa);
                                            $stmt->execute();
                                            $empresas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($empresas as $empresa) {
                                                $id_empresa = $empresa["id"];
                                                $nome_empresa = $empresa["fantasia"];
                                                echo "<option value='$id_empresa'>$nome_empresa</option>";
                                            }
                                        } catch (PDOException $e) {
                                            echo "Erro de conexão: " . $e->getMessage();
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-sm btn-danger">Salvar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Basic Modal-->


<?php
} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php";
?>