<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$menu_id = "34";
$uid = $_SESSION['id'];
$permissions = "
    SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_menu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = :uid AND pp.url_menu = :menu_id
";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->bindParam(':uid', $uid, PDO::PARAM_INT);
$exec_permissions->bindParam(':menu_id', $menu_id, PDO::PARAM_STR);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {
    $empresa_id = $_SESSION['empresa_id'];
?>

    <style>
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
    </style>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>MEUS PLANOS</h1>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr style="text-align: center;">
                                                    <th scope="col">Contrato ID</th>
                                                    <th scope="col">Serviço</th>
                                                    <th scope="col">Tipo de Cobrança</th>
                                                    <th scope="col">Valor</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $sql_contract_service = "
                                                    SELECT
                                                    c.id as contrato_id,
                                                        cs.id as idCS,
                                                        cs.active as activeIDCS,
                                                        CASE
                                                            WHEN cs.active = 1 THEN 'Ativo'
                                                            WHEN cs.active = 0 THEN 'Inativo'
                                                        END as activeCS,
                                                        s.service as service,
                                                        CASE
                                                            WHEN cs.tipo_cobranca = 1 THEN 'Isento'
                                                            WHEN cs.tipo_cobranca = 2 THEN 'Recorrente Mensal'
                                                            WHEN cs.tipo_cobranca = 3 THEN 'Hora Trabalhada'
                                                            WHEN cs.tipo_cobranca = 4 THEN 'Fixo + Hora Excedente'
                                                        END as tipo_cobranca,
                                                        CASE
                                                            WHEN cs.tipo_cobranca = 1 THEN ' - '
                                                            WHEN cs.tipo_cobranca = 2 THEN cs.valor_mensal
                                                            WHEN cs.tipo_cobranca = 3 THEN cs.valor_hora
                                                            WHEN cs.tipo_cobranca = 4 THEN CONCAT('R$ ', cs.valor_fixo, ' / Limite: ', cs.horas_inclusas, ' horas + R$ ', cs.valor_hora_excedente, ' por hora adicional')
                                                        END as valor_cobranca,
                                                        cs.valor_fixo,
                                                        cs.horas_inclusas,
                                                        cs.valor_hora_excedente
                                                    FROM contract_service as cs
                                                    LEFT JOIN service as s ON s.id = cs.service_id
                                                    LEFT JOIN contract as c ON c.id = cs.contract_id
                                                    WHERE c.empresa_id = $empresa_id
                                                ";

                                                $r_contract_service = mysqli_query($mysqli, $sql_contract_service);
                                                while ($c_contract_service = $r_contract_service->fetch_array()) {
                                                    // Inicializa as variáveis com valores padrão
                                                    $valor_fixo = isset($c_contract_service['valor_fixo']) ? (float) $c_contract_service['valor_fixo'] : 0.0;
                                                    $horas_inclusas = isset($c_contract_service['horas_inclusas']) ? (float) $c_contract_service['horas_inclusas'] : 0.0;
                                                    $valor_hora_excedente = isset($c_contract_service['valor_hora_excedente']) ? (float) $c_contract_service['valor_hora_excedente'] : 0.0;
                                                    $horas_usadas = 250; // Exemplo: valor fixo de horas usadas

                                                    if ($c_contract_service['tipo_cobranca'] == 'Fixo + Hora Excedente') {
                                                        $custo_total = $valor_fixo;
                                                        if ($horas_usadas > $horas_inclusas) {
                                                            $horas_excedentes = $horas_usadas - $horas_inclusas;
                                                            $custo_total += $horas_excedentes * $valor_hora_excedente;
                                                        }
                                                        $valor_cobranca = $c_contract_service['valor_cobranca'];
                                                    } else {
                                                        // Verifica se 'valor_cobranca' está numérico antes de formatar
                                                        $valor_cobranca = is_numeric($c_contract_service['valor_cobranca']) ?
                                                            'R$ ' . number_format((float)$c_contract_service['valor_cobranca'], 2, ',', '.') :
                                                            $c_contract_service['valor_cobranca'];
                                                    }
                                                ?>

                                                    <tr style="vertical-align: middle; text-align: center;">

                                                        <td><?= $c_contract_service['contrato_id']; ?></td>
                                                        <td><?= $c_contract_service['service']; ?></td>
                                                        <td><?= $c_contract_service['tipo_cobranca']; ?></td>
                                                        <td><?= $valor_cobranca; ?></td>
                                                        <td><?= $c_contract_service['activeCS']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>

                                        <div class="modal fade" id="modalAdicionarService" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Adicionar Serviço ao Contrato</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="card-body">
                                                            <form action="processa/adiciona_contrato_servico.php" method="POST" class="row g-3">
                                                                <input hidden id="serviceContratoID" name="serviceContratoID" value="<?= $c_contrato['idContrato']; ?>"></input>

                                                                <div class="row">
                                                                    <div class="col-5">
                                                                        <div class="col-12">
                                                                            <label for="serviceContract" class="form-label">Serviços</label>
                                                                            <select id="serviceContract" name="serviceContract" class="form-select" required>
                                                                                <option selected disabled value="">Selecione</option>

                                                                                <?php
                                                                                $sql_services = "
                                                                                    SELECT
                                                                                        s.id as idServico,
                                                                                        s.service as service,
                                                                                        s.description as description
                                                                                    FROM service as s
                                                                                    WHERE s.active = 1
                                                                                    ORDER BY s.service ASC
                                                                                ";

                                                                                $r_services = mysqli_query($mysqli, $sql_services);
                                                                                while ($c_services = mysqli_fetch_object($r_services)) {
                                                                                    echo "<option value='$c_services->idServico'> $c_services->service</option>";
                                                                                }
                                                                                ?>

                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-3"></div>

                                                                </div>

                                                                <hr class="sidebar-divider">

                                                                <div class="text-center">
                                                                    <button type="submit" class="btn btn-sm btn-danger">Adicionar Serviço ao Contrato</button>
                                                                </div>
                                                            </form><!-- End Horizontal Form -->
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
                </div>
            </div>
        </section>
    </main>

<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}

require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>