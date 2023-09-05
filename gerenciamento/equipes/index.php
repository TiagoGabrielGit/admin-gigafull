<?php
require "../../includes/menu.php";
require "sql.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "16";
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

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Equipes</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="card-title">Cadastro de Equipes</h5>
                                    </div>
                                    <div class="col-2"></div>
                                    <div class="col-2">
                                        <div class="card">
                                            <!-- Basic Modal -->
                                            <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                                Nova Equipe
                                            </button>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="basicModal" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Novo cadastro</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <!-- Vertical Form -->
                                                        <form method="POST" action="processa/add.php" class="row g-3">

                                                            <span id="msg"></span>

                                                            <div class="col-8">
                                                                <label for="equipe" class="form-label">Equipe*</label>
                                                                <input name="equipe" type="text" class="form-control" id="equipe" required>
                                                            </div>

                                                            <hr class="sidebar-divider">

                                                            <div class="text-center">
                                                                <button type="submit" class="btn btn-danger">Salvar</button>
                                                                <a href="/gerenciamento/equipes/index.php"> <input type="button" value="Voltar" class="btn btn-secondary"></input></a>
                                                            </div>
                                                        </form><!-- Vertical Form -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End Basic Modal-->

                                </div>
                            </div>

                            <hr class="sidebar-divider">

                            <style>
                                #tabelaLista:hover {
                                    cursor: pointer;
                                    background-color: #E0FFFF;
                                }
                            </style>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="text-align: left;" scope="col">Equipe</th>
                                        <th style="text-align: center;" scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Preenchendo a tabela com os dados do banco: -->
                                    <?php
                                    $resultado = mysqli_query($mysqli, $sql_pesquisa_equipes) or die("Erro ao retornar dados");

                                    // Obtendo os dados por meio de um loop while
                                    while ($campos = $resultado->fetch_array()) {
                                        $id = $campos['id_equipe']; ?>

                                        <tr id="tabelaLista" onclick="location.href='view.php?id=<?= $campos['id_equipe']; ?>'">
                                            </td>
                                            <td style="text-align: left;"><?= $campos['equipe']; ?></td>
                                            <td style="text-align: center;"><?= $campos['active']; ?></td>
                                        <?php } ?>
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

<?php

} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>