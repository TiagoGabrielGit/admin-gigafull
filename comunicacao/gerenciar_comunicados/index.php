<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "39";
$uid = $_SESSION['id'];

$permissions_submenu =
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
            <h1>Gerenciar Comunicações</h1>
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
                                                    <table class="table datatable">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">ID</th>
                                                                <th scope="col">Criador</th>
                                                                <th scope="col">Origem</th>
                                                                <th scope="col">Origem ID</th>
                                                                <th scope="col">Criada</th>
                                                                <th scope="col">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $lista_comunicacoes =
                                                                "SELECT
                                                                c.id as id,
                                                                p.nome as nome,
                                                                c.origem_id as origem_id,
                                                                CASE
                                                                WHEN c.origem = 1 THEN 'Incidentes'
                                                                WHEN c.origem = 2 THEN 'Manutenção Programada'
                                                                WHEN c.origem = 3 THEN 'Manual'
                                                                END as origem,
                                                                DATE_FORMAT(created, '%d/%m/%Y %H:%i:%s') AS created,
                                                                CASE
                                                                WHEN status = 0 THEN 'Cancelada'
                                                                WHEN status = 1 THEN 'Rascunho'
                                                                WHEN status = 2 THEN 'Enviada'
                                                                END as status
                                                                FROM comunicacao as c
                                                                LEFT JOIN usuarios as u ON u.id = c.usuario_criador
                                                                LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                                                                ORDER BY id desc
                                                                ";
                                                            $r_comunicacoes = mysqli_query($mysqli, $lista_comunicacoes);
                                                            while ($c_comunicacoes = $r_comunicacoes->fetch_array()) {
                                                            ?>
                                                                <tr id="tabelaLista" onclick="location.href='view_comunicacao.php?id=<?= $c_comunicacoes['id'] ?>'">

                                                                    <td><?= $c_comunicacoes['id']; ?></td>
                                                                    <td><?= $c_comunicacoes['nome']; ?></td>
                                                                    <td><?= $c_comunicacoes['origem']; ?></td>
                                                                    <td><?= $c_comunicacoes['origem_id']; ?></td>
                                                                    <td><?= $c_comunicacoes['created']; ?></td>
                                                                    <td><?= $c_comunicacoes['status']; ?></td>

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
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>