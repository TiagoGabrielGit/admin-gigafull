<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao_pdo.php";
$uid = $_SESSION['id'];

$submenu_id = "44";

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
    <main class="main" id="main">
        <div class="pagetitle">
            <h1>Responsáveis Por Aceite</h1>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="text-left">
                        <h5 class="card-title"></h5>
                    </div>
                    <div class="text-end">
                        <button data-bs-toggle="modal" data-bs-target="#basicModal" class="btn btn-sm btn-danger">Criar Novo</button>
                    </div>


                    <table class="table datatable" id="styleTable">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $responsaveis =
                                "SELECT mpra.id as id, mpra.nome as name, mpra.email as email,
                            CASE
                            WHEN mpra.active = 1 THEN 'Ativo'
                            WHEN mpra.active = 0 THEN 'Inativo'
                            END as status
                            FROM manutencao_programada_responsaveis_aceite AS mpra
                            ORDER BY mpra.nome ASC";

                            $r_responsaveis = mysqli_query($mysqli, $responsaveis);
                            while ($c_responsaveis = $r_responsaveis->fetch_array()) {
                            ?>

                                <tr id="tabelaLista" onclick="location.href='view.php?id=<?= $c_responsaveis['id'] ?>'">

                                    <td><?= $c_responsaveis['name']; ?></td>
                                    <td><?= $c_responsaveis['email']; ?></td>
                                    <td><?= $c_responsaveis['status']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="basicModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Responsável de Aceite</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="card-body">
                        <form method="POST" action="processa/novo_responsavel.php">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label" for="nome">Nome</label>
                                    <input class="form-control" id="nome" name="nome" type="text" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="email">E-mail</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <hr class="sidebar-divider">

                            <div class="text-center">
                                <button type="submit" class="btn btn-sm btn-danger">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php"; ?>