<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao.php";
require "sql.php";

$id_equipamento = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$result = "SELECT
eqp.id as id,
fab.id as idfabricante,
eqp.equipamento as equipamento,
fab.fabricante as fabricante,
eqp.deleted as deleted,
date_format(eqp.criado,'%H:%m:%s %d/%m/%Y') as criado,
date_format(eqp.modificado,'%H:%m:%s %d/%m/%Y') as modificado
FROM equipamentos AS eqp
left join fabricante as fab
on fab.id = eqp.fabricante
WHERE eqp.id = '$id_equipamento'";

$resultado = mysqli_query($mysqli, $result);
$row = mysqli_fetch_assoc($resultado);
?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">


                        <div class="row">
                            <div class="col-lg-8">
                                <h5 class="card-title"><?= $row['fabricante']; ?> - <?= $row['equipamento']; ?> </h5>
                            </div>
                            <div class="col-lg-4">
                                <a href="/cadastros/produtos/produtos/index.php">
                                    <button style="margin-top: 15px" type="button" class="btn btn-danger">
                                        Lista Produtos
                                    </button>
                                </a>
                            </div>
                        </div>

                        <!-- Multi Columns Form -->
                        <form method="POST" id="formEditarEquipamento">
                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                            <div class="row">
                                <div class="col-2">
                                    <label for="codigo" class="col-form-label">Código</label>
                                    <input name="codigo" type="text" class="form-control" id="codigo" value="<?= $row['id']; ?>" disabled>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label for="inputEquipamento" class="col-sm-12 col-form-label">Equipamento</label>
                                    <input name="equipamento" type="text" class="form-control" id="inputEquipamento" value="<?= $row['equipamento']; ?>">
                                </div>

                                <div class="col-4">
                                    <label for="inputFabricante" class="form-label">Fabricante</label>
                                    <select name="fabricante" class="form-select" aria-label="Default select example">
                                        <option value="<?= $row['idfabricante']; ?>"><?= $row['fabricante']; ?></option>
                                        <?php
                                        $resultado = mysqli_query($mysqli, $sql_fabricante) or die("Erro ao retornar dados");
                                        while ($c = $resultado->fetch_assoc()) : ?>
                                            <option value="<?= $c['id']; ?>"><?= $c['fabricante']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label class="form-check-label">Ativar/Inativar</label>
                                    <div class="form-check">
                                        <input name="ativo" class="form-check-input" type="checkbox" <?= ($row['deleted'] == '1') ? 'checked' : '' ?>>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-lg-12">
                                <label for="inputTipoEquipamento" class="form-label">Tipo de equipamento</label>
                                <div class="row justify-content-between">
                                    <?php
                                    $sql_lista_tipo =
                                        "SELECT
                                    te.id as id_tipo,
                                    te.tipo as tipo
                                FROM
                                    tipoequipamento as te
                                WHERE
                                    te.deleted = 1
                                ORDER BY
                                    te.tipo ASC    
                                ";

                                    $r_lista_tipo = mysqli_query($mysqli, $sql_lista_tipo);

                                    while ($campos_tipo = $r_lista_tipo->fetch_array()) {
                                        $id_tipo = $campos_tipo['id_tipo'];

                                        $sql_PO =
                                            "SELECT
                                            count(*) as countPO,
                                            ea.id as idAtributoAtivo
                                        FROM
                                            equipamentos_atributos as ea
                                        WHERE
                                            ea.equipamento_id = $id_equipamento
                                            and
                                            ea.tipoequipamento_id = $id_tipo
                                            and
                                            ea.active = 1";

                                        $r_sql_PO = mysqli_query($mysqli, $sql_PO);
                                        $campos_PO = $r_sql_PO->fetch_array();
                                    ?>
                                        <div class="col-3">
                                            <div class="form-check">
                                                <?php
                                                if ($campos_PO['countPO'] == 1) { ?>
                                                    <input onclick="removerAtributo(<?= $campos_PO['idAtributoAtivo'] ?>)" class="form-check-input" type="checkbox" id="tipo<?= $campos_tipo['tipo'] ?>" checked="" data-bs-toggle="modal" data-bs-target="#modalRemoverAtributo">
                                                <?php } else { ?>
                                                    <input onclick="permitirAtributo(<?= $id_equipamento ?>, '<?= $id_tipo ?>')" class="form-check-input" type="checkbox" id="tipo<?= $campos_tipo['tipo'] ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirAtributo">
                                                <?php } ?>
                                                <label class="form-check-label" for="tipo<?= $campos_tipo['id_tipo'] ?>"><?= $campos_tipo['tipo'] ?></label>
                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-3">
                                    <label class="form-label">Data criação</label>
                                    <input type="text" class="form-control" value="<?= $row['criado']; ?>" disabled>
                                </div>

                                <div class="col-3">
                                    <label class="form-label">última modificação</label>
                                    <input type="text" class="form-control" value="<?= $row['modificado']; ?>" disabled>
                                </div>
                            </div>
                            <br>
                            <span id="msgEditarEquipamento"></span>
                            <div class="text-center">
                                <input id="btnEditarEquipamento" name="btnEditarEquipamento" type="button" value="Salvar Alterações" class="btn btn-danger"></input>
                            </div>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->

<?php
require "js_equipamentos.php";
require "modalRemoveAtributo.php";
require "modalPermiteAtributo.php";
require "../../../includes/footer.php";
?>