<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";
$usuarioID = $_SESSION['id'];
$query = "SELECT u.permissao_protocolo_erp as permissao_protocolo_erp
          FROM usuarios as u
          WHERE u.id = :usuarioID";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':usuarioID', $usuarioID, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row) {
    $permissao_protocolo_erp = $row['permissao_protocolo_erp'];
    if ($permissao_protocolo_erp == 1) {
        $integracao_voalle = "SELECT iv.active as active
        FROM integracao_voalle as iv
        WHERE iv.id = 1";

        $stmt_iv = $pdo->prepare($integracao_voalle);
        $stmt_iv->execute();
        $row_iv = $stmt_iv->fetch(PDO::FETCH_ASSOC);
        if ($row_iv['active'] == 1) {
            $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
            $domain = $_SERVER['HTTP_HOST'];
            $baseUrl = $protocol . $domain;
            $protocoloERP = $_POST['protocoloERP'];


            $url = $baseUrl . "/integracao/voalle/api/detalhes_solicitacao.php?protocol=" . $protocoloERP;
            $response = file_get_contents($url);
            if ($response === false) {
                die('Erro na chamada à API: ' . error_get_last()['message']);
            }
            $data = json_decode($response, true);
            $solicitacao = $data['solicitacao'];
            $protocolo = $solicitacao['response']['protocol'];
            $tipoProtocolo = $solicitacao['response']['incidentType']['title'];
            $protocolStatus = $solicitacao['response']['incidentStatus']['title'];
            $protocolCatalogo = $solicitacao['response']['catalogService']['title'];
            $protocolItem = $solicitacao['response']['catalogServiceItem']['title'];
            $protocolResponsavel = $solicitacao['response']['responsible']['name'];
            $protocolEquipe = $solicitacao['response']['team']['title'];
            $beginningDate = $solicitacao['response']['beginningDate'];
            $beginningDate = new DateTime($beginningDate);
            $beginningDate = $beginningDate->format('d/m/Y H:i'); ?>

            <main id="main" class="main">
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="text-left">
                                            <h5 class="card-title">Protocolo ERP: <?= $protocolo ?> </h5>
                                        </div>
                                        <div class="text-end">
                                            <div class="text-end">
                                                <button class="btn btn-sm btn-danger" style="margin-top: 25px;" id="requestTokenButton" onclick="goBack()">Voltar à página anterior</button>

                                                <script>
                                                    function goBack() {
                                                        window.history.back();
                                                    }
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <span><b>Tipo de Protocolo:</b></span> <?= $tipoProtocolo; ?> <br>
                                                <span><b>Status Protocolo:</b></span> <?= $protocolStatus; ?> <br>
                                                <span><b>Catálogo Protocolo:</b></span> <?= $protocolCatalogo; ?> <br>
                                                <span><b>Item Protocolo:</b></span> <?= $protocolItem; ?> <br>
                                            </div>
                                            <div class="col-6">
                                                <span><b>Data Abertura:</b></span> <?= $beginningDate; ?> <br>

                                                <span><b>Equipe Protocolo:</b></span> <?= $protocolEquipe; ?> <br>
                                                <span><b>Responsável Protocolo:</b></span> <?= $protocolResponsavel; ?> <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Relatos do Protocolo</h5>

                                    <div class="accordion" id="accordionExample">

                                        <?php
                                        if (isset($data['relatos']) && isset($data['relatos']['response'])) {
                                            $relatos = $data['relatos']['response'];

                                            foreach ($relatos as $relato) {
                                                $typeOperation = $relato['typeOperation'];
                                                $id = $relato['id'];
                                                $title = $relato['title'];
                                                $description = $relato['description'];
                                                $beginningDate = $relato['beginningDate'];
                                                $formattedDate = date('d/m/Y H:i', strtotime($beginningDate));
                                                $person = $relato['person']['name']; ?>

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading<?= $id ?>">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $id ?>" aria-expanded="true" aria-controls="collapse<?= $id ?>">
                                                            <?= $formattedDate ?> - <?= $title ?> - <?= $person ?>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse<?= $id ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $id ?>" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <?php echo $description  ?>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        } ?>
                                    </div><!-- End Default Accordion Example -->

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

        <?php } else { ?>

            <main id="main" class="main">

                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 style="text-align: center; margin-top: 30px;" class="card-title">Integração com ERP Desativada</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </main>
<?php }
        require "../../includes/securityfooter.php";
    } else {
        require "../../acesso_negado.php";
        require "../../includes/securityfooter.php";
    }
} else {
    require "../../acesso_negado.php";
    require "../../includes/securityfooter.php";
}
