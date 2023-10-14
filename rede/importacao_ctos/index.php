<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";
require "../../conexoes/conexao_voalle.php";

$uid = $_SESSION['id'];

$submenu_id = "43";

$permissions =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp
ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {
    $int_voalle =
        "SELECT iv.active
        FROM integracao_voalle as iv
        WHERE iv.id = 1";

    $exec_int_voalle = $pdo->prepare($int_voalle);
    $exec_int_voalle->execute();
    $result = $exec_int_voalle->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['active'] == 1) {
        $query_ctos =
            "SELECT asp.id as id, asp.title as title, asp.lat as lat, asp.lng as lng, aap.title as patitle, aap.integration_code as paintegration_code, nb.integration_code as nbintegration_code
    FROM authentication_splitters as ASP
    JOIN authentication_access_points as AAP on AAP.id = ASP.authentication_access_point_id
    JOIN network_boxes as nb ON nb.id = asp.network_box_id
    WHERE asp.type = 1 and asp.deleted = false
    ORDER BY asp.title ASC";

        $stmt_voalle = $pgsql_pdo->query($query_ctos);
        $caixas_voalle = $stmt_voalle->fetchAll(PDO::FETCH_ASSOC);

        // Consulta para obter as caixas da tabela interna gpon_ctos
        $query_gpon_ctos = "SELECT id, title, lat, lng, patitle, paintegration_code, nbintegration_code, created_at, updated_at FROM gpon_ctos";
        $stmt_gpon_ctos = $pdo->query($query_gpon_ctos);
        $caixas_gpon_ctos = $stmt_gpon_ctos->fetchAll(PDO::FETCH_ASSOC);

        // Crie um array para armazenar as IDs das caixas da tabela gpon_ctos
        $gpon_ctos_ids = array_map(function ($caixa) {
            return $caixa['id'];
        }, $caixas_gpon_ctos);

?>

        <main id="main" class="main">
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="text-left">
                                <h5 class="card-title">Importação CTOs - Via Integração Voalle</h5>
                            </div>
                            <div class="text-end">
                                <button id="importButton" class="btn btn-sm btn-danger">Importar</button>
                            </div>
                            <div id="message" class="alert alert-success" style="display: none;">
                                Importação concluída.
                            </div>
                        </div>
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Caixa</th>
                                    <th style="text-align: center;">Latitude</th>
                                    <th style="text-align: center;">Longitude</th>
                                    <th style="text-align: center;">Status de Importação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($caixas_voalle as $caixa_voalle) :
                                    $id = $caixa_voalle['id'] ?>

                                    <tr>
                                        <td style="text-align: center;"><?= $caixa_voalle['title']; ?></td>
                                        <td style="text-align: center;"><?= $caixa_voalle['lat']; ?></td>
                                        <td style="text-align: center;"><?= $caixa_voalle['lng']; ?></td>
                                        <td style="text-align: center;">
                                            <?php
                                            if (in_array($caixa_voalle['id'], $gpon_ctos_ids)) {
                                                // Verifique se há divergências nos campos
                                                $gpon_ctos = $caixas_gpon_ctos[array_search($caixa_voalle['id'], $gpon_ctos_ids)];
                                                if (
                                                    $caixa_voalle['title'] != $gpon_ctos['title'] ||
                                                    $caixa_voalle['lat'] != $gpon_ctos['lat'] ||
                                                    $caixa_voalle['lng'] != $gpon_ctos['lng'] ||
                                                    $caixa_voalle['nbintegration_code'] != $gpon_ctos['nbintegration_code'] ||
                                                    $caixa_voalle['paintegration_code'] != $gpon_ctos['paintegration_code']
                                                ) {
                                                    echo "Divergente";
                                                    $caixaStatus = "Importada com divergencias";
                                                } else {
                                                    echo "Importada";
                                                    $caixaStatus = "Importada com sucesso";
                                                }
                                            } else {
                                                echo "Não Importada";
                                            }
                                            ?>
                                        </td>
                                        <td style="text-align: center;"><button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal<?= $id ?>">
                                                Mais Informações </button></td>
                                    </tr>


                                    <div class="modal fade" id="basicModal<?= $id ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><?= $caixa_voalle['title']; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <span><b>Integration Code Caixa:</b> </span><?= $caixa_voalle['nbintegration_code']; ?><br>
                                                    <span><b>Integration Code PA:</b> </span><?= $caixa_voalle['paintegration_code']; ?><br>
                                                    <span><b>Ponto de Acesso:</b> </span><?= $caixa_voalle['patitle']; ?><br><br>
                                                    <?php if (isset($caixaStatus)) { ?>
                                                        <span><b>Status:</b> </span><?= $caixaStatus ?><br>
                                                        <span><b>Criada em:</b> </span><?= $gpon_ctos['created_at']; ?><br>
                                                        <span><b>Atualizada em:</b> </span><?= $gpon_ctos['updated_at']; ?><br>
                                                    <?php } ?>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End Basic Modal-->
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#importButton").click(function() {
                    $.ajax({
                        type: "POST",
                        url: "processa/importar_caixas.php",
                        success: function(response) {
                            // Lidar com a resposta do servidor, se necessário
                            console.log(response);
                            $("#message").removeClass("alert-danger").addClass("alert-success").text("Importação concluída.").show();

                            // Aguardar 1 segundo e depois ocultar a mensagem e atualizar a página
                            setTimeout(function() {
                                $("#message").hide();
                                location.reload(); // Atualizar a página
                            }, 2000); // 1000 milissegundos = 1 segundo
                        },
                        error: function(xhr, status, error) {
                            $("#message").removeClass("alert-success").addClass("alert-danger").text("Erro na importação: " + error).show();
                        }
                    });
                });
            });
        </script>

    <?php
    } else { ?>

        <main id="main" class="main">

            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 style="text-align: center; margin-top: 30px;" class="card-title">Integração com Voalle não esta habilitada</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </main>
<?php   }
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php"; ?>