<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$uid = $_SESSION['id'];
$submenu_id = "59";

$permissions = "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp
ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {


    $afericao_id = $_GET['id'];

    $consulta_Afericao = "
        SELECT 
            a.id,
            a.chamado_id,
            a.solicitante_id,
            a.empresa_id,
            a.cto_id,
            a.olt_id,
            a.crm_pre_afericao,
            a.crm_pos_afericao,
            a.texto_inicial as relato_inicial,
            a.relato,
            a.status,
            a.created AS data_criacao,
            c.assuntoChamado AS chamado_titulo,
            p.nome AS nome_solicitante,
            p2.nome AS nome_atendente,
            e.fantasia AS empresa_fantasia,
            gc.title AS cto,
            gc.id as cto_id,
            go.olt_name AS olt,
            gc.nbintegration_code as integration_code
        FROM afericao AS a
        LEFT JOIN chamados AS c ON c.id = a.chamado_id
        LEFT JOIN usuarios AS u ON u.id = a.solicitante_id
        LEFT JOIN pessoas AS p ON p.id = u.pessoa_id
        LEFT JOIN usuarios AS u2 ON u2.id = c.atendente_id
        LEFT JOIN pessoas AS p2 ON p2.id = u2.pessoa_id
        LEFT JOIN empresas AS e ON a.empresa_id = e.id
        LEFT JOIN gpon_ctos AS gc ON gc.id = a.cto_id
        LEFT JOIN gpon_olts AS go ON go.id = a.olt_id
        WHERE a.id = :id";

    // Preparando a consulta
    $stmt = $pdo->prepare($consulta_Afericao);

    // Executando a consulta com o parâmetro fornecido
    $stmt->execute(array(':id' => $afericao_id));

    // Obtendo o resultado da consulta
    $detalhes_afericao = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificando se os dados foram encontrados
    if ($detalhes_afericao) {
        $olt = $detalhes_afericao['olt'];
        $cto = $detalhes_afericao['cto'];
        $cto_id = $detalhes_afericao['cto_id'];
        $relato_inicial = $detalhes_afericao['relato_inicial'];
        $crm_pre_afericao = $detalhes_afericao['crm_pre_afericao'];
        $crm_pos_afericao = $detalhes_afericao['crm_pos_afericao'];
        $status = $detalhes_afericao['status'];
        $relato = $detalhes_afericao['relato'];
        $integration_code = $detalhes_afericao['integration_code'];
        $nome_solicitante = $detalhes_afericao['nome_solicitante'];
        $empresa_solicitante = $detalhes_afericao['empresa_fantasia'];
        $nome_atendente = $detalhes_afericao['nome_atendente'];
        $chamado_id = $detalhes_afericao['chamado_id'];
    } else {
        // Caso não encontre a aferição, exibe uma mensagem
        echo "Aferição não encontrada.";
        exit;
    }
?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>AFERIÇÃO - <?= $afericao_id ?></h1>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informações Afericão</h5>

                    <div class="row">
                        <div class="col-lg-10">
                            <div class="row">

                                <div class="col-5">
                                    <label for="solicitante" class="form-label">Solicitante</label>
                                    <input readonly class="form-control" value="<?= $nome_solicitante . ' - (' . $empresa_solicitante . ')' ?>"></input>
                                </div>

                                <div class="col-5">
                                    <label for="atendente" class="form-label">Atendente</label>
                                    <input readonly class="form-control" value="<?= $nome_atendente ?>"></input>
                                </div>

                                <div class="col-2">
                                    <label for="chamado_id" class="form-label">Chamado</label>
                                    <input readonly class="form-control" value="<?= $chamado_id ?>"></input>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <a href="/rede/afericao/index.php" class="d-flex">
                                        <button class="btn btn-sm btn-danger w-100">Listagem Aferições</button>
                                    </a>
                                </div>
                                <div class="col-12">
                                    <a href="/servicedesk/chamados/visualizar_chamado.php?id=<?= $chamado_id ?>" class="d-flex">
                                        <button class="btn btn-sm btn-warning w-100">Acessar Chamado</button>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <?php
            if ($status == 1) { ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Alterar CTO</h5>

                        <?php
                        if (isset($_GET['return'])) { ?>
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <?= $_GET['return'] ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>

                        <?php }
                        ?>
                        <div class="row">
                            <div class="col-lg-10">
                                <form method="POST" action="update_afericao.php">
                                    <input hidden readonly id="id_afericao" name="id_afericao" value="<?= $afericao_id ?>">
                                    <input hidden readonly id="texto_inicial" name="texto_inicial" value="<?= $relato_inicial ?>">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="olt" class="form-label">OLT</label>
                                            <select required id="olt" name="olt" class="form-select">
                                                <?php
                                                // Consulta SQL para buscar as OLTs ativas
                                                $busca_olts = "SELECT * FROM gpon_olts WHERE active = 1";
                                                $stmt = $pdo->prepare($busca_olts);
                                                $stmt->execute();

                                                // Iterar pelos resultados e preencher o select
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    // Verificar se esta é a OLT selecionada na aferição
                                                    $selected = ($row['id'] == $detalhes_afericao['olt_id']) ? 'selected' : '';
                                                    echo "<option value='" . htmlspecialchars($row['id']) . "' $selected>" . htmlspecialchars($row['olt_name']) . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-3">
                                            <label for="cto" class="form-label">CTO</label>
                                            <input hidden readonly id="cto_id" name="cto_id" value="<?= $cto_id ?>">
                                            <input hidden readonly id="integration_code" name="integration_code" value="<?= $integration_code ?>">
                                            <input id="cto" name="cto" class="form-control" value="<?= $cto ?>">
                                        </div>

                                        <div class="col-3">
                                            <button style="margin-top: 32px;" type="submit" class="btn btn-sm btn-danger">Alterar CTO</button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Atualizar Aferição</h5>
                        <form method="POST" action="processa/status_afericao.php">
                        <input readonly hidden id="afericao_id" name="afericao_id" value="<?= $afericao_id ?>"></input>

                            <input id="chamado_id_update_status" name="chamado_id_update_status" hidden readonly value="<?= $chamado_id ?>">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="col-12">
                                        <textarea placeholder="Digite um relato" class="form-control" rows="2" style="resize: none;" id="relato_status" name="relato_status" required><?= $relato ?></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="col-12">
                                        <select class="form-select" name="status_afericao" id="status_afericao">
                                            <option value="1" <?php if ($status == 1) echo "selected"; ?>>Em análise</option>
                                            <option value="2" <?php if ($status == 2) echo "selected"; ?>>Negada</option>
                                            <option value="3" <?php if ($status == 3) echo "selected"; ?>>Realizada</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <button style="margin-top: 15px;" class="btn btn-sm btn-danger">Alterar Status</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } else { ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Relato e Classificação</h5>
                        <input id="chamado_id_update_status" name="chamado_id_update_status" hidden readonly value="<?= $chamado_id ?>">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="col-12">
                                    <textarea readonly placeholder="Digite um relato" class="form-control" rows="2" style="resize: none;" id="relato_status" name="relato_status" required><?= $relato ?></textarea>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="col-6">
                                    <?php
                                    if ($status == 1) {
                                        $status_Afericao = "Em análise";
                                    } else if ($status == 2) {
                                        $status_Afericao = "Negada";
                                    } else if ($status == 3) {
                                        $status_Afericao = "Realizada";
                                    }
                                    ?>

                                    <input readonly class="form-control" value="<?= $status_Afericao ?>"></input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informações Adicionais</h5>
                    <?php
                    if ($status == 1) { ?>

                        <div class="col-lg-12 d-flex justify-content-end">
                            <form method="POST" action="processa/ler_dados_cto_erp.php">
                                <input readonly hidden id="afericao_id" name="afericao_id" value="<?= $afericao_id ?>"></input>

                                <input readonly hidden id="cto_id" name="cto_id" value="<?= $cto_id ?>"></input>
                                <input readonly hidden id="chamado_id_cto" name="chamado_id_cto" value="<?= $chamado_id ?>"></input>
                                <button style="margin-bottom: 15px;" class="btn btn-sm btn-warning">Ler dados no ERP</button>
                            </form>
                        </div>
                    <?php } ?>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body" style="height: 700px; overflow-y: auto;">
                                        <br>
                                        <div>
                                            <strong>Relato Abertura</strong>
                                        </div>

                                        <br>
                                        <div>
                                            <?php echo nl2br($relato_inicial); ?>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body" style="height: 700px; overflow-y: auto;">
                                        <br>
                                        <div>
                                            <strong>Informações obtidas através do ERP - Antes Aferição</strong>
                                        </div>

                                        <br>
                                        <div>
                                            <?php echo nl2br($crm_pre_afericao); ?>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body" style="height: 700px; overflow-y: auto;">
                                        <br>
                                        <div>
                                            <strong>Informações obtidas através do ERP - Depois Aferição</strong>
                                        </div>

                                        <br>
                                        <div>
                                            <?php echo nl2br($crm_pos_afericao); ?>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

    <script>
        $(document).ready(function() {
            $('#cto').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: 'buscar_ctos.php',
                        dataType: 'json',
                        data: {
                            term: request.term,
                            olt_id: $('#olt').val() // Enviar o ID da OLT selecionada
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 2, // Número mínimo de caracteres antes de começar a busca
                select: function(event, ui) {
                    // Atualizar o valor do input oculto com o ID do CTO selecionado
                    $('#cto_id').val(ui.item.id_cto);
                    $('#integration_code').val(ui.item.integration_code);

                }

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#olt').change(function() {
                $('#cto').val(''); // Limpar campo CTO ao mudar a OLT
            });
        });
    </script>

<?php } else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>