<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "sql.php";
?>


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Tipos de chamados</h1>
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
                                        <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                            Novo tipo de chamado
                                        </button>
                                    </div>
                                </div>

                                <div class="modal fade" id="basicModal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Novo tipo</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <form id="cadastraTipoChamado" method="POST" class="row g-3 needs-validation">

                                                        <span id="msg"></span>

                                                        <div class="col-12">
                                                            <label for="tipoChamado" class="form-label">Tipo de chamado</label>
                                                            <input id="tipoChamado" name="tipoChamado" class="form-control" required></input>
                                                        </div>

                                                        <hr class="sidebar-divider">

                                                        <div class="text-center">
                                                            <input id="btnSalvar" name="btnSalvar" type="button" value="Salvar" class="btn btn-danger"></input>
                                                            <a href="/portal/tipos_chamados/index.php"> <input type="button" value="Voltar" class="btn btn-secondary"></input></a>
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
                                    <th style="text-align: center;" scope="col">Tipo de chamado</th>
                                    <th style="text-align: center;" scope="col">Ativo</th>
                                    <th style="text-align: center;" scope="col">Ativar / Inativar</th>
                                    <th style="text-align: center;" scope="col">Editar tipo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $resultado = mysqli_query($mysqli, $sql_lista_tipos_chamados) or die("Erro ao retornar dados");

                                while ($campos = $resultado->fetch_array()) {
                                    $id = $campos['id_tipo'];
                                    echo "<tr>";
                                ?>
                                    <td style="text-align: center;"><?php echo $campos['nome_tipo']; ?></td>
                                    <td style="text-align: center;"><?php echo $campos['ativo_tipo']; ?></td>
                                    <td style="text-align: center;">
                                        <?php
                                        if ($campos['ativo_tipo'] == "Ativado") {
                                            echo "<a href='processa/inativa.php?id=" . $campos['id_tipo'] . "' data-confirm='Tem certeza que deseja excluir permanentemente esse registro?'" . " class='bi bi-arrow-left-right' </a>";
                                        } else if ($campos['ativo_tipo'] == "Inativado") {
                                            echo "<a href='processa/ativa.php?id=" . $campos['id_tipo'] . "' data-confirm='Tem certeza que deseja excluir permanentemente esse registro?'" . " class='bi bi-arrow-left-right' </a>";
                                        }
                                        ?>
                                    </td>

                                    <td style="text-align: center;">
                                        <a onclick="capturaDadosLogin(<?= $campos['id_tipo'] ?>,'<?= $campos['nome_tipo'] ?>')" class="bi bi-pencil-fill" role="button" data-bs-toggle="modal" data-bs-target="#basicModalSenha"></a>
                                    </td>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>



<script>
    function capturaDadosLogin(id, tipo) {
        document.querySelector("#id").value = id;
        document.querySelector("#id_disable").value = id;
        document.querySelector("#tipo").value = tipo;
    }
</script>


<div class=" modal fade" id="basicModalSenha" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar tipo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <!-- Vertical Form -->
                    <form method="POST" action="/portal/tipos_chamados/processa/editar.php" class="row g-3 needs-validation" novalidate>

                        <div class="col-3">
                            <label for="id" class="form-label">ID</label>
                            <input type="text" name="id_disable" class="form-control" id="id_disable" disabled>
                            <input type="text" name="id" class="form-control" id="id" hidden>
                        </div>

                        <div class="col-9"></div>

                        <div class="col-8">
                            <label for="tipo" class="form-label">Tipo</label>
                            <input type="text" name="tipo" class="form-control" id="tipo">
                        </div>

                        <div class="col-12">
                            <button class="btn btn-danger w-100" type="submit">Editar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->



<?php
require "../../scripts/tipo_chamado.php";
require "../../includes/footer.php";
?>