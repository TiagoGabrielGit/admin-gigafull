<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao.php";
require "sql.php";
?>

<style>
    #tabelaLista:hover {
        cursor: pointer;
        background-color: #E0FFFF;
    }
</style>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Produtos</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">

                    <div class="card-body">

                        <div class="container">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="card-title">Cadastro de Produtos</h5>
                                </div>
                                <div class="col-2"></div>
                                <div class="col-2">
                                    <div class="card">
                                        <!-- Basic Modal -->
                                        <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                            Novo Produto
                                        </button>
                                    </div>
                                </div>
                                <div class="modal fade" id="basicModal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Novo Produto</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <!-- Vertical Form -->
                                                    <form method="POST" action="processa/add.php" class="row g-3">
                                                        <div class="col-12">
                                                            <label for="inputEquipamento" class="form-label">Equipamento</label>
                                                            <input name="equipamento" type="text" class="form-control" id="inputEquipamento" required>
                                                        </div>

                                                        <div class="col-6">
                                                            <label for="inputFabricante" class="form-label">Fabricante</label>
                                                            <select name="fabricante" class="form-select" required>
                                                                <option selected disabled>Selecione</option>
                                                                <?php
                                                                $resultado = mysqli_query($mysqli, $sql_fabricante) or die("Erro ao retornar dados");
                                                                while ($c = $resultado->fetch_assoc()) : ?>
                                                                    <option value="<?= $c['id']; ?>"><?= $c['fabricante']; ?></option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-6">
                                                            <label for="equipamentoRack" class="form-label">Equipamento de rack</label>
                                                            <select id="equipamentoRack" name="equipamentoRack" class="form-select" required>
                                                                <option value="0">Não</option>
                                                                <option value="1">Sim</option>
                                                            </select>
                                                        </div>

                                                        <div id="inputTamanhoDiv" class="col-6">
                                                            <label for="inputTamanho" class="form-label">Tamanho</label>
                                                            <select name="inputTamanho" class="form-select">
                                                                <option selected disabled>Selecione</option>
                                                                <option value="1">1U</option>
                                                                <option value="2">2U's</option>
                                                                <option value="3">3U's</option>
                                                                <option value="4">4U's</option>
                                                                <option value="5">5U's</option>
                                                                <option value="6">6U's</option>
                                                                <option value="7">7U's</option>
                                                                <option value="8">8U's</option>
                                                                <option value="9">9U's</option>
                                                                <option value="10">10u's</option>
                                                                <option value="11">11u's</option>
                                                            </select>
                                                        </div>

                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-danger">Salvar</button>
                                                            <button type="reset" class="btn btn-secondary">Limpar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End Basic Modal-->

                            </div>

                        </div>

                        <p>Listagem de equipamentos</p>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped"> 
                            <thead>
                                <tr>
                                    <th scope="col">Equipamento</th>
                                    <th scope="col">Tamanho (U)</th>
                                    <th scope="col">Fabricante</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Preenchendo a tabela com os dados do banco: -->
                                <?php

                                $resultado = mysqli_query($mysqli, $sql_equipamentos) or die("Erro ao retornar dados");

                                // Obtendo os dados por meio de um loop while
                                while ($campos = $resultado->fetch_array()) {
                                    $id = $campos['id']; ?>
                                    <tr id="tabelaLista" onclick="location.href='view.php?id=<?= $campos['id'] ?>'">
                                        <td><?= $campos['equipamento']; ?></td>
                                        <td><?= $campos['tamanho']; ?></td>
                                        <td><?= $campos['fabricante']; ?></td>
                                    </tr>
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
require "../../../scripts/produtos.php";
require "../../../includes/footer.php";
?>