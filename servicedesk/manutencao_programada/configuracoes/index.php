<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <h5 class="card-title">Card Manutenção Programada</h5>
                    </div>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr style="text-align: center;">
                            <th>Empresa</th>
                            <th>Visivel</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $empresas =
                            "SELECT 
                            e.id as empresa_id,
            e.fantasia,
            CASE WHEN mpe.empresa_id IS NOT NULL THEN 'SIM' ELSE 'NÃO' END AS visivel
         FROM empresas as e 
         LEFT JOIN manutencao_programada_empresas as mpe ON e.id = mpe.empresa_id
         WHERE e.deleted = 1 
         ORDER BY e.fantasia ASC";

                        $stmt = $pdo->prepare($empresas);
                        $stmt->execute();

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                            <tr style="vertical-align: middle; text-align: center;">
                                <td><?= $row['fantasia'] ?></td>
                                <td><?= $row['visivel'] ?></td>
                                <td> <?php if ($row['visivel'] == 'SIM') { ?>
                                        <a href="processa/remover.php?id=<?= $row['empresa_id'] ?>">
                                            <button class="btn btn-danger btn-sm">Remover</button>
                                        </a>
                                    <?php } else { ?>
                                        <a href="processa/adicionar.php?id=<?= $row['empresa_id'] ?>">
                                            <button class="btn btn-success btn-sm">Adicionar</button>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>


            </div>
        </div>
    </section>
</main>
<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');

?>