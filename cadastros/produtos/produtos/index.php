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
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h5 class="card-title">Cadastro de Produtos</h5>
                                </div>

                                <div class="col-lg-4">
                                    <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                        Novo Produto
                                    </button>
                                </div>
                            </div>
                        </div>

                        <h5 class="card-title">Listagem Produtos</h5>

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="bateria-tab" data-bs-toggle="tab" data-bs-target="#bateria" type="button" role="tab" aria-controls="bateria" aria-selected="true">Bateria</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="componentes-tab" data-bs-toggle="tab" data-bs-target="#componentes" type="button" role="tab" aria-controls="componentes" aria-selected="false">Componentes</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="equipamentos-tab" data-bs-toggle="tab" data-bs-target="#equipamentos" type="button" role="tab" aria-controls="equipamentos" aria-selected="false">Equipamentos</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="transceiver-tab" data-bs-toggle="tab" data-bs-target="#transceiver" type="button" role="tab" aria-controls="transceiver" aria-selected="false">Transceiver</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="bateria" role="tabpanel" aria-labelledby="bateria-tab">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Fabricante</th>
                                            <th scope="col">Modelo</th>
                                            <th scope="col">Tensão</th>
                                            <th scope="col">Amperagem</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Preenchendo a tabela com os dados do banco: -->
                                        <?php

                                        $r_baterias = mysqli_query($mysqli, $sql_baterias) or die("Erro ao retornar dados");

                                        // Obtendo os dados por meio de um loop while
                                        while ($c_baterias = $r_baterias->fetch_array()) {
                                            $id = $c_baterias['id']; ?>
                                            <tr id="tabelaLista" onclick="location.href='view_baterias.php?id=<?= $c_baterias['id'] ?>'">
                                                <td><?= $c_baterias['fabricante']; ?></td>
                                                <td><?= $c_baterias['modelo']; ?></td>
                                                <td><?= $c_baterias['tensao']; ?>v</td>
                                                <td><?= $c_baterias['amperagem']; ?>Ah</td>
                                                <td><?= $c_baterias['active']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="componentes" role="tabpanel" aria-labelledby="componentes-tab">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Fabricante</th>
                                            <th scope="col">Modelo</th>
                                            <th scope="col">Descrição</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Preenchendo a tabela com os dados do banco: -->
                                        <?php

                                        $r_componentes = mysqli_query($mysqli, $sql_componentes) or die("Erro ao retornar dados");

                                        // Obtendo os dados por meio de um loop while
                                        while ($c_componentes = $r_componentes->fetch_array()) {
                                            $id = $c_componentes['id']; ?>
                                            <tr id="tabelaLista" onclick="location.href='view_componentes.php?id=<?= $c_componentes['id'] ?>'">
                                                <td><?= $c_componentes['fabricante']; ?></td>
                                                <td><?= $c_componentes['modelo']; ?></td>
                                                <td><?= $c_componentes['descricao']; ?>v</td>
                                                <td><?= $c_componentes['active']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="equipamentos" role="tabpanel" aria-labelledby="equipamentos-tab">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Fabricante</th>
                                            <th scope="col">Modelo</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Preenchendo a tabela com os dados do banco: -->
                                        <?php

                                        $resultado = mysqli_query($mysqli, $sql_equipamentos) or die("Erro ao retornar dados");

                                        // Obtendo os dados por meio de um loop while
                                        while ($campos = $resultado->fetch_array()) {
                                            $id = $campos['id']; ?>
                                            <tr id="tabelaLista" onclick="location.href='view_equipamentos.php?id=<?= $campos['id'] ?>'">
                                                <td><?= $campos['fabricante']; ?></td>
                                                <td><?= $campos['equipamento']; ?></td>
                                                <td><?= $campos['deleted']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="transceiver" role="tabpanel" aria-labelledby="transceiver-tab">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Fabricante</th>
                                            <th scope="col">Modelo</th>
                                            <th scope="col">Descrição</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Preenchendo a tabela com os dados do banco: -->
                                        <?php

                                        $r_transceiver = mysqli_query($mysqli, $sql_transceiver) or die("Erro ao retornar dados");

                                        // Obtendo os dados por meio de um loop while
                                        while ($c_transceiver = $r_transceiver->fetch_array()) {
                                            $id = $c_transceiver['id']; ?>
                                            <tr id="tabelaLista" onclick="location.href='view_transceiver.php?id=<?= $c_transceiver['id'] ?>'">
                                                <td><?= $c_transceiver['fabricante']; ?></td>
                                                <td><?= $c_transceiver['modelo']; ?></td>
                                                <td><?= $c_transceiver['descricao']; ?>v</td>
                                                <td><?= $c_transceiver['active']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- End Default Tabs -->

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


<div class="modal fade" id="basicModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="col-12 text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gridRadios" id="gridBateria" value="option1">
                            <label class="form-check-label" for="gridBateria">Bateria</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gridRadios" id="gridComponente" value="option2">
                            <label class="form-check-label" for="gridComponente">Componentes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gridRadios" id="gridEquipamento" value="option3">
                            <label class="form-check-label" for="gridEquipamento">Equipamentos</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gridRadios" id="gridTransceiver" value="option4">
                            <label class="form-check-label" for="gridTransceiver">Transceiver</label>
                        </div>
                    </div>
                </div>

                <div id="componentesForm" style="display: none;">
                    <form method="POST" action="processa/add_componentes.php">
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
                        <div class="row">
                            <div class="col-6">
                                <label for="modeloComponente" class="form-label">Modelo</label>
                                <input name="modeloComponente" type="text" class="form-control" id="modeloComponente">
                            </div>

                            <div class="col-6">
                                <label for="descricaoComponente" class="form-label">Descrição</label>
                                <input name="descricaoComponente" type="text" class="form-control" id="descricaoComponente">
                            </div>
                        </div>

                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger">Salvar</button>
                            <button type="reset" class="btn btn-secondary">Limpar</button>
                        </div>
                    </form>
                </div>

                <div id="transceiverForm" style="display: none;">
                    <form method="POST" action="processa/add_transceiver.php">
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
                        <div class="row">
                            <div class="col-6">
                                <label for="modeloTransceiver" class="form-label">Modelo</label>
                                <input name="modeloTransceiver" type="text" class="form-control" id="modeloTransceiver">
                            </div>

                            <div class="col-6">
                                <label for="descricaoTransceiver" class="form-label">Descrição</label>
                                <input name="descricaoTransceiver" type="text" class="form-control" id="descricaoTransceiver">
                            </div>
                        </div>

                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger">Salvar</button>
                            <button type="reset" class="btn btn-secondary">Limpar</button>
                        </div>
                    </form>
                </div>

                <div id="bateriaForm" style="display: none;">
                    <form method="POST" action="processa/add_bateria.php">
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
                        <div class="row">
                            <div class="col-4">
                                <label for="modeloBateria" class="form-label">Modelo</label>
                                <input name="modeloBateria" type="text" class="form-control" id="modeloBateria">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="tensaoBateria" class="form-label">Tensão Bateria</label>
                                <select name="tensaoBateria" class="form-select">
                                    <option selected disabled>Selecione</option>
                                    <option value="12">12v</option>
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="amperagemBateria" class="form-label">Amperagem Bateria</label>
                                <select name="amperagemBateria" class="form-select">
                                    <option selected disabled>Selecione</option>
                                    <option value="115">115Ah</option>
                                </select>
                            </div>
                        </div>

                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger">Salvar</button>
                            <button type="reset" class="btn btn-secondary">Limpar</button>
                        </div>
                    </form>
                </div>

                <div id="equipamentoForm" style="display: none;">
                    <form method="POST" action="processa/add_equipamento.php">
                        <div class="row">
                            <div class="col-6">
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
                        </div>
                        <br>
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

<?php
require "js.php";
require "../../../includes/footer.php";
?>