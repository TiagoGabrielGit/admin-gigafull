<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$submenu_id = "57";
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
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="text-left">
                                    <h5 class="card-title">REUNIÕES</h5>
                                </div>
                            </div>
                            <div class="row">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;" scope="col">Inicio</th>
                                            <th style="text-align: center;" scope="col">Assunto</th>
                                            <th style="text-align: center;" scope="col">Criador</th>
                                            <th style="text-align: center;" scope="col">Status</th>
                                            <th></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $consulta =
                                            "SELECT 
                                            ar.id as id, 
                                            DATE_FORMAT(ar.inicio, '%d/%m/%Y %H:%i') AS inicio, 
                                            ar.fim as fim, 
                                            ar.assunto,
                                            ar.criador as criador_id,
                                            p.nome as criador,
                                            CASE
                                            WHEN ar.status = 1 THEN 'Agendado'
                                            WHEN ar.status = 2 THEN 'Realizada'
                                            WHEN ar.status = 3 THEN 'Cancelada'
                                            END as status
                                        FROM ata_reuniao as ar
                                        LEFT JOIN usuarios as u ON u.id = ar.criador
                                        LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                                        LEFT JOIN ata_reuniao_acesso as ara ON ara.id_reuniao = ar.id AND ara.id_usuario = :uid AND ara.active = 1
                                        WHERE ar.criador = :uid OR ara.id_usuario IS NOT NULL
                                        ORDER BY status ASC, inicio ASC
                                        LIMIT 100";
                                        $stmt = $pdo->prepare($consulta);
                                        $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);

                                        $stmt->execute();

                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $row['inicio'] ?></td>
                                                    <td style="text-align: center;"><?= $row['assunto']; ?></td>
                                                    <td style="text-align: center;"><?= $row['criador'] ?></td>
                                                    <td style="text-align: center;"><?= $row['status'] ?></td>
                                                    <td><a href="view.php?id=<?= $row['id']; ?>"><button class="btn btn-sm btn-danger">Visualizar</button></a></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                    </tbody>
                                </table>
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