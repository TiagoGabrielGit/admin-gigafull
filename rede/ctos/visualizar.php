<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];

$submenu_id = "48";

$permissions = "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp
ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {

    $id = $_GET['id'];
?>
    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="text-left">
                            <h5 class="card-title">AFERIÇÕES REALIZADAS</h5>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href = '/rede/ctos/index.php';">Voltar</button>
                        </div>
                    </div>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Chamado</th>

                                <th style="text-align: center;">Solicitante</th>
                                <th style="text-align: center;">Empresa</th>
                                <th style="text-align: center;">Data</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query_afericoes =
                                "SELECT a.id, p.nome, DATE_FORMAT(a.created, '%d/%m/%Y %H:%i') AS data_formatada, e.fantasia, a.chamado_id,

                                CASE
                                WHEN a.status = 1 THEN 'Em analise'
                                WHEN a.status = 2 THEN 'Negada'
                                WHEN a.status = 3 THEN 'Realizada'
                                END as status
                            FROM afericao as a
                            LEFT JOIN usuarios as u ON u.id = a.solicitante_id
                            LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                            LEFT JOIN empresas as e ON u.empresa_id = e.id
                            WHERE a.cto_id = :id
                            ORDER BY a.chamado_id DESC";
                            $stmt_afericoes = $pdo->prepare($query_afericoes);
                            $stmt_afericoes->bindParam(':id', $id);
                            $stmt_afericoes->execute();
                            while ($afericao = $stmt_afericoes->fetch(PDO::FETCH_ASSOC)) :
                                $afericao_id = $afericao['id'];
                            ?>

                                <tr>
                                    <td style="text-align: center;"><?= $afericao['chamado_id']; ?></td>

                                    <td style="text-align: center;"><?= $afericao['nome']; ?></td>
                                    <td style="text-align: center;"><?= $afericao['fantasia']; ?></td>

                                    <td style="text-align: center;"><?= $afericao['data_formatada']; ?></td>
                                    <td style="text-align: center;"><?= $afericao['status']; ?></td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#afericaoModal<?= $afericao_id ?>">
                                            Detalhes
                                        </button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="afericaoModal<?= $afericao_id ?>" tabindex="-1" aria-labelledby="afericaoModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-fullscreen">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><b>INFORMAÇÕES DA AFERIÇÃO</b></h5>

                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>


                                            <div class="modal-body">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <?php
                                                        $query_afericao = "SELECT * 
                                                        FROM afericao as a 
                                                        LEFT JOIN chamados as c ON c.id = a.chamado_id 
                                                        WHERE a.id = :afericao_id";

                                                        $stmt = $pdo->prepare($query_afericao);
                                                        $stmt->execute(array(':afericao_id' => $afericao_id));
                                                        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($resultados as $row) {
                                                            $cto_id = $row['cto_id'];

                                                            $relato_inicial = $row['relato_inicial'];
                                                            $crm_pre_afericao = $row['crm_pre_afericao'];
                                                            $crm_pos_afericao = $row['crm_pos_afericao'];
                                                            $status = $row['status'];
                                                            $relato = $row['relato'];
                                                            $chamado_id = $row['chamado_id'];
                                                        }
                                                        ?>

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
                                                                <div class="card-body" style="height: 500px; overflow-y: auto;">
                                                                    <br>

                                                                    <div class="col-12">
                                                                        <strong>Informações obtidas através do ERP - Depois Aferição</strong>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <!-- Conteúdo do ERP -->
                                                                            <?php echo nl2br($crm_pos_afericao); ?>
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                </div>


                                                                <div class="card-body" style="height: 200px; overflow-y: auto;">
                                                                    <br>
                                                                    <div>

                                                                        <?php if ($status == 1) {

                                                                            if (!empty($crm_pos_afericao)) {

                                                                        ?>
                                                                            <?php } else { ?>
                                                                                <div class="col-12 text-center">
                                                                                    <span><b><i> Realize primeiro a leitura de dados no ERP antes de alterar o status.</i></b></span>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>

                                                                            <div class="col-12">
                                                                                <span>Status:
                                                                                    <?php
                                                                                    if ($status == 2) {
                                                                                        echo "Negada";
                                                                                    } elseif ($status == 3) {
                                                                                        echo "Realizada";
                                                                                    }
                                                                                    ?>
                                                                                </span>

                                                                                <div class="col-12">

                                                                                    <span> <textarea class="form-control" disabled rows="5" style="resize: none;"><?php echo nl2br($relato); ?></textarea>
                                                                                    </span>
                                                                                </div>

                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <a href="/rede/ctos/anexos.php?id=<?= $chamado_id ?>" class="btn btn-sm btn-info" target="_blank">Anexos</a>

                                                <a href="/servicedesk/consultar_chamados/view.php?id=<?= $chamado_id ?>" class="btn btn-sm btn-warning" target="_blank">Ir para o chamado</a>

                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </section>
    </main>

<?php
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>