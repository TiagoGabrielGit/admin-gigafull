<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];

$submenu_id = "36";

$permissions =
    "SELECT 
	u.perfil_id
FROM 
	usuarios u
JOIN 
	perfil_permissoes_submenu pp
ON 
	u.perfil_id = pp.perfil_id
WHERE
	u.id = $uid
AND 
	pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {


?>
    <style>
        #tabelaLista:hover {
            cursor: pointer;
            background-color: #E0FFFF;
        }
    </style>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Manutenções Programadas</h1>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <hr class="sidebar-divider">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <table class="table datatable" id="styleTable">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Titulo</th>
                                                                <th scope="col">Criador</th>
                                                                <th scope="col">Data Agendamento</th>
                                                                <th scope="col">Duração</th>
                                                                <th scope="col">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $lista_manutencoes =
                                                                "SELECT
                                                                mp.id as idManutencaoProgramada,
                                                                mp.titulo as titulo,
                                                                DATE_FORMAT(mp.dataAgendamento, '%d/%m/%Y %H:%i') as dataAgendamento,
                                                                mp.duracao as duracao,
                                                                p.nome as criador,
                                                                CASE
                                                                WHEN mp.active = 3 THEN 'Rascunho'
                                                                WHEN mp.active = 2 THEN 'Concluida'
                                                                WHEN mp.active = 1 THEN 'Programada'
                                                                WHEN mp.active = 0 THEN 'Cancelada'
                                                                END as status
                                                                FROM
                                                                manutencao_programada as mp
                                                                LEFT JOIN usuarios as u ON mp.usuario_criador = u.id
                                                                LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                                                                ORDER BY mp.dataAgendamento desc

                                                                ";
                                                            $r_manutencoes = mysqli_query($mysqli, $lista_manutencoes);
                                                            while ($c_manutencoes = $r_manutencoes->fetch_array()) {
                                                            ?>

                                                                <tr id="tabelaLista" onclick="location.href='view.php?id=<?= $c_manutencoes['idManutencaoProgramada'] ?>'">

                                                                    <td><?= $c_manutencoes['titulo']; ?></td>
                                                                    <td><?= $c_manutencoes['criador']; ?></td>

                                                                    <td><?= $c_manutencoes['dataAgendamento']; ?></td>
                                                                    <td><?= $c_manutencoes['duracao']; ?></td>
                                                                    <td><?= $c_manutencoes['status']; ?></td>
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
<?php
} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php"; ?>