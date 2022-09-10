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
eqp.criado as criado,
eqp.modificado as modificado
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

                            <div class="col-4">
                                <label for="inputEquipamento" class="col-sm-12 col-form-label">Equipamento</label>
                                <input name="equipamento" type="text" class="form-control" id="inputEquipamento" value="<?php echo $row['equipamento']; ?>">
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

                            <div class="col-2">
                                <label  class="col-sm-12 col-form-label">Tipo rack</label>
                                <input disabled type="text" class="form-control" value="<?php if ($row['rack'] == '1') {echo "Sim";} else {echo "Não";}  ?>">
                            </div>

                            <?php
                            if ($row['rack'] == 1) { ?>
                                <div class="col-2">
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




                            <div class="col-6">
                                <label for="inputTipoEquipamento" class="form-label">Tipo de equipamento</label>
                                <ul class="list-group" style="list-style: none;">

                                    <?php
                                    $sql_lista_tipo =
                                        "SELECT
                                    ea.active as active,
                                    te.tipo as tipo,
                                    te.id as id_tipo,
                                    ea.id as id_eq
                                    FROM
                                    equipamentos_atributos as ea
                                    LEFT JOIN
                                    tipoequipamento as te
                                    ON
                                    te.id = ea.tipoequipamento_id
                                    WHERE
                                    ea.equipamento_id = '$id_equipamento'
                                    ORDER BY
                                    te.tipo ASC
                                    ";

                                    $resultado = mysqli_query($mysqli, $sql_lista_tipo);
                                    while ($campo = $resultado->fetch_assoc()) : ?>
                                        <li>
                                            <input id="atributo<?= $campo['id_eq']; ?>" onclick="let id_eq = capturaID(<?= $campo['id_eq']; ?>) ; salvaAtributos(<?= $id_equipamento ?>,<?= $campo['id_tipo']; ?>, id_eq);" class="form-check-input me-1" name="<?= $campo['tipo']; ?>" type="checkbox" value="1" <?= $campo['active'] == 1 ? "checked" : "" ?>>
                                            <label for="<?= $campo['tipo']; ?>"><?= $campo['tipo']; ?></label>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            </div>

                            <div class="col-6"></div>

                            <div class="col-4">
                                <label for="dateCreated" class="form-label">Data criação</label>
                                <input name="dateCreated" type="text" class="form-control" id="dateCreated" value="<?php echo $row['criado']; ?>" disabled>
                            </div>

                            <div class="col-md-6">
                                <label for="dateModified" class="form-label">última modificação</label>
                                <div class="col-sm-6">
                                    <input name="dateModified" type="text" class="form-control" id="dateModified" value="<?php echo $row['modificado']; ?>" disabled>
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
require "../../../includes/footer.php";
?>