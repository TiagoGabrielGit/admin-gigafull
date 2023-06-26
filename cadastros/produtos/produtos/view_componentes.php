<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao_pdo.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    $sql_componentes =
        "SELECT
        pt.id as 'id',
        pt.modelo as 'modelo',
        f.fabricante as 'fabricante',
        pt.descricao as 'descricao',
        pt.fabricante_id as 'fabricante_id',
        pt.active as 'active'
        FROM
        produtos_componentes as pt
        LEFT JOIN
        fabricante as f
        ON
        f.id = pt.fabricante_id
        WHERE
        pt.id = $id";

    $r_componentes = $pdo->query($sql_componentes);
    $c_componentes = $r_componentes->fetch(PDO::FETCH_ASSOC);

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

    $componente_unit =
        "SELECT
            pcu.id as 'id',
            pt.modelo as 'modelo',
            pcu.patrimonio as 'patrimonio',
            pcu.n_serie as 'serie',
            CASE
            WHEN pcu.active = 1 THEN 'Ativo'
            WHEN pcu.active = 0 THEN 'Inativo'
            END as 'active',
            CASE
            WHEN pcu.disponibilidade = 1 THEN 'Disponivel'
            WHEN pcu.disponibilidade = 0 THEN 'Indisponivel'
            END as 'disponibilidade',
            date_format(pcu.created,'%H:%i:%s %d/%m/%Y') as created
            FROM
            produtos_componente_units as pcu
            LEFT JOIN
            produtos_componentes as pt
            ON
            pt.id = pcu.produto_componente_id
            WHERE
            pcu.produto_componente_id = $id
            ";
}
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>componentes</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <h5 class="card-title"><?= $c_componentes['fabricante'] ?> - <?= $c_componentes['modelo'] ?></h5>
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
                                <form id="componentesEditarForm">

                                    <input hidden readonly value="<?= $id ?>" id="idComponentes" name="idComponentes"></input>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="inputFabricante" class="form-label">Fabricante</label>
                                            <select name="fabricante" class="form-select">
                                                <option selected disabled>Selecione</option>
                                                <?php foreach ($fabricantes as $fabricante) : ?>
                                                    <option value="<?= $fabricante['id'] ?>" <?= ($fabricante['id'] == $c_componentes['fabricante_id']) ? 'selected' : '' ?>><?= $fabricante['fabricante'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-4">
                                            <label class="form-check-label">Ativar/Inativar</label>
                                            <div class="form-check">
                                                <input name="ativo" class="form-check-input" type="checkbox" <?= ($c_componentes['active'] == '1') ? 'checked' : '' ?>>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="modeloComponentes" class="form-label">Modelo</label>
                                            <input name="modeloComponentes" type="text" class="form-control" id="modeloComponentes" value="<?= $c_componentes['modelo'] ?>">
                                        </div>
                                        <div class="col-4">
                                            <label for="modeloDescricao" class="form-label">Modelo</label>
                                            <input name="modeloDescricao" type="text" class="form-control" id="modeloDescricao" value="<?= $c_componentes['descricao'] ?>">
                                        </div>
                                    </div>
                                    <br>
                                    <span id="msgEditarComponentes"></span>
                                    <div class="text-center">
                                        <input id="btnEditarComponentes" name="btnEditarComponentes" type="button" value="Salvar Alterações" class="btn btn-danger"></input>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="unidades" role="tabpanel" aria-labelledby="unidades-tab">
                                <div class="ml-auto">
                                    <button title="Adicionar unidade" type="button" class="btn btn-info rounded-circle position-absolute top-0 end-0 mt-3 me-5" data-bs-toggle="modal" data-bs-target="#modalAdicionarUnidadeComponente">
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

                                        $r_componente_unit = mysqli_query($mysqli, $componente_unit) or die("Erro ao retornar dados");

                                        // Obtendo os dados por meio de um loop while
                                        while ($c_componente_unit = $r_componente_unit->fetch_array()) {
                                            $id = $c_componente_unit['id']; ?>
                                            <tr id="tabelaLista">
                                                <td><?= $c_componente_unit['modelo']; ?></td>
                                                <td><?= $c_componente_unit['patrimonio']; ?></td>
                                                <td><?= $c_componente_unit['serie']; ?></td>
                                                <td><?= $c_componente_unit['created']; ?></td>
                                                <td><?= $c_componente_unit['active']; ?></td>
                                                <td><?= $c_componente_unit['disponibilidade']; ?></td>
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

<div class="modal fade" id="modalAdicionarUnidadeComponente" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="col-12 text-center">
                        <form method="POST" action="processa/add_unit_componente.php">
                            <input value="<?= $_GET['id'] ?>" readonly hidden name="componenteID" id="componenteID"></input>
                            <div class="row">
                                <div class="col-6">
                                    <label for="patrimonioComponente" class="form-label">Patrimônio</label>
                                    <input name="patrimonioComponente" type="text" class="form-control" id="patrimonioComponente" data-check-url="processa/verificar_patrimonio_componente.php">

                                </div>

                                <div class="col-6">
                                    <label for="nSerieComponente" class="form-label">Número de Série</label>
                                    <input required name="nSerieComponente" type="text" class="form-control" id="nSerieComponente">
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
require "js_componentes.php";
require "../../../includes/footer.php";
?>