<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";
?>


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Competências</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">

                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-9"></div>
                                <div class="col-3">
                                    <div class="card">
                                        <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalNovaCompetencia">
                                            Nova Competência
                                        </button>
                                    </div>
                                </div>

                                <div class="modal fade" id="modalNovaCompetencia" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Nova Competência</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <form id="cadastraCompetencia" method="POST" class="row g-3">

                                                        <span id="msgCadastrarCompetencia"></span>

                                                        <div class="col-8">
                                                            <label for="competencia" class="form-label">Competência*</label>
                                                            <input id="competencia" name="competencia" class="form-control"></input>
                                                        </div>

                                                        <div class="col-12">
                                                            <label for="descricao" class="form-label">Descrição*</label>
                                                            <textarea rows="12" id="descricao" name="descricao" class="form-control" maxlength="500"></textarea>

                                                        </div>

                                                        <hr class="sidebar-divider">

                                                        <div class="text-center">
                                                            <input id="btnSalvar" name="btnSalvar" type="button" value="Salvar" class="btn btn-danger"></input>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="sidebar-divider">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" scope="col">Competência</th>
                                    <th style="text-align: center;" scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql_competencias =
                                    "SELECT
                                    c.id AS idCompetencia,
                                    c.competencia AS competencia,
                                    c.active AS activeID,
                                    CASE
                                        WHEN c.active = '1' THEN 'Ativo'
                                        WHEN c.active = '0' THEN 'Inativo'
                                    END AS active
                                FROM
                                    competencias AS c
                                ORDER BY
                                    c.competencia ASC    
                                    ";
                                $resultado = mysqli_query($mysqli, $sql_competencias) or die("Erro ao retornar dados");

                                while ($campos = $resultado->fetch_array()) {
                                    $id = $campos['idCompetencia'];
                                ?>
                                    <tr>

                                        <td style="text-align: center;">
                                            <a style="color: red;" href="view.php?id=<?= $id ?>"><?= $campos['competencia']; ?></a>
                                        </td>


                                        <td style="text-align: center;"><?= $campos['active']; ?></td>
                                    <?php } ?>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require "js.php";
require "../../includes/footer.php";
?>