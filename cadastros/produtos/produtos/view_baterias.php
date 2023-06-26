<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao_pdo.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    $sql_bateria =
        "SELECT
        pb.id as 'id',
        pb.modelo as 'modelo',
        f.fabricante as 'fabricante',
        pb.tensao as 'tensao',
        pb.amperagem as 'amperagem',
        pb.fabricante_id as 'fabricante_id',
        pb.active as 'active'
        FROM
        produtos_bateria as pb
        LEFT JOIN
        fabricante as f
        ON
        f.id = pb.fabricante_id
        WHERE
        pb.id = $id";

    $r_bateria = $pdo->query($sql_bateria);
    $c_bateria = $r_bateria->fetch(PDO::FETCH_ASSOC);

    $sql_fabricante =
        "SELECT
        f.id as 'id',
        f.fabricante as 'fabricante'
        FROM
        fabricante as f
        WHERE
        f.deleted = 1
        ORDER BY
        f.fabricante ASC";
    $r_fabricante = $pdo->query($sql_fabricante);
    $fabricantes = $r_fabricante->fetchAll(PDO::FETCH_ASSOC);

    $bateria_unit =
        "SELECT
        pbu.id as 'id',
        pt.modelo as 'modelo',
        pbu.patrimonio as 'patrimonio',
        pbu.n_serie as 'serie',
        CASE
        WHEN pbu.active = 1 THEN 'Ativo'
        WHEN pbu.active = 0 THEN 'Inativo'
        END as 'active',
        CASE
        WHEN pbu.disponibilidade = 1 THEN 'Disponivel'
        WHEN pbu.disponibilidade = 0 THEN 'Indisponivel'
        END as 'disponibilidade',
        date_format(pbu.created,'%H:%i:%s %d/%m/%Y') as created
        FROM
        produtos_bateria_units as pbu
        LEFT JOIN
        produtos_bateria as pt
        ON
        pt.id = pbu.produto_bateria_id
        WHERE
        pbu.produto_bateria_id = $id
        ";
}
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Bateria</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <h5 class="card-title"><?= $c_bateria['fabricante'] ?> - <?= $c_bateria['modelo'] ?></h5>
                            </div>
                            <div class="col-lg-4">
                                <a href="/cadastros/produtos/produtos/index.php">
                                    <button style="margin-top: 15px" type="button" class="btn btn-danger">
                                        Lista Produtos
                                    </button>
                                </a>
                            </div>
                        </div>
                        <!-- Default Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="dados-tab" data-bs-toggle="tab" data-bs-target="#dados" type="button" role="tab" aria-controls="dados" aria-selected="true">Dados</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="unidades-tab" data-bs-toggle="tab" data-bs-target="#unidades" type="button" role="tab" aria-controls="unidades" aria-selected="false">Unidades</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                                <form id="bateriasEditarForm">

                                    <input hidden readonly value="<?= $id ?>" id="idBateria" name="idBateria"></input>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="inputFabricante" class="form-label">Fabricante</label>
                                            <select name="fabricante" class="form-select">
                                                <option selected disabled>Selecione</option>
                                                <?php foreach ($fabricantes as $fabricante) : ?>
                                                    <option value="<?= $fabricante['id'] ?>" <?= ($fabricante['id'] == $c_bateria['fabricante_id']) ? 'selected' : '' ?>><?= $fabricante['fabricante'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-4">
                                            <label class="form-check-label">Ativar/Inativar</label>
                                            <div class="form-check">
                                                <input name="ativo" class="form-check-input" type="checkbox" <?= ($c_bateria['active'] == '1') ? 'checked' : '' ?>>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="modeloBateria" class="form-label">Modelo</label>
                                            <input name="modeloBateria" type="text" class="form-control" id="modeloBateria" value="<?= $c_bateria['modelo'] ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="tensaoBateria" class="form-label">Tensão Bateria</label>
                                            <select name="tensaoBateria" class="form-select">
                                                <option selected disabled>Selecione</option>
                                                <option value="12" <?= ($c_bateria['tensao'] == '12') ? 'selected' : '' ?>>12v</option>
                                            </select>
                                        </div>

                                        <div class="col-4">
                                            <label for="amperagemBateria" class="form-label">Amperagem Bateria</label>
                                            <select name="amperagemBateria" class="form-select">
                                                <option selected disabled>Selecione</option>
                                                <option value="115" <?= ($c_bateria['amperagem'] == '115') ? 'selected' : '' ?>>115Ah</option>
                                            </select>
                                        </div>
                                    </div>

                                    <br>
                                    <span id="msgEditarBateria"></span>
                                    <div class="text-center">
                                        <input id="btnEditarBateria" name="btnEditarBateria" type="button" value="Salvar Alterações" class="btn btn-danger"></input>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="unidades" role="tabpanel" aria-labelledby="unidades-tab">
                                <div class="ml-auto">
                                    <button title="Adicionar unidade" type="button" class="btn btn-info rounded-circle position-absolute top-0 end-0 mt-3 me-5" data-bs-toggle="modal" data-bs-target="#modalAdicionarUnidadeBateria">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>

                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Modelo</th>
                                            <th scope="col">Patrimônio</th>
                                            <th scope="col">Nº Série</th>
                                            <th scope="col">Criado</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Disponibilidade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Preenchendo a tabela com os dados do banco: -->
                                        <?php

                                        $r_bateria_unit = mysqli_query($mysqli, $bateria_unit) or die("Erro ao retornar dados");

                                        // Obtendo os dados por meio de um loop while
                                        while ($c_bateria_unit = $r_bateria_unit->fetch_array()) {
                                            $id = $c_bateria_unit['id']; ?>
                                            <tr id="tabelaLista">
                                                <td><?= $c_bateria_unit['modelo']; ?></td>
                                                <td><?= $c_bateria_unit['patrimonio']; ?></td>
                                                <td><?= $c_bateria_unit['serie']; ?></td>
                                                <td><?= $c_bateria_unit['created']; ?></td>
                                                <td><?= $c_bateria_unit['active']; ?></td>
                                                <td><?= $c_bateria_unit['disponibilidade']; ?></td>
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

</main><!-- End #main -->

<div class="modal fade" id="modalAdicionarUnidadeBateria" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="col-12 text-center">
                        <form method="POST" action="processa/add_unit_bateria.php">
                            <input value="<?= $_GET['id'] ?>" readonly hidden name="bateriaID" id="bateriaID"></input>
                            <div class="row">
                                <div class="col-6">
                                    <label for="patrimonioBateria" class="form-label">Patrimônio</label>
                                    <input name="patrimonioBateria" type="text" class="form-control" id="patrimonioBateria" data-check-url="processa/verificar_patrimonio_bateria.php">

                                </div>

                                <div class="col-6">
                                    <label for="nSerieBateria" class="form-label">Número de Série</label>
                                    <input required name="nSerieBateria" type="text" class="form-control" id="nSerieBateria">
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
    </div>
</div><!-- End Basic Modal-->


<?php
require "js_baterias.php";
require "../../../includes/footer.php";
?>