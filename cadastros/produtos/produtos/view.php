<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao.php";
require "sql.php";

$id_equipamento = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$result = "SELECT
eqp.id as id,
fab.id as idfabricante,
eqp.rack as rack,
eqp.tamanho as tamanho,
eqp.equipamento as equipamento,
fab.fabricante as fabricante,
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
                        <h5 class="card-title"><?= $row['fabricante']; ?> - <?= $row['equipamento']; ?> </h5>

                        <!-- Multi Columns Form -->
                        <form method="POST" action="processa/edit.php" class="row g-3">
                            <input type="hidden" name="id" value="<?= $row['id']; ?>">

                            <div class="row mb-3">
                                <label for="codigo" class="col-sm-12 col-form-label">Código</label>
                                <div class="col-sm-2">
                                    <input name="codigo" type="text" class="form-control" id="codigo" value="<?php echo $row['id']; ?>" disabled>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="inputEquipamento" class="col-sm-12 col-form-label">Equipamento</label>
                                        <input name="equipamento" type="text" class="form-control" id="inputEquipamento" value="<?php echo $row['equipamento']; ?>">
                                    </div>

                                    <div class="col-6">
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
                                </div>

                                <div class="row">
                                    <div class="col-5">
                                        <label class="col-sm-12 col-form-label">Tipo rack</label>
                                        <input disabled type="text" class="form-control" value="<?php if ($row['rack'] == '1') {
                                                                                                    echo "Sim";
                                                                                                } else {
                                                                                                    echo "Não";
                                                                                                }  ?>">
                                    </div>

                                    <?php
                                    if ($row['rack'] == 1) { ?>
                                        <div class="col-5">
                                            <label for="inputTamanho" class="form-label">Tamanho (U)</label>
                                            <select name="inputTamanho" class="form-select" aria-label="Default select example">
                                                <option value="<?= $row['tamanho']; ?>"><?= $row['tamanho']; ?>U</option>
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
                                            </select>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-2"> </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="col-lg-8">
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

                            <div class="row">
                                <div class="col-2">
                                    <label class="form-label">Data criação</label>
                                    <input type="text" class="form-control" value="<?= $row['criado']; ?>" disabled>
                                </div>

                                <div class="col-2">
                                    <label class="form-label">última modificação</label>
                                    <input type="text" class="form-control" value="<?= $row['modificado']; ?>" disabled>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-danger">Salvar</button>
                                <a href="/cadastros/produtos/produtos/index.php"><input type="button" value="Voltar" class="btn btn-secondary"></a>
                            </div>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    function capturaID(id_eq) {
        return document.querySelector(`#atributo${id_eq}`).checked
    }

    function salvaAtributos(id_equipamento, id_tipoequipamento, checked) {
        console.log(id_equipamento, id_tipoequipamento, checked)

        if (checked) {
            checked = 1;
        } else {
            checked = 0;
        }

        var settings = {
            "url": "processa/api.php",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            "data": {
                "id_equipamento": id_equipamento,
                "id_tipoequipamento": id_tipoequipamento,
                "active": checked
            },
        };

        $.ajax(settings).done(function(response) {
            console.log(response);
        });
    }
</script>


<?php
require "modalRemoveAtributo.php";
require "modalPermiteAtributo.php";
require "../../../includes/footer.php";
?>