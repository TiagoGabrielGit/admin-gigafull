<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$menu_id = "28";
$uid = $_SESSION['id'];

$permissions_menu =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_menu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_menu = $menu_id";
$exec_permissions_menu = $pdo->prepare($permissions_menu);
$exec_permissions_menu->execute();

$rowCount_permissions_menu = $exec_permissions_menu->rowCount();

if ($rowCount_permissions_menu > 0) {

    // Consulta à tabela integracao_ozmap para obter a URL da API e a chave de autenticação
    $queryIntegracaoOzmap = "SELECT urlAPI, chaveAutenticacao FROM integracao_ozmap LIMIT 1";
    $stmtIntegracaoOzmap = $pdo->query($queryIntegracaoOzmap);
    $integracaoOzmap = $stmtIntegracaoOzmap->fetch(PDO::FETCH_ASSOC);
    $urlAPI = $integracaoOzmap['urlAPI'];
    $chaveAutenticacao = $integracaoOzmap['chaveAutenticacao']; ?>

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">


                    <?php

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $codigo = $_POST['codigo'];

                        $APIurl = $urlAPI . '/properties/client/' . $codigo;

                        // Configurações cURL
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $APIurl);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            "Authorization: Bearer $chaveAutenticacao"
                        ]);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        $response = curl_exec($ch);

                        if (curl_errno($ch)) {
                            echo 'Erro na chamada CURL: ' . curl_error($ch);
                        } else {
                            $data = json_decode($response, true);

                            if ($data !== null && !empty($data[0])) {
                                $property = $data[0]; ?>
                                <div class="card">
                                    <div class="card-body">
                                        <br>
                                        <div class="row">
                                            <div class="col-9">
                                                <h3>Detalhes do Elemento | <?= $codigo ?></h3>
                                            </div>
                                            <div class="col-3">
                                                <label class="form-label">Localização</label>
                                                <?php
                                                $longitude = $property['coords'][0];
                                                $latitude = $property['coords'][1];
                                                $coords = $latitude . ',' . $longitude;
                                                echo '<p><a href="https://www.google.com/maps?q=' . $coords . '" target="_blank">Ver no Google Maps</a></p>';
                                                ?>
                                            </div>
                                        </div>
                                        <hr class="sidebar-divider">
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="form-label">Criação</label>
                                                <input class="form-control" disabled value="<?= $property['createdAt'] ?>"></input>
                                            </div>

                                            <div class="col-5">
                                                <label class="form-label">Endereço</label>
                                                <input class="form-control" disabled value="<?= $property['address'] ?>"></input>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <?php
                                            if (!empty($property['connections'])) {
                                                foreach ($property['connections'] as $connection) { ?>
                                                    <div class="col-2">
                                                        <label class="form-label">CTO</label>
                                                        <input class="form-control" disabled value="<?= $connection['name'] ?>"></input>
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="form-label">Porta</label>
                                                        <input class="form-control" disabled value="<?= $connection['port'] ?>"></input>
                                                    </div>
                                            <?php }
                                            } else {
                                                echo '<p>Sem conexões.</p>';
                                            } ?>
                                            <div class="col-3">
                                                <label class="form-label">NB Integration</label>
                                                <input class="form-control" disabled value="<?= $property['box'] ?>"></input>
                                            </div>
                                            <div class="col-3"></div>
                                            <div class="col-2">
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#autoDiagnostico" class="btn btn-sm btn-danger">Auto Diagnóstico</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <br>
                                                <h5>Incidentes da CTO | <?= $connection['name'] ?></h5>
                                                <?php
                                                $incidentes =
                                                    "SELECT
                                     DATE_FORMAT(i.inicioIncidente, '%d/%m/%Y %H:%i') as inicioIncidente, 
                                    DATE_FORMAT(i.fimIncidente, '%d/%m/%Y %H:%i') as fimIncidente,
                                    CASE
                                        WHEN i.active = 0 THEN 'Normalizado'
                                        WHEN i.active = 1 THEN 'Alarmando'
                                    END as status,
                                    IFNULL(DATE_FORMAT(i.previsaoNormalizacao, '%d/%m/%Y %H:%i'), 'Sem Previsão') as previsaoNormalizacao,
                                    iclass.classificacao as classificacao
                                FROM gpon_ctos as gc
                                JOIN incidentes_ctos as ic ON ic.cto_id = gc.id
                                JOIN incidentes as i ON i.id = ic.incidente_id
                                JOIN incidentes_classificacao as iclass ON iclass.id = i.classificacao
                                WHERE gc.nbintegration_code = :nbintegration_code
                                ORDER BY i.id DESC";

                                                $stmt = $pdo->prepare($incidentes);
                                                $stmt->bindParam(':nbintegration_code', $property['box']);
                                                $stmt->execute();
                                                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC); ?>

                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th style="text-align: center;" scope="col">Inicio Incidente</th>
                                                            <th style="text-align: center;" scope="col">Término Incidente</th>
                                                            <th style="text-align: center;" scope="col">Previsão Normalização</th>
                                                            <th style="text-align: center;" scope="col">Classificação</th>
                                                            <th style="text-align: center;" scope="col">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($resultados) {
                                                            $cto_problema = 0;
                                                            foreach ($resultados as $row) {
                                                                $statusColor = $row['status'] == 'Alarmando' ? 'red' : 'green'; ?>
                                                                <tr>
                                                                    <td style="text-align: center;">
                                                                        <span style="display: inline-block; width: 10px; height: 10px; background-color: <?= $statusColor ?>; border-radius: 50%;"></span>
                                                                    </td>
                                                                    <td style="text-align: center;"><?= $row['inicioIncidente'] ?></td>
                                                                    <td style="text-align: center;"><?= $row['fimIncidente'] ?></td>
                                                                    <td style="text-align: center;"><?= $row['previsaoNormalizacao'] ?></td>
                                                                    <td style="text-align: center;"><?= $row['classificacao'] ?></td>
                                                                    <td style="text-align: center;"><?= $row['status'] ?></td>
                                                                </tr>
                                                            <?php
                                                                if ($row['status'] == 'Alarmando') {
                                                                    $cto_problema = 1;
                                                                }
                                                            }
                                                        } else {
                                                            $cto_problema = 0;

                                                            ?>
                                                            <tr>
                                                                <td style="text-align: center;" colspan="6">
                                                                    Nenhum histórico de incidente encontrado.
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <?php
                            } else { ?>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-12">
                                            <h5 style="text-align: center; margin-top: 30px;" class="card-title">Código não encontrado</h5>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        }

                        curl_close($ch);
                    } else { ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="col-12">
                                    <h5 style="text-align: center; margin-top: 30px;" class="card-title">Método de requisição invalido.</h5>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="autoDiagnostico" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Auto Diagnóstico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $consulta_pon_id = "
               SELECT gp.id as pon_id
               FROM gpon_ctos as gc
               LEFT JOIN gpon_pon as gp ON gp.cod_int = gc.paintegration_code
               WHERE gc.nbintegration_code = :nbintegration_code";

                    $stmt = $pdo->prepare($consulta_pon_id);
                    $stmt->bindParam(':nbintegration_code', $property['box'], PDO::PARAM_INT);
                    $stmt->execute();
                    $pon_id = $stmt->fetchColumn(); // Diretamente pega o valor da coluna 'pon_id'


                    $consulta_incidente_pon = "SELECT COUNT(*) AS COUNT FROM incidentes WHERE pon_id = :pon_id AND active = 1";
                    $stmt = $pdo->prepare($consulta_incidente_pon);
                    $stmt->bindParam(':pon_id', $pon_id, PDO::PARAM_INT);
                    $stmt->execute();

                    $incidentes_count = $stmt->fetchColumn();
                    if ($incidentes_count > 0) { ?>
                        <p><i class="bi bi-exclamation-circle" style="color: red; font-size: 1.5em;"></i> Encontrado incidente para a PON do elemento </p>
                    <?php } else { ?>
                        <p><i class="bi bi-check-circle" style="color: green; font-size: 1.5em;"></i> Não encontrado nenhum incidente para a PON do elemento</p>


                    <?php }
                    if ($cto_problema > 0) { ?>
                        <p><i class="bi bi-exclamation-circle" style="color: red; font-size: 1.5em;"></i> Encontrado incidente para a CTO do elemento </p>

                    <?php } else { ?>
                        <p><i class="bi bi-check-circle" style="color: green; font-size: 1.5em;"></i> Não encontrado nenhum incidente para a CTO do elemento</p>


                    <?php }


                    ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}

require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
